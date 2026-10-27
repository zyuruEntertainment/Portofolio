<?php

namespace App\Http\Controllers;

use App\Models\AdminProfile;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profile', [
            'profile' => AdminProfile::query()->first(),
        ]);
    }
}
