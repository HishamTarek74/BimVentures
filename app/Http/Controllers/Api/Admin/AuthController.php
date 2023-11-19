<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function login(LoginRequest $request)
    {
        $admin = Admin::firstWhere('email', $request->email);

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['error' => trans('auth.failed')], 442);
        }

        return $this->getAuthUserResponse($admin->fresh());
    }

    private function getAuthUserResponse(Admin $admin)
    {
        return $admin->getResource()->additional([
            'token' => $admin->createTokenForDevice(request()->header('user-agent')),
        ]);
    }

}
