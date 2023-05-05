<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Route;
use Mail;
use Toastr;

class Admin{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next) {

        if (Auth::user() && !auth()->user()->roles->isEmpty() && Auth::user()->roles[0]->id == 1) {
            // dd("gggg");
            return $next($request);
        } else if (Auth::user() && !auth()->user()->roles->isEmpty() && Auth::user()->roles[0]->id == 3) {
            //return $next($request);
            $route = Route::getRoutes()->match($request);
            $currentroute = $route->getName();

            if (Auth::user()->can($currentroute)) {
                return $next($request);
            } else {
             
                Toastr::error("You don't have permission to access this route!", 'Error');
                return redirect()->back();
            }
        } else {
            Auth::guard('web')->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            Toastr::error('Either something went wrong or invalid access!', 'Error');
            return redirect()->route('admin-login');
        }
        return $next($request);
    }
}
