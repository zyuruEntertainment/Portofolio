<?php

namespace App\Http\Controllers;

use App\Models\AdminProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.edit-profile', [
            'profile' => AdminProfile::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'icon' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:500'],
            'overview' => ['required', 'string', 'max:5000'],
        ]);

        $profile = AdminProfile::current() ?? new AdminProfile;
        $previousIconPath = $profile->icon_path;

        if ($request->hasFile('icon')) {
            $newPath = $request->file('icon')
                ->store('profile-icons', 'public');

            if (! is_string($newPath)) {
                return back()
                    ->withErrors([
                        'icon' => 'The profile photo could not be uploaded. Please try again.',
                    ])
                    ->withInput();
            }

            $profile->icon_path = $newPath;
        }

        $profile->fill([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'overview' => $validated['overview'],
        ])->save();

        // Only remove the previous file once the new profile has been saved,
        // so a failed save never leaves the database pointing at a missing file.
        if ($previousIconPath && $previousIconPath !== $profile->icon_path) {
            Storage::disk('public')->delete($previousIconPath);
        }

        return redirect()
            ->route('admin.dashboard', ['section' => 'profile'])
            ->with('status', 'Profile saved successfully.');
    }
}
