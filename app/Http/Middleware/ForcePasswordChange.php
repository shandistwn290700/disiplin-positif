<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Kalau user sedang login dan masih wajib ganti password, paksa dia ke halaman
     * ganti password dulu sebelum bisa akses halaman lain manapun (kecuali logout).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->must_change_password
            && !$request->routeIs('force-password.edit')
            && !$request->routeIs('force-password.update')
            && !$request->routeIs('logout')) {
            return redirect()->route('force-password.edit');
        }

        return $next($request);
    }
}
