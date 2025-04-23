<?php

namespace App\Repositories\data;

use Exception;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Traits\Jwt;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Contracts\AuthControllerRepository;
use App\Notifications\ActivationNotification;
use App\Notifications\ResetPasswordNotification;

class AuthControllerRepositoryData implements AuthControllerRepository
{
    use HttpResponses, Jwt;

    public function getUserFromToken()
    {
        try {
            $user = $this->getUserFromJWT();
            if (!$user) {
                return $this->error(null, 'Invalid token or user not found', 401);
            }
            return $this->success(['user' => $user]);
        } catch (Exception $e) {
            return $this->error(null, 'Failed to get user: ' . $e->getMessage(), 500);
        }
    }

    public function loginUser(array $credentials)
    {
        $validator = Validator::make($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation failed', 422);
        }

        if (!Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            if (!$user) {
                return $this->error(null, 'Email not found', 401);
            }
            if (!Hash::check($credentials['password'], $user->password)) {
                return $this->error(null, 'Password is incorrect', 401);
            }
            return $this->error(null, 'Invalid credentials', 401);
        }
        $token = $this->jwtToken($credentials);
        if (!Auth::user()) {
            return $this->error(null, 'Authentication failed', 401);
        }
        return $this->success([
            'token' => $token,
            'user' => Auth::user(),
        ], 'Login successful');
    }

    public function registerUser(array $userData)
    {
        $validator = Validator::make($userData, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation failed', 422);
        }

        try {
            $token = Str::random(60);
            $roleId = $this->getRoleIdByName('owner');
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'role_id' => $roleId,
                'activation_token' => $token,
                'password' => Hash::make($userData['password']),
            ]);
            // Envoyer un e-mail d'activation
            if ($user) {
                $user->notify(new ActivationNotification($token));
            }
            return $this->success([
                'user' => $user,
                'token' => $this->jwtToken(['email' => $user->email, 'password' => $userData['password']]),
            ], 'User registered successfully', 201);
        } catch (Exception $e) {
            return $this->error(null, 'User registration failed: ' . $e->getMessage(), 500);
        }
    }

    public function activateUserAccount(string $token)
    {
        $validator = Validator::make(['token' => $token], [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Invalid token format', 422);
        }

        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return $this->error(null, 'Invalid token', 400);
        }
        try {
            $user->update(['activated' => true, 'activation_token' => null, 'email_verified_at' => now()]);
            return $this->success(
                null,
                'Account activated successfully'
            );
        } catch (Exception $e) {
            return $this->error(null, 'Account activation failed: ' . $e->getMessage(), 500);
        }
    }

    public function logoutUser()
    {
        try {
            if ($this->invalidateToken()) {
                return $this->success(['token' => $this->getToken(), 'user' => Auth::user()], 'Successfully logged out');
            }
        } catch (Exception $e) {
            return $this->error(null, 'Logout failed: ' . $e->getMessage(), 500);
        }
    }

    public function sendPasswordResetLink(string $email)
    {
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation failed', 422);
        }

        try {
            $token = Str::random(60);
            $user = User::where('email', $email)->first();
            $user->notify(new ResetPasswordNotification($token));
            PasswordResetToken::updateOrCreate(
                ['email' => $email],
                ['token' => $token, 'created_at' => now()]
            );
            return $this->success(null, 'Password reset email sent.');
        } catch (Exception $e) {
            return $this->error(null, 'Failed to send reset email: ' . $e->getMessage(), 500);
        }
    }

    public function resetUserPassword(string $token, string $password)
    {
        $validator = Validator::make(
            ['token' => $token, 'password' => $password],
            [
                'token' => 'required|string',
                'password' => 'required|string|min:8',
            ]
        );

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation failed', 422);
        }

        $reset = PasswordResetToken::where('token', $token)->first();

        if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return $this->error(null, 'Invalid or expired token', 400);
        }

        try {
            $user = User::where('email', $reset->email)->firstOrFail();
            $user->update(['password' => Hash::make($password)]);
            PasswordResetToken::where('token', $token)->delete();
            return $this->success(null, 'Password successfully reset.');
        } catch (Exception $e) {
            return $this->error(null, 'Password reset failed: ' . $e->getMessage(), 500);
        }
    }

    public function updateUserImage($image)
    {
        $validator = Validator::make(['image' => $image], [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Invalid image format or size', 422);
        }

        try {
            $user = Auth::user();
            if (!$user) {
                return $this->error(null, 'User not authenticated', 401);
            }

            $path = $image->store('profile_images', 'public');
            // Supprimer l'ancienne image si elle existe
            if ($user->image) {
                $oldImagePath = public_path("storage/{$user->image}");
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            // Mettre à jour le chemin de l'image dans la base de données
            if (User::where('id', $user->id)->update(['image' => $path])) {
                return $this->success([
                    'user' => $user,
                    'image_path' => $path
                ], 'Profile image updated successfully');
            }
            return $this->error(null, 'Failed to update image', 400);
        } catch (Exception $e) {
            return $this->error(null, 'Failed to update profile image: ' . $e->getMessage(), 500);
        }
    }

    public function getRoleIdByName(string $roleName)
    {
        $validator = Validator::make(['role_name' => $roleName], [
            'role_name' => 'required|string|exists:roles,name',
        ]);

        if ($validator->fails()) {
            // Instead of returning error, we will log it and return null
            \Log::warning('Invalid role name requested: ' . $roleName);
            return null;
        }

        // Assurez-vous que le rôle existe avant d'essayer de récupérer son ID
        $role = Role::where('name', $roleName)->first();
        return $role ? $role->id : null;
    }
}
