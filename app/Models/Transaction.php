<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function account() {
        $this->belongsTo(Account::class);
    }

    public function category() {
        $this->belongsTo(Category::class);
    }
}
