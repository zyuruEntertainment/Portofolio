<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['title', 'slug', 'short_description', 'full_description', 'logo_path', 'preview_path', 'preview_type', 'status', 'github_url'])]
class Project extends Model
{
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
