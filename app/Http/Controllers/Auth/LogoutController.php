<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Log out authenticated user.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out user.',
        ]);
    }
}
