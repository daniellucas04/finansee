<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'name',
        'balance',
        'created_at',
        'updated_at',
    ];
}
