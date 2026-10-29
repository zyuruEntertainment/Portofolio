<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPasswordController extends Controller
{
    public function edit(): View
    {
        return view('admin.change-password');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password:admin'],
            'password' => [
                'required',
                'string',
                'min:12',
                'confirmed',
                'different:current_password',
            ],
        ]);

        /** @var Admin $admin */
        $admin = $request->user('admin');
        $admin->update(['password' => $validated['password']]);

        return redirect()
            ->route('admin.password.edit')
            ->with('status', 'Password updated successfully.');
    }
}
