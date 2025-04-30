<?php

namespace App\Http\Middleware;
use Closure;

class CheckLogadoAreaAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\AutenticacaoHelper::checkAreaAdminLogado()) {
            return $next($request);
        }
        return redirect('/login-admin');
    }
}
