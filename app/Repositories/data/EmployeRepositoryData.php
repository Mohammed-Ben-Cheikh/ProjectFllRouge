<?php

namespace App\Repositories\data;

use App\Models\Entreprise;
use App\Traits\Jwt;
use App\Models\Riad;
use App\Models\User;
use App\Models\Employe;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ActivationNotification;
use App\Repositories\Contracts\EmployeRepository;

class EmployeRepositoryData implements EmployeRepository
{
    use HttpResponses, Jwt;

    public function all()
    {
        $employes = Employe::with(['user', 'riad', 'entreprise'])->get();
        return $this->success(['employes' => $employes], 'Employes retrieved successfully', 200);
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation failed', 422);
        }
        $token = Str::random(60);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 3,
            'activation_token' => $token,
            'password' => Hash::make($data['password']),
        ]);
        // Envoyer un e-mail d'activation
        if ($user) {
            $user->notify(new ActivationNotification($token));
        }
        $employe = Employe::create([
            'riad_id' => $data['riad_id'],
            'entreprise_id' => $data['entreprise_id'],
            'user_id' => $user->id,
        ]);
        return $this->success(['employe' => $employe], 'Employe created successfully', 201);
    }

    public function delete(string $slug)
    {
        $employe = Employe::where('slug', $slug)->first();
        if (!$employe) {
            return $this->error('', 'Employe not found', 404);
        }
        $employe->delete();
        return $this->success('', 'Employe deleted successfully', 200);
    }

    public function findUser()
    {
        $user = auth()->user();
        if (!$user) {
            return $this->error(null, 'User not found', 404);
        }

        $employes = collect();
        $entreprises = Entreprise::where('user_id', $user->id)->get();

        foreach ($entreprises as $entreprise) {
            $entrepriseEmployes = Employe::where('employes.entreprise_id', $entreprise->id)
                ->join('users', 'users.id', '=', 'employes.user_id')
                ->join('riads', 'riads.id', '=', 'employes.riad_id')
                ->select('users.*', 'employes.*', 'riads.name as riad_name', 'entreprises.name as entreprise_name')
                ->join('entreprises', 'entreprises.id', '=', 'employes.entreprise_id')
                ->get();

            $employes = $employes->merge($entrepriseEmployes);
        }

        return $this->success(['employes' => $employes], 'Employes found successfully', 200);
    }
}
