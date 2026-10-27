<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['title', 'slug', 'short_description', 'full_description', 'logo_path', 'preview_path', 'preview_type', 'status', 'github_url'])]
class Project extends Model
{
    public function githubRepositoryUrl(): ?string
    {
        if (! preg_match('/\Ahttps:\/\/github\.com\/[A-Za-z0-9_.-]+\/[A-Za-z0-9_.-]+\/?\z/i', (string) $this->github_url)) {
            return null;
        }

        return $this->github_url;
    }

    public static function uniqueSlug(string $title, ?self $except = null): string
    {
        $base = Str::slug($title) ?: 'project';
        $slug = $base;
        $suffix = 2;

        while (static::where('slug', $slug)->when($except, fn ($query) => $query->where('id', '!=', $except->getKey()))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
