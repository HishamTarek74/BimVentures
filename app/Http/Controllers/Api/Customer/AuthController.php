<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Requests\Customer\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    /**
     * Handle a login request to the application.
     *
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::whereEmail($request->email)->firstOrFail();
            return $this->getAuthUserResponse($user->fresh());
        }

        return response()->json(['error' => trans('auth.failed')], 442);
    }


    private function getAuthUserResponse(User $user)
    {
        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(request()->header('user-agent')),
        ]);
    }
}
