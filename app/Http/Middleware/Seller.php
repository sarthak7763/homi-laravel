<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Route;
use Mail;

class Seller{
  
    public function handle($request, Closure $next) {
   
        
        if (Auth::user() && Auth::user()->user_type == "3") {
            return $next($request);
            
        }
        else { 
            Auth::guard('web')->logout();
            $request->session()->flush();
            $request->session()->regenerate();
             return redirect()->route('buyer-login');
           //return redirect('buyer/login');
        }
        return $next($request);
    }
}
