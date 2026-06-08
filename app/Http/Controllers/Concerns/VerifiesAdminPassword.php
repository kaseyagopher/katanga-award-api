<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

trait VerifiesAdminPassword
{
    protected function verifyAdminPassword(Request $request): void
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $admin = Auth::guard('admin')->user();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'password' => ['Mot de passe administrateur incorrect.'],
            ]);
        }
    }
}
