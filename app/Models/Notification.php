<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'message', 'type', 'user_id', 'date', 'read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

