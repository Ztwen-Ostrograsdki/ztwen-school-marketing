<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrMasterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()){

            $user = $request->user();
            
            if($user->isAdminsOrMaster()){
                
                return $next($request);
            }
            return abort(403, "Vous n'êtes pas authorisé");
        }
        return redirect(route('login'));
    }
}
