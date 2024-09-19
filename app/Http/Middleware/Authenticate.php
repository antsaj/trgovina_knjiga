<?php

// app/Http/Middleware/Authenticate.php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Ako očekuje JSON, vrati null (ne radi redirekciju)
        if ($request->expectsJson()) {
            return null;
        }

        // Ako ne očekuje JSON, vrati rutu za prijavu
        return route('login');
    }
}
