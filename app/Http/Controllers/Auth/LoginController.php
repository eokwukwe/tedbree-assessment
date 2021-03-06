<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Log in registered user.
     */
    public function __invoke(AuthRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid login credentials.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }
}
