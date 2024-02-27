<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Soporte
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        if(session()->has('usuario')) {
            if(in_array(session('usuario')['TIPO'], $types)==false){
                if(in_array('Soporte-I', $types)){
                    if (session('usuario')['TIPO'] == 'Soporte' && session('usuario')['INFORMATICO'] == 'S') {
                        return $next($request);
                    }else{
                    return redirect()
                        ->route('Reportes General')
                        ->withErrors('¡Acceso Denegado!');
                    }
                }elseif(in_array('Soporte-J', $types)){
                    if (session('usuario')['TIPO'] == 'Soporte' && session('usuario')['INFORMATICO'] == 'J') {
                        return $next($request);
                    }else{
                    return redirect()
                        ->route('Reportes General')
                        ->withErrors('¡Acceso Denegado!');
                    }
                }
            }
            return $next($request);
        }
        return redirect('/login')->withErrors('Debe iniciar sesion');
    }
}
