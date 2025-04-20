<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Traits\Jwt;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ActivationNotification;
use App\Notifications\ResetPasswordNotification;

class AuthController extends Controller
{
    use HttpResponses, Jwt;

    /**
     * Get the authenticated user.
     */
    public function getUser($token)
    {
        if (!$token) {
            return $this->error(null, 'Token not provided', 401);
        }
        try {
            $user = $this->getUserFromToken($token);
            if (!$user) {
                return $this->error(null, 'Invalid token or user not found', 401);
            }
            return $this->success(['user' => $user]);
        } catch (Exception $e) {
            return $this->error(null, 'Failed to get user: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Handle user login.
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();
        // Vérification des informations d'identification
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

    /**
     * Handle user registration.
     */
    public function register(StoreUserRequest $request)
    {
        try {
            $token = Str::random(60);
            // Vérification et attribution du rôle 'tourist'
            $roleId = static::getRoleId('owner');
            $user = User::create([
                'name' => $request->validated('name'),
                'email' => $request->validated('email'),
                'role_id' => $roleId,
                'activation_token' => $token,
                'password' => Hash::make($request->validated('password')),
            ]);
            // Envoyer un e-mail d'activation
            // if ($user) {
            //     $user->notify(new ActivationNotification($token));
            // }
            return $this->success([
                'user' => $user,
                'token' => $this->jwtToken(['email' => $user->email, 'password' => $request->password]),
            ], 'User registered successfully', 201);
        } catch (Exception $e) {
            return $this->error(null, 'User registration failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Activate user account.
     */
    public function activateAccount(Request $request)
    {
        $request->validate(['token' => 'required']);
        $user = User::where('activation_token', $request->token)->first();
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

    /**
     * Handle user logout.
     */
    public function logout()
    {
        try {
            if ($this->invalidateToken()) {
                return $this->success(['token' => $this->getToken(), 'user' => Auth::user()], 'Successfully logged out');
            }
        } catch (Exception $e) {
            return $this->error(null, 'Logout failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Send a password reset link via email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        try {
            $token = Str::random(60);
            PasswordResetToken::updateOrCreate(
                ['email' => $request->email],
                ['token' => $token, 'created_at' => now()]
            );
            $user = User::where('email', $request->email)->first();
            $user->notify(new ResetPasswordNotification($token));
            return $this->success(null, 'Password reset email sent.');
        } catch (Exception $e) {
            return $this->error(null, 'Failed to send reset email: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Reset user password.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Invalid input', 400);
        }

        $reset = PasswordResetToken::where('token', $request->token)->first();

        if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return $this->error(null, 'Invalid or expired token', 400);
        }

        try {
            $user = User::where('email', $reset->email)->firstOrFail();
            $user->update(['password' => Hash::make($request->password)]);
            PasswordResetToken::where('token', $request->token)->delete();
            return $this->success(null, 'Password successfully reset.');
        } catch (Exception $e) {
            return $this->error(null, 'Password reset failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update user profile image.
     */
    public function updateImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $user = Auth::user();
            if (!$user) {
                return $this->error(null, 'User not authenticated', 401);
            }
            if ($request->hasFile('image')) {
                $image = $request->file('image');
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
            }
            return $this->error(null, 'No image file provided', 400);
        } catch (Exception $e) {
            return $this->error(null, 'Failed to update profile image: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get the ID of a user role.
     */
    public static function getRoleId($role)
    {
        // Assurez-vous que le rôle existe avant d'essayer de récupérer son ID
        $role = Role::where('name', $role)->first();
        return $role ? $role->id : null;
    }
}
