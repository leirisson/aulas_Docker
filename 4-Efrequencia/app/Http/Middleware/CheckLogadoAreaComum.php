<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogadoAreaComum
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
        if (\AutenticacaoHelper::checkAreaComumLogado()) {
            return $next($request);
        }
        return redirect('/login');
    }
}
