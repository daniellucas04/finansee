<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'created_at',
        'updated_at',
    ];
}
