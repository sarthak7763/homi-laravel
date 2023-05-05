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

Route::get('/dealer/verify-email/{token}', 'BuyerController@BuyerVerifyEmail')->name('buyer.verify.email');

/*----------BUYER AJAX ROUTE FOR CHECK EMAIL PHONE FOR SIGN UP FORM--------------*/
Route::post('/dealer/sign-up-email-check','BuyerController@checkEmailExistForSignup')->name('buyer-sign-up-email-check');
Route::post('/dealer/sign-up-mobile-check','BuyerController@checkPhoneExistForSignup')->name('buyer-sign-up-mobile-check');

/*-------------------- ROUTES AFTER LOGIN-------------------------------*/
  Route::group(['middleware' => 'prevent-back-history','Isbuyer'], function () {

  Route::get('/dealer/faq', 'BuyerController@faqPage')->name('buyer-faq-page');
  

   
  Route::post('/dealer/mark-unread-notifications', 'BuyerController@markBuyerNotification')->name('buyer.markBuyerNotification');


  Route::get('/dealer/contact-us', 'BuyerController@contactUs')->name('buyer-contact-us');
  Route::post('/dealer/contact-us', 'BuyerController@contactUsPost')->name('buyer-contact-us-submit');

  /*-----------------------HOME PAGE SEARCH PROPERTY ROUTES------------------*/
  
  Route::get('/dealer/filter-property', 'BuyerPropertyController@searchProperty')->name('buyer-dashboard');
  Route::get('/dealer/search-property', 'BuyerPropertyController@searchProperty')->name('buyer-search-property');

  //--DEFAULT SEARCH PROPERTY LOAD BY AJAX ROUTER----
  Route::post('/dealer/search-property','BuyerPropertyController@searchPropertyPost')->name('buyer-search-property-result');

  Route::post('/dealer/distance-wise-property','BuyerPropertyController@displayDistanceWiseProperty')->name('buyer-get-distance-property');

  Route::post('/dealer/check-property-intrested-city','BuyerPropertyController@checkIntrestedCityProperty')->name('check-intrested-city-property-found');
  
  //--CITY WISE SEARCH PROPERTY LOAD BY AJAX ROUTER----
  Route::post('/dealer/filter-property','BuyerPropertyController@searchPropertyCityWise')->name('buyer-search-map-filter');
  //--LOCATION INPUT WISE SEARCH PROPERTY LOAD BY AJAX ROUTER----
  Route::post('/dealer/property-search-by-location', 'BuyerPropertyController@searchPropertyByAddress')->name('buyer-property-search-by-location');

  Route::get('/dealer/property-gallery-show/{id}', 'BuyerPropertyController@propertyGalleryGet')->name('buyer-property-gallery-show');

  Route::post('/dealer/property-image-gallery', 'BuyerPropertyController@propertyGallery')->name('buyer-property-gallery');
 Route::get('/dealer/property-video-gallery/{id}', 'BuyerPropertyController@propertyVideo')->name('buyer-property-video-gallery');


  
    
  /*-----------------------BUYER PROFILE ROUTES--------------------------------*/
  
  Route::get('/dealer/profile', 'BuyerController@myProfile')->name('buyer-profile');
  
  Route::post('/dealer/save-profile', 'BuyerController@profilePost')->name('buyer-save-profile');

 
 Route::get('/dealer/change-password', 'BuyerController@buyerChangePassword')->name('buyer-change-password');
Route::post('/dealer/update-password', 'BuyerController@buyerUpdateNewPassword')->name('buyer-update-password');

Route::post('/dealer/match-old-password', 'BuyerController@checkOldPasswordMatch')->name('buyer-ajax-confirm-old-password');


  

  //--CHECK BUYER MAIL EXIST FOR PROFILE UPDATE ---
  Route::post('/dealer/email-check', 'BuyerController@checkEmailExist')->name('buyer-ajax-check-email-exist');
  
  //--CHECK BUYER PHONE NO EXIST FOR PROFILE UPDATE ---    
  Route::post('/dealer/phone-check', 'BuyerController@checkPhoneExist')->name('buyer-ajax-check-phone-exist');
  
  /*-----------------------BUYER MY BIDS ROUTES--------------------------------*/
  
  Route::get('/dealer/my-bids', 'BuyerBidController@mybids')->name('buyer-bids');
  Route::get('/dealer/my-bids-by-status', 'BuyerBidController@mybidsByStatus')->name('buyer-bids-status-wise');

  

  Route::post('/dealer/bid-price-update','BuyerBidController@updateBuyerBidPrice')->name('buyer-bid-price-update');
  
  Route::post('/dealer/bid-price-save','BuyerBidController@saveBid')->name('buyer-bid-price-save');
  
   Route::post('/dealer/bid-check-bid-exist','BuyerBidController@checkBidExist')->name('buyer-check-bid-exist');
  
  
  /*-----------------------BUYER FAV PROPERTY ROUTES--------------------------------*/
  
  Route::get('/dealer/fav-property', 'BuyerPropertyController@myfavproperty')->name('buyer-fav-property');

  Route::post('/dealer/fav-property', 'BuyerPropertyController@postmyfavproperty')->name('buyer-fav-property');

  Route::post('/dealer/property-add-to-favourite', 'BuyerPropertyController@propertyAddToFav')->name('buyer-property-add-to-favourite');

  Route::post('/dealer/property-remove-from-favourite', 'BuyerPropertyController@propertyRemoveFromFav')->name('buyer-property-remove-from-favourite');

  /*-----------------------BUYER PROPERTY DETAILS ROUTES--------------------------------*/

 Route::post('/dealer/set-close-of-escrow-status-pending','BuyerPropertyController@closeOfEscrowStatusPending')->name('buyer-set-close-of-escrow-status-pending');

  Route::get('/dealer/property-detail/{slug}','BuyerPropertyController@propertyDetail')->name('buyer-property-detail');
   
  Route::post('/dealer/logout', 'BuyerController@buyer_logout')->name('buyer_logout');
 
});