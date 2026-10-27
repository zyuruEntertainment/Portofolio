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
}
