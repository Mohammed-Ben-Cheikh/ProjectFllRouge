<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Repositories\Contracts\AuthControllerRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponses;

    protected $authRepository;

    public function __construct(AuthControllerRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Get the authenticated user.
     */
    public function getUser()
    {
        return $this->authRepository->getUserFromToken();
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        return $this->authRepository->loginUser($credentials);
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $userData = $request->all();
        return $this->authRepository->registerUser($userData);
    }

    /**
     * Activate user account.
     */
    public function activateAccount(Request $request)
    {
        return $this->authRepository->activateUserAccount($request->token);
    }

    /**
     * Handle user logout.
     */
    public function logout()
    {
        return $this->authRepository->logoutUser();
    }

    /**
     * Send a password reset link via email.
     */
    public function sendResetLink(Request $request)
    {
        return $this->authRepository->sendPasswordResetLink($request->email);
    }

    /**
     * Reset user password.
     */
    public function resetPassword(Request $request)
    {
        return $this->authRepository->resetUserPassword($request->token, $request->password);
    }

    /**
     * Update user profile image.
     */
    public function updateImage(Request $request)
    {
        if ($request->hasFile('image')) {
            return $this->authRepository->updateUserImage($request->file('image'));
        }

        return $this->error(null, 'No image file provided', 400);
    }

    /**
     * Get the ID of a user role.
     */
    public static function getRoleId($role)
    {
        // Using repository to get role ID
        return app(AuthControllerRepository::class)->getRoleIdByName($role);
    }
}
