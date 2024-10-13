<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('pages/{slug}',[HomeController::class,'getCmsPageData']); 

Route::get('emails/otp_email',[HomeController::class,'getotpmailtemplate']); 

Route::get('emails/welcome_email',[HomeController::class,'getwelcomemailtemplate']); 

Route::get('sendotpemail',[HomeController::class,'sendotpemail']);

Route::get('checksettime',[HomeController::class,'checksettime']); 


Route::get('/', function () {

    if (Auth::user() && !auth()->user()->roles->isEmpty() && Auth::user()->roles[0]->id == 1) {
        return redirect()->route('admin-profile');
    }elseif(Auth::user() && !auth()->user()->roles->isEmpty() && Auth::user()->roles[0]->id == 2){
    	
    	  return redirect()->route('buyer-dashboard');
    }else{
    	  return redirect()->route('buyer-login');
    }
});



Auth::routes();


Route::get('cammnd', function () {
    
    Artisan::call('optimize:clear');

    
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
