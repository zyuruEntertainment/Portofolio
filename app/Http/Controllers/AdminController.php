<?php

namespace App\Http\Controllers;

use App\Models\AdminProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $availableSections = [
            'profile',
            'projects',
            'social-media',
        ];

        $requestedSection = $request->query('section', 'profile');

        $section = in_array(
            $requestedSection,
            $availableSections,
            true
        ) ? $requestedSection : 'profile';

        return view('admin.dashboard', [
            'section' => $section,
            'profile' => AdminProfile::query()->first(),
        ]);
    }
}
