<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService;
use App\Services\RegistrationService;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request, RegistrationService $service, AuthService $authService)
    {
        $postData = $request->validated();

        $service->createUser($postData);

        $resultAuth = $authService->authAttempt(
            $postData['email'],
            $postData['password'],
        );

        if($resultAuth) {
            return response()->json([
                'result' => true,
                'token' => $authService->createToken('api')
            ]);
        }

        return response()->json([
            'result' => false,
            'message' => 'failed to get the token'
        ], 401);
    }
}
