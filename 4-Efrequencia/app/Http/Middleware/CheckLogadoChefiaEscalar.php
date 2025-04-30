<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogadoChefiaEscalar
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
        if (\AutenticacaoHelper::checkLogadoChefiaEscalar()) {
            return $next($request);
        }
        return redirect('/login');
    }
}
