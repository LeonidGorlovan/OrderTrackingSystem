<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function authAttempt($email, $password, bool $remember = false): bool
    {
        $user = User::query()->where('email', $email)->first();

        if (!empty($user) && !empty(Hash::check($password, $user->password))) {
            Auth::login($user, $remember);
            return true;
        }

        return false;
    }

    public function createToken(string $tokenName): string|null
    {
        try {
            $token = Auth::user()->createToken($tokenName);
            return $token->plainTextToken;
        } catch (\Throwable $e) {
            Log::error($e);
            return null;
        }
    }

    public function clearCurrentAccessToken(): bool
    {
        try {
            Auth::user()->currentAccessToken()->delete();
            return true;
        } catch (\Throwable $e) {
            Log::error($e);
            return false;
        }
    }

    public function clearTokens(): bool
    {
        try {
            Auth::user()->tokens()->delete();
            return true;
        } catch (\Throwable $e) {
            Log::error($e);
            return false;
        }
    }
}
