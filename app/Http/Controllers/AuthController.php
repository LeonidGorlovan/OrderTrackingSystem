<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTokenRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function createToken(CreateTokenRequest $request)
    {
        $resultAuth = $this->authService->authAttempt(
            $request->email,
            $request->password,
        );

        if($resultAuth) {
            $this->authService->clearTokens(); // TODO Если необходимо закрыть другие сессии

            return response()->json([
                'result' => true,
                'token' => $this->authService->createToken('api')
            ]);
        }

        return response()->json([
            'result' => false,
            'message' => 'failed to get the token'
        ], 401);
    }

    public function clearCurrentAccessToken()
    {
        if($this->authService->clearCurrentAccessToken()) {
            return response()->json([
                'result' => true,
                'message' => ' succeeded in clearing the current token'
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'failed to clear the current token'
            ], 400);
        }
    }
}
