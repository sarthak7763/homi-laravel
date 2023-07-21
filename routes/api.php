<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ForgotController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\PagesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('verify-otp', [AuthController::class, 'verifyemailotp']);
Route::post('resend-otp', [AuthController::class, 'resendemailotp']);
Route::post('login', [AuthController::class, 'login']);

Route::post('forgotpassword', [ForgotController::class, 'forgotpassword']);
Route::post('resend-forgot-otp', [ForgotController::class, 'resendotp']);

Route::post('verify-forgot-otp', [ForgotController::class, 'verifyotp']);
Route::post('resetpassword', [ForgotController::class, 'resetpassword']);

//login routes
Route::middleware('auth:api')->group(function () {
	
	Route::get('getuserinfo', [ProfileController::class, 'getuserinfo']);

	Route::post('sendcontactenquiry', [PagesController::class, 'sendcontactenquiry']);

	Route::post('updateprofile', [ProfileController::class, 'updateprofile']);

	Route::post('updateprofileimage', [ProfileController::class, 'updateprofileimage']);

	Route::post('updatepassword', [ProfileController::class, 'updatepassword']);

	Route::post('wishlistproperty', [DashboardController::class, 'wishlistproperty']);

	Route::get('getuserfavpropertylist', [ProfileController::class, 'getuserfavpropertylist']);

	Route::get('getusernotificationslistcount', [PagesController::class, 'getusernotificationslistcount']);

	Route::get('getusernotificationslist', [PagesController::class, 'getusernotificationslist']);

	Route::post('deleteusernotification', [PagesController::class, 'deleteusernotification']);

	Route::post('clearallusernotifications', [PagesController::class, 'clearallusernotifications']);

	Route::get('getcancelbookingreasons', [PagesController::class, 'getcancelbookingreasons']);

	Route::post('getpropertybookingdetails', [DashboardController::class, 'getpropertybookingdetails']);

	Route::post('insertuserbookinginfo', [DashboardController::class, 'insertuserbookinginfo']);

	Route::get('getuserbookings', [ProfileController::class, 'getuserbookings']);

	Route::post('getbookingdetails', [ProfileController::class, 'getbookingdetails']);

	Route::get('getcancelreasonslist', [ProfileController::class, 'getcancelreasonslist']);

	Route::post('submitcancelbooking', [ProfileController::class, 'submitcancelbooking']);

	Route::post('submitbookingrating', [ProfileController::class, 'submitbookingrating']);

});

//login and guest user routes
Route::get('getcontactsettingslist', [PagesController::class, 'getcontactsettingslist']);

Route::get('getuserlocation', [DashboardController::class, 'getuserlocation']);

Route::post('getstatelist', [DashboardController::class, 'getstatelist']);

Route::post('getcitylist', [DashboardController::class, 'getcitylist']);

Route::post('getpropertycategorylist', [DashboardController::class, 'getpropertycategorylist']);

Route::post('gethomepagedata', [DashboardController::class, 'gethomepagedata']);

Route::post('getnearbypropertieslist', [DashboardController::class, 'getnearbypropertieslist']);

Route::post('getrecentlyaddeddpropertylist', [DashboardController::class, 'getrecentlyaddeddpropertylist']);

Route::post('getpropertydetails', [DashboardController::class, 'getpropertydetails']);

Route::post('filterpropertylisting', [DashboardController::class, 'filterpropertylisting']);

Route::post('getsearchpropertylist', [DashboardController::class, 'getsearchpropertylist']);

Route::post('searchrentingproperty', [DashboardController::class, 'searchrentingproperty']);

Route::post('insertnotification', [DashboardController::class, 'insertnotification']);