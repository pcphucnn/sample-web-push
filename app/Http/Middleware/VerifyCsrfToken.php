<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'http://43.207.83.230',
        'http://43.207.83.230/subscribe',
        'http://43.207.83.230/publish',
        'http://43.207.83.230/confirm',
    ];
}
