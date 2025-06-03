<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  

     public function handle(Request $request, Closure $next)
     {
         \Log::info('AdminOnly middleware aktif');
     
         if (Auth::guard('admin')->check()) {
             \Log::info('Guard admin: authenticated');
             return $next($request);
         }
     
         if (Auth::guard('web')->check()) {
             \Log::warning('Guard web: user mencoba akses admin!');
             abort(403, 'Akses ditolak: hanya admin yang dapat mengakses halaman ini.');
         }
     
         \Log::warning('Tidak login sama sekali!');
         abort(403, 'Anda harus login sebagai admin untuk mengakses halaman ini.');
     }
     

    
}
