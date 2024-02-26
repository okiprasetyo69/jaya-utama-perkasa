<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // '/items/create',
        // '/items/delete',
        // '/transactions/save',
        '/categories/save',
        '/categories/delete',

        '/product/save',
        '/product/delete',

        '/inventories/save',

    ];
}
