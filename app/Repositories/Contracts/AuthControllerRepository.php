<?php
namespace App\Repositories\Contracts;

interface AuthControllerRepository
{
    public function getUserFromToken();
    public function loginUser(array $credentials);
    public function registerUser(array $userData);
    public function activateUserAccount(string $token);
    public function logoutUser();
    public function sendPasswordResetLink(string $email);
    public function resetUserPassword(string $token, string $password);
    public function updateUserImage($image);
    public function getRoleIdByName(string $roleName);
}
