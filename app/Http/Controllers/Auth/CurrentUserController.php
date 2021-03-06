<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UsersResource;
use Illuminate\Http\Request;

class CurrentUserController extends Controller
{
    /**
     * Fetch currently logged in user.
     */
    public function __invoke(Request $request): UsersResource
    {
        return new UsersResource($request->user());
    }
}
