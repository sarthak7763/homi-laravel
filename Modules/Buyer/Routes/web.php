<?php

/*----------------BUYER LOGIN ROUTES ---------------------*/
Route::get('/dealer', 'BuyerController@buyerlogin')->name('buyer-login');
Route::get('/dealer/login', 'BuyerController@buyerlogin')->name('buyer-login');

Route::post('/dealer-login', 'BuyerController@buyer_login')->name('buyer.login.post');
 Route::get('/dealer/page/{slug}','BuyerController@cmsPages')->name('buyer-cms-page-view'); 

Route::get('/dealer/forget-password', 'BuyerController@buyerForgotPassword')->name('buyer-forget-password');

Route::get('/dealer/forgot-password/{token}', 'BuyerController@buyerForgotPasswordValidate')->name('buyer-reset-password-link');

Route::post('/dealer/forgot-password', 'BuyerController@buyerResetPassword')->name('buyer-forget-password-post');

Route::post('/dealer/reset-password', 'BuyerController@buyerUpdatePassword')->name('buyer-reset-password');


/*----------------BUYER REGISTER ROUTES ---------------------*/
Route::get('/dealer/register', 'BuyerController@buyerRegisterGet')->name('buyer.register');

Route::post('/dealer/registerpost','BuyerController@sellerSignupPost')->name('buyer.post.register');

Route::post('/dealer/loginpost','BuyerController@sellerLoginPost')->name('buyer.post.signin');

Route::get('/dealer/verify-email', 'BuyerController@BuyerVerifyEmail')->name('buyer.verify.email');

Route::post('/dealer/verifyotp','BuyerController@sellerverifyemailotp')->name('buyer.post.verifyotp');

Route::post('/dealer/resendotp','BuyerController@sellerresendemailotp')->name('buyer.post.resendotp');


/*------------------------middleware Routes-----------------*/

Route::group(['middleware' => 'Isseller'], function () 
{

    Route::get('/dealer/dashboard', 'DashboardController@index')->name('buyer.dashboard');
    Route::get('/dealer/my-profile', 'MyprofileController@index')->name('buyer.my-profile');

});
