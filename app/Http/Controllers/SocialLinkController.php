<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    public function index(): View
    {
        $links = SocialLink::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->filter(fn (SocialLink $link): bool => $link->isValid())
            ->values();

        return view('social-media', [
            'links' => $links,
        ]);
    }
}
