<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

class PreventNullForContent extends ConvertEmptyStringsToNull
{
    protected $except = [
        'content',
    ];
}
