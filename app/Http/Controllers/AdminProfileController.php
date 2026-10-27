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
            'profile' => AdminProfile::query()->first(),
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

        $profile = AdminProfile::query()->firstOrNew(['id' => 1]);

        if ($request->hasFile('icon')) {
            $newPath = $request->file('icon')
                ->store('profile-icons', 'public');

            if ($profile->icon_path) {
                Storage::disk('public')->delete(
                    $profile->icon_path
                );
            }

            $profile->icon_path = $newPath;
        }

        $profile->name = $validated['name'];
        $profile->description = $validated['description'];
        $profile->overview = $validated['overview'];
        $profile->save();

        return redirect()
            ->route('admin.dashboard', ['section' => 'profile'])
            ->with('status', 'Profile berhasil disimpan.');
    }
}
