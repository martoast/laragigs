<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
{
    if ($request->expectsJson()) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized. Please log in.',
        ], 401);
    }

    return abort(401, 'Unauthorized. Please log in.');
}
}
