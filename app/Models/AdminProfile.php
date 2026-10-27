<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    protected $fillable = [
        'icon_path',
        'name',
        'description',
        'overview',
    ];

    /**
     * Get the single profile managed by the admin dashboard.
     */
    public static function current(): ?self
    {
        return static::query()->orderBy('id')->first();
    }
}
