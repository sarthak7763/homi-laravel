<?php

/*----------------BUYER LOGIN ROUTES ---------------------*/
Route::get('/dealer', 'BuyerController@buyerlogin')->name('buyer-login');
Route::get('/dealer/login', 'BuyerController@buyerlogin')->name('buyer-login');

Route::post('/dealer-login', 'BuyerController@buyer_login')->name('buyer.login.post');
 Route::get('/dealer/page/{slug}','BuyerController@cmsPages')->name('buyer-cms-page-view'); 

Route::get('/dealer/forget-password', 'BuyerController@buyershowForgotPassword')->name('buyer-forget-password');

// Route::get('/dealer/forgot-password/{token}', 'BuyerController@buyerForgotPasswordValidate')->name('buyer-reset-password-link');

Route::post('/dealer/submit-forgot-password', 'BuyerController@buyerSubmitResetPassword')->name('buyer-forget-password-post');
Route::get('/dealer/reset-password/{token}', 'BuyerController@showResetPasswordForm')->name('buyer-reset-password');
Route::post('/dealer/submit-reset-password/', 'BuyerController@submitResetPasswordForm')->name('buyer-update-password');
Route::get('/dealer-logout', 'BuyerController@buyerlogout')->name('buyer.logout');




/*----------------BUYER REGISTER ROUTES ---------------------*/
Route::get('/dealer/register', 'BuyerController@buyerRegisterGet')->name('buyer.register');
Route::post('/dealer/uniqueemail', 'BuyerController@uniqueEmailGet')->name('buyer.email');


Route::post('/dealer/registerpost','BuyerController@sellerSignupPost')->name('buyer.post.register');

Route::post('/dealer/loginpost','BuyerController@sellerLoginPost')->name('buyer.post.signin');

Route::get('/dealer/verify-email', 'BuyerController@BuyerVerifyEmail')->name('buyer.verify.email');

Route::post('/dealer/verifyregisterotp','BuyerController@sellerregisterverifyemailotp')->name('buyer.post.verifyregisterotp');

Route::post('/dealer/verifyloginotp','BuyerController@sellerloginverifyemailotp')->name('buyer.post.verifyloginotp');

Route::get('/dealer/resendotp','BuyerController@sellerresendemailotp')->name('buyer.resendotp');






/*------------------------middleware Routes-----------------*/

Route::group(['middleware' => 'Isseller'], function () 
{

    Route::get('/dealer/dashboard', 'DashboardController@index')->name('buyer.dashboard');

    Route::get('/dealer/sendotpemail', 'DashboardController@sendotpemail')->name('buyer.sendotpemail');

    // change password

    Route::get('/dealer/change-password', 'BuyerController@changePassword')->name('buyer.change-password');
    Route::post('/dealer/change-password-submit', 'BuyerController@submitchangePassword')->name('buyer.change-password-save');





    //--------------------- profile routes------------------------------------                             //
    Route::get('/dealer/my-profile', 'MyprofileController@index')->name('buyer.my-profile');
    Route::get('/dealer/edit-profile', 'MyprofileController@edit')->name('buyer.edit-profile');
    Route::post('/dealer/update-profile', 'MyprofileController@update')->name('buyer.update-profile');

// ----------------------------------------end------------------------------------//

    

    Route::get('/dealer/bookings/', 'BookingController@booking')->name('buyer.bookings');
    //  Route::get('/dealer/bookings/{segment}', 'BookingController@booking')->name('buyer.bookings');
    // Route::any('/dealer/bookings-search', 'BookingController@booking')->name('buyer.bookings-search');
    Route::post('/dealer/bookings-status-change', 'BookingController@bookingstatus')->name('buyer.bookings-update-status');
    Route::post('/dealer/bookings-cancel-booiking', 'BookingController@cancelbooking')->name('buyer.bookings-cancel-booking');

    Route::any('/dealer/bookings-views/{booking_id}', 'BookingController@bookingview')->name('buyer.bookings_view');


    //-------------------------------------- subscription--------------------------------------------// 
    Route::get('/dealer/subscription-plans', 'MysubscriptionController@allsubscriptions')->name('buyer.subscription-plans');
    Route::get('/dealer/seller-subscription/{id}', 'MysubscriptionController@sellerSubscription')->name('seller.subscription-details');
    Route::post('/dealer/seller-subscription-save', 'MysubscriptionController@sellerSubscriptionstore')->name('seller.subscription-details-save');
    Route::post('/dealer/user-subscription-confirmation/{id}', 'MysubscriptionController@subscriptionconfirmation')->name('buyer.subscription-confirmation');
    Route::get('/dealer/my-subscription', 'MysubscriptionController@index')->name('buyer.my-subscription');


    // Route::get('/dealer/user-subscription/{id}', 'MysubscriptionController@usersubscription')->name('buyer.user-subscription');




// --------------------------------------------------property---------------------------------------------//
    Route::get('/dealer/manage-properties', 'PropertyController@index')->name('buyer.property');
    // Route::get('/dealer/manage-properties/{segment}', 'PropertyController@index')->name('buyer.property');
    // Route::any('/dealer/manage-properties-search', 'PropertyController@index')->name('buyer.property-search');
    Route::get('/dealer/add-properties', 'PropertyController@add')->name('buyer.add-property');
    Route::post('/dealer/get-categorydata-property', 'PropertyController@getcategory')->name('buyer.get-category');
    Route::post('/dealer/save-propertiesData', 'PropertyController@store')->name('buyer.store-property');
    Route::get('/dealer/edit-propertiesData/{id}', 'PropertyController@edit')->name('buyer.edit-property');
    Route::get('/dealer/delete-propertiesData','PropertyController@ajaxdelete')->name('buyer.delete-propertyGallery');
    Route::post('/dealer/update-propertiesData/{id}', 'PropertyController@update')->name('buyer.update-property');
    Route::post('/dealer/update-propertiesDatastatus', 'PropertyController@updatePropertyStatus')->name('buyer.status-update-property');
    Route::get('/dealer/view-propertiesData/{id}', 'PropertyController@view')->name('buyer.view-property');
    





    // --------------------------------------------end-------------------------------------------------------//

    Route::get('/dealer/manage-payments', 'PaymentController@index')->name('buyer.payment');






    // -----------------------------------------------logout------------------------------------

    





});
