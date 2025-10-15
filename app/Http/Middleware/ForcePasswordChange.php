<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange{
    /**
     * Handle an incoming request.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{
        // Kas kasutaja peab parooli muutma?
        if(Auth::check() && Auth::user()->must_change_password){
             // Luba ligipääs ainult parooli muutmise lehele ja logi välja lehele
             $allowed = [
                 'admin.password.change', // Parooli muutmise vorm GET
                 'admin.password.update', // Parooli uuendamine PUT
                 'logout',          // Logi välja POST
             ];

             if(!$request->routeIs($allowed)){
                 return redirect()->route('admin.password.change')
                 ->with('status','Palun muuda oma parooli!');
             }
        }
        return $next($request);
    }
}
