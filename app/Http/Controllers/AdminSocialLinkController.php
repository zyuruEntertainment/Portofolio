<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AdminSocialLinkController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.social-links.index', [
            'links' => SocialLink::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.social-links.form', ['link' => new SocialLink]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if (! array_key_exists('sort_order', $data)) {
            $data['sort_order'] = (SocialLink::max('sort_order') ?? 0) + 1;
        }

        SocialLink::create($data);

        return redirect()
            ->route('admin.dashboard', ['section' => 'social-media'])
            ->with('status', 'Social media link added.');
    }

    public function edit(SocialLink $link): View
    {
        return view('admin.social-links.form', compact('link'));
    }

    public function update(Request $request, SocialLink $link): RedirectResponse
    {
        $data = $this->validated($request);
        $link->update($data);

        return redirect()
            ->route('admin.dashboard', ['section' => 'social-media'])
            ->with('status', 'Social media link updated.');
    }

    public function destroy(SocialLink $link): RedirectResponse
    {
        $link->delete();

        return redirect()
            ->route('admin.dashboard', ['section' => 'social-media'])
            ->with('status', 'Social media link removed.');
    }

    private function validated(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'platform' => ['required', 'string', 'in:'.implode(',', array_keys(SocialLink::$platforms))],
            'url' => ['required', 'url', 'max:2048'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ], [
            'url.url' => 'The social media link must be a valid URL.',
        ]);

        $validator->after(function ($validator) use ($request): void {
            $link = new SocialLink([
                'platform' => $request->input('platform'),
                'url' => $request->input('url'),
            ]);

            if (! $link->isValid()) {
                $validator->errors()->add('url', 'The link does not match the selected social media platform.');
            }
        });

        return $validator->validated();
    }
}
