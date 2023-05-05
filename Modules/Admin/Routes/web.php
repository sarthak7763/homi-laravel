<?php

/*----------------ADMIN LOGIN ROUTES ---------------------*/
Route::get('/admin/login', 'AdminController@login')->name('admin-login');
Route::get('/admin', 'AdminController@login')->name('admin-login');
Route::post('/admin/login', 'AdminController@admin_login')->name('admin.login');

//------------FORGOT PASSWORD----------------
Route::get('/admin/forgot-password', 'AdminController@adminForgotPassword')->name('admin-forget-password');


Route::get('/admin/forgot-password/{token}', 'AdminController@adminForgotPasswordValidate')->name('admin-reset-password-link');

Route::post('/admin/forgot-password', 'AdminController@adminResetPassword')->name('admin-forget-password-post');

Route::post('/admin/reset-forgot-password', 'AdminController@adminUpdatePassword')->name('admin-reset-forgot-password');


Route::get('/admin/sms','BidController@sendSMS')->name('send-sms');
//Auth::routes();
/*--------------------ADMIN ROUTES AFTER LOGIN-------------------------------*/
Route::group(['middleware' => 'Isadmin'], function () {
    Route::prefix('admin')->group(function() {
        //------------------SEND GLOBAL SMS----------------------
        Route::get('/send-global-sms', 'GlobalSmsController@index')->name('admin-global-sms-send');
        Route::post('/send-global-sms', 'GlobalSmsController@sendSMSByAdmin')->name('admin-global-sms-send-post');
        Route::post('/sms-template-get-ajax', 'GlobalSmsController@ajaxGetSmsTemplateByid')->name('admin-get-ajax-sms-template');

        Route::get('/send-global-mail', 'GlobalMailController@index')->name('admin-global-mail-send');
        Route::post('/send-global-mail', 'GlobalMailController@sendMailByAdmin')->name('admin-global-mail-send-post');
        Route::post('/mail-template-get-ajax', 'GlobalMailController@ajaxGetMailTemplateByid')->name('admin-get-ajax-mail-template');

        
   
     
       
       /*-------------ADMIN PROFILE ROUTES-------------------*/

        Route::post('/notification/mark-as-read', 'NotificationController@markNotification')->name('admin.markNotification');
        Route::get('/all-notifications', 'NotificationController@notificationList')->name('admin-notification-list');
        Route::post('/all-notifications-delete', 'NotificationController@deleteNotification')->name('admin-notification-delete-all');
 
        Route::get('/profile', 'AdminController@profile')->name('admin-profile');

        Route::get('/profile-edit', 'AdminController@profile_edit')->name('admin-profile-edit');

        Route::post('/profile-update', 'AdminController@profileUpdate')->name('admin-profile-update');
        Route::post('/reset-password', 'AdminController@resetAdminPassword')->name('admin-reset-password');
        Route::get('/dashboard', 'AdminController@index')->name('admin-dashboard');
        Route::post('/graph-data', 'AdminController@graphRevenueDataPost')->name('admin-revenue-graph-post');
        Route::post('/logout', 'AdminController@admin_logout')->name('admin_logout');
        
        //-------------------------ADMIN USER ROUTE--------------------------//
        
        Route::get('/user-list', 'UserController@index')->name('admin-user-list');
        Route::any('/user-add', 'UserController@add')->name('admin-user-add');

        Route::post('/user-save', 'UserController@save')->name('admin-user-save');

        Route::get('/user-edit/{id}', 'UserController@edit')->name('admin-user-edit');
        Route::post('/user-update', 'UserController@update')->name('admin-user-update');
        Route::get('/user-details/{id}', 'UserController@show')->name('admin-user-details');
        Route::post('/user-status-update', 'UserController@updateUserStatus')->name('admin-user-status-update');

        Route::post('/user-email-status-update', 'UserController@updateUserEmailStatus')->name('admin-user-email-status-update');

        Route::post('/user-delete', 'UserController@deleteUser')->name('admin-user-delete');
        Route::get('/soft-deleted-user-list', 'UserController@softDeletedUser')->name('admin-soft-deleted-user-list');
        
        Route::post('/user-restore', 'UserController@restoreUser')->name('admin-user-restore');

        Route::post('/user-image-upload', 'UserController@saveTempImage')->name('admin-user-image-upload');

        Route::post('/user-email-check', 'UserController@checkEmailExist')->name('admin-ajax-check-email-exist');
       
        Route::post('/user-phone-check', 'UserController@checkPhoneExist')->name('admin-ajax-check-phone-exist');

        Route::post('/user-exist-email-check', 'UserController@checkEmailExistforExistingUser')->name('admin-ajax-check-exist-email');
       
        Route::post('/user-exist-phone-check', 'UserController@checkPhoneExistForExistingUser')->name('admin-ajax-check-exist-phone');

        Route::post('/user-password-change', 'UserController@updateBuyerPassword')->name('admin-change-buyer-password');


         //-------------------------ADMIN Category ROUTE--------------------------//
        
        Route::get('/category-list', 'CategoryController@index')->name('admin-category-list');
        Route::any('/category-add', 'CategoryController@add')->name('admin-category-add');
        Route::post('/category-save', 'CategoryController@save')->name('admin-category-save');
        Route::get('/category-edit/{id}', 'CategoryController@edit')->name('admin-category-edit');
        Route::post('/category-update', 'CategoryController@update')->name('admin-category-update');
        Route::get('/category-details/{id}', 'CategoryController@show')->name('admin-category-details');

        Route::post('/category-status-update', 'CategoryController@updateCategoryStatus')->name('admin-category-status-update');

        Route::post('/category-delete', 'CategoryController@deleteCategory')->name('admin-category-delete');

        Route::get('/soft-deleted-category-list', 'CategoryController@softDeletedUser')->name('admin-soft-deleted-category-list');

          //-------------------------ADMIN Property owners ROUTE--------------------------//
        
          Route::get('/propertyOwner-list', 'PropertyOwnerController@index')->name('admin-propertyOwner-list');
          Route::any('/propertyOwner-add', 'PropertyOwnerController@add')->name('admin-propertyOwner-add');
  
          Route::post('/propertyOwner-save', 'PropertyOwnerController@save')->name('admin-propertyOwner-save');
  
          Route::get('/propertyOwner-edit/{id}', 'PropertyOwnerController@edit')->name('admin-propertyOwner-edit');
          Route::post('/propertyOwner-update', 'PropertyOwnerController@update')->name('admin-propertyOwner-update');
          Route::get('/propertyOwner-details/{id}', 'PropertyOwnerController@show')->name('admin-propertyOwner-details');
          Route::post('/propertyOwner-status-update', 'PropertyOwnerController@updateUserStatus')->name('admin-propertyOwner-status-update');
  
          Route::post('/propertyOwner-email-status-update', 'PropertyOwnerController@updateUserEmailStatus')->name('admin-propertyOwner-email-status-update');
  
          Route::post('/propertyOwner-delete', 'PropertyOwnerController@deleteUser')->name('admin-propertyOwner-delete');
          Route::get('/soft-deleted-user-list', 'PropertyOwnerController@softDeletedUser')->name('admin-soft-deleted-user-list');
          
          Route::post('/propertyOwner-restore', 'PropertyOwnerController@restoreUser')->name('admin-propertyOwner-restore');
  
          Route::post('/propertyOwner-image-upload', 'PropertyOwnerController@saveTempImage')->name('admin-propertyOwner-image-upload');
  
          Route::post('/propertyOwner-email-check', 'PropertyOwnerController@checkEmailExist')->name('admin-propertyOwner-check-email-exist');
         
          Route::post('/propertyOwner-phone-check', 'PropertyOwnerController@checkPhoneExist')->name('admin-ajax-check-phone-exist');
  
          Route::post('/propertyOwner-exist-email-check', 'PropertyOwnerController@checkEmailExistforExistingUser')->name('admin-ajax-check-exist-email');
         
          Route::post('/propertyOwner-exist-phone-check', 'PropertyOwnerController@checkPhoneExistForExistingUser')->name('admin-ajax-check-exist-phone');
  
          Route::post('/propertyOwner-password-change', 'PropertyOwnerController@updateBuyerPassword')->name('admin-change-buyer-password');
  
        // ------- Owners -------------//

        Route::get('/owners-list', 'OwnersController@index')->name('admin-owners-list');
        Route::any('/owners-add', 'OwnersController@add')->name('admin-owners-add');

        Route::post('/owners-save', 'OwnersController@save')->name('admin-owners-save');

        Route::get('/owners-edit/{id}', 'OwnersController@edit')->name('admin-owners-edit');
        Route::post('/owners-update', 'OwnersController@update')->name('admin-owners-update');
        Route::get('/owners-details/{id}', 'OwnersController@show')->name('admin-owners-details');
        Route::post('/owners-delete', 'OwnersController@deleteUser')->name('admin-owners-delete');
        Route::get('/soft-deleted-owners-list', 'OwnersController@softDeletedUser')->name('admin-soft-deleted-owners-list');
        Route::post('/owners-status-update', 'OwnersController@updateUserStatus')->name('admin-owners-status-update');

        // ------- Owners -------------//


        // ------- Subscription -------------//
        Route::get('/subscription-list', 'SubscriptionController@index')->name('admin-subscription-list');
        Route::any('/subscription-add', 'SubscriptionController@add')->name('admin-subscription-add');

        Route::post('/subscription-save', 'SubscriptionController@save')->name('admin-subscription-save');

        Route::get('/subscription-edit/{id}', 'SubscriptionController@edit')->name('admin-subscription-edit');
        Route::post('/subscription-update', 'SubscriptionController@update')->name('admin-subscription-update');
        Route::get('/subscription-details/{id}', 'SubscriptionController@show')->name('admin-subscription-details');
        Route::post('/subscription-delete', 'SubscriptionController@deleteSub')->name('admin-subscription-delete');
        Route::get('/soft-deleted-subscription-list', 'SubscriptionController@softDeletedUser')->name('admin-soft-deleted-subscription-list');
        Route::post('/subscription-status-update', 'SubscriptionController@updateUserStatus')->name('admin-subscription-status-update');


        // ------- Subscription -------------//


        //--------STATE COUNTRY AJAX ROUTE---------------//

        Route::post('/ajax-state-get','UserController@getState')->name('admin-ajax-get-state-list');
        Route::post('/ajax-city-get', 'UserController@getCity')->name('admin-ajax-get-city-list');
        Route::post('/ajax-email-get','UserController@getEmail')->name('admin-ajax-email-get');

        /* ___________________________COUNTRY ROUTES____________________________ */
        Route::get('/country-list','CountryController@index')->name('admin-country-list');
        Route::get('/country-add','CountryController@add')->name('admin-country-add');
        Route::post('/country-save','CountryController@save')->name('admin-country-save');
        Route::get('/country-edit/{slug}','CountryController@edit')->name('admin-country-edit');
        Route::post('/country-update','CountryController@update')->name('admin-country-update');
        Route::post('/country-status-update', 'CountryController@updateCountryStatus')->name('admin-country-status-update');
        Route::post('/country-delete-status', 'CountryController@editDeleteStatus')->name('admin-country-delete-status');
        /* _________________________STATE ROUTES____________________________ */
        Route::get('/state-list','StateController@index')->name('admin-state-list');
        Route::get('/state-add','StateController@add')->name('admin-state-add');
        Route::post('/state-save','StateController@save')->name('admin-state-save');
        Route::get('/state-edit/{slug}','StateController@edit')->name('admin-state-edit');
        Route::post('/state-update','StateController@update')->name('admin-state-update');
        Route::post('/state-status-update', 'StateController@updateStateStatus')->name('admin-state-status-update');
        Route::post('/state-delete-status', 'StateController@editDeleteStatus')->name('admin-state-delete-status');
        Route::post('/state-delete', 'StateController@deleteState')->name('admin-state-delete');

       
        /* _____________________________CITY ROUTES____________________________ */
        Route::get('/city-list','CityController@index')->name('admin-city-list');
        Route::get('/city-add','CityController@add')->name('admin-city-add');
        Route::post('/city-save','CityController@save')->name('admin-city-save');
        Route::get('/city-edit/{slug}','CityController@edit')->name('admin-city-edit');
        Route::post('/city-update','CityController@update')->name('admin-city-update');
        Route::post('/city-status-update', 'CityController@updatecityStatus')->name('admin-city-status-update');
        Route::post('/city-delete-status', 'CityController@editDeleteStatus')->name('admin-city-delete-status');
         Route::post('/city-delete', 'CityController@deleteCity')->name('admin-city-delete');

        
           /* _________________________REASON ROUTES____________________________ */
        Route::get('/reason-list','ReasonController@index')->name('admin-reason-list');
        Route::get('/reason-add','ReasonController@add')->name('admin-reason-add');
        Route::post('/reason-save','ReasonController@save')->name('admin-reason-save');
        Route::get('/reason-edit/{slug}','ReasonController@edit')->name('admin-reason-edit');
        Route::post('/reason-update','ReasonController@update')->name('admin-reason-update');
        Route::post('/reason-status-update','ReasonController@updateReasonStatus')->name('admin-reason-status-update');
        Route::post('/reason-delete-status', 'ReasonController@editDeleteStatus')->name('admin-reason-delete-status');
       
        //---------------------------ADMIN COMPLAINT ROUTE----------------------//
        Route::get('/buyer-complaint-list', 'ComplaintController@index')->name('admin-user-complaint-list');
        Route::get('/buyer-complaint-add', 'ComplaintController@add')->name('admin-user-complaint-add');
        Route::post('/buyer-complaint-save', 'ComplaintController@save')->name('admin-user-complaint-save');
        Route::get('/buyer-complaint-edit/{id}', 'ComplaintController@edit')->name('admin-user-complaint-edit');
        Route::post('/buyer-complaint-update', 'ComplaintController@update')->name('admin-user-complaint-update');
        Route::post('/buyer-complaint-status-update', 'ComplaintController@updateStatus')->name('admin-user-complaint-status-update');
        Route::post('/buyer-complaint-status-change', 'ComplaintController@updateComplaintStatus')->name('admin-change-users-complaint-status');
        Route::post('/buyer-complaint-delete', 'ComplaintController@deleteComplaint')->name('admin-user-complaint-delete');
        Route::post('/buyer-complaint-detail', 'ComplaintController@show')->name('admin-user-complaint-detail');
        Route::get('/buyer-complaint-details/{id}', 'ComplaintController@showDetail')->name('admin-complaint-detail');
         Route::post('/buyer-complaint-response-send', 'ComplaintController@responseComplaint')->name('admin-user-complaint-respond');
         
        //---------------------------ADMIN ENQUIRY ROUTE----------------------//
        Route::get('/buyer-enquiry-list', 'EnquiryController@index')->name('admin-user-enquiry-list');
        Route::get('/buyer-enquiry-add', 'EnquiryController@add')->name('admin-user-enquiry-add');
        Route::post('/buyer-enquiry-save', 'EnquiryController@save')->name('admin-user-enquiry-save');
        Route::get('/buyer-enquiry-edit/{id}', 'EnquiryController@edit')->name('admin-user-enquiry-edit');
        Route::post('/buyer-enquiry-update', 'EnquiryController@update')->name('admin-user-enquiry-update');
        Route::post('/buyer-enquiry-status-update', 'EnquiryController@updateStatus')->name('admin-user-enquiry-status-update');
        Route::post('/buyer-enquiry-delete', 'EnquiryController@deleteEnquiry')->name('admin-user-enquiry-delete');
        Route::post('/buyer-enquiry-detail', 'EnquiryController@show')->name('admin-user-enquiry-detail');
        Route::get('/buyer-enquiry-details/{id}', 'EnquiryController@showDetail')->name('admin-enquiry-detail');
        
        //-----------------------------ADMIN PROPERTY ROUTE-----------------//
        Route::get('/property-list', 'PropertyController@index')->name('admin-property-list');

        Route::post('/ajax-get-category-list', 'PropertyController@ajaxgetcategorylist')->name('admin-ajax-get-category-list');


        Route::post('/ajax-get-ownder-details', 'PropertyController@ajaxgetownderdetails')->name('admin-ajax-get-ownder-details');
        
        //Pending Property where timer expire sale status 0 in offfer table
        Route::get('/pending-property-list', 'PropertyController@pendingProperty')->name('admin-pending-property-list');

        Route::get('/property-add', 'PropertyController@add')->name('admin-property-add');

        Route::post('/property-save', 'PropertyController@save')->name('admin-property-save');

        Route::get('/property-edit/{slug}', 'PropertyController@edit')->name('admin-property-edit');

        Route::post('/property-update', 'PropertyController@update')->name('admin-property-update');

        Route::get('/property-details/{slug}', 'PropertyController@show')->name('admin-property-details');

        Route::post('/property-status-update', 'PropertyController@updatePropertyStatus')->name('admin-property-status-update');

        Route::post('/property-delete', 'PropertyController@deleteProperty')->name('admin-property-delete');

        Route::get('/soft-deleted-property-list', 'PropertyController@softDeletedProperty')->name('admin-soft-deleted-property-list');
        
        Route::get('/property-gallery/{slug}', 'PropertyGalleryController@viewGallery')->name('admin-property-gallery-view');


        //--------------ADMIN PROPERTY GALLERY ROUTE-----------------//

        Route::post('/property-gallery-attachment-save-ajax', 'PropertyGalleryController@storepropertyimage')->name('admin-upload-gallery-ajax');

        Route::post('/property-gallery-attachment-delete', 'PropertyGalleryController@deleteImage')->name('admin-property-image-delete');


        //=================CMS PAGE======================================

        Route::get('/admin/faq-list', 'FaqController@index')->name('admin-faq-list');
        Route::get('/admin/faq-add', 'FaqController@add')->name('admin-faq-add');
        Route::post('/admin/faq-save', 'FaqController@save')->name('admin-faq-save');
        Route::get('/admin/faq-edit/{id}', 'FaqController@edit')->name('admin-faq-edit');
        Route::post('/admin/faq-update', 'FaqController@update')->name('admin-faq-update');
        Route::post('/admin/faq-delete', 'FaqController@deleteFaq')->name('admin-faq-delete');
        Route::post('/admin/status-update', 'FaqController@statusUpdateFaq')->name('admin-faq-status-update');

        //-----------------------------ADMIN MARKET ROUTE-----------------//
        // Route::get('/market-list', 'MarketController@index')->name('admin-market-list');
        // Route::get('/market-add', 'MarketController@add')->name('admin-market-add');
        // Route::post('/market-save', 'MarketController@save')->name('admin-market-save');
        // Route::get('/market-edit/{slug}', 'MarketController@edit')->name('admin-market-edit');
        // Route::post('/market-update', 'MarketController@update')->name('admin-market-update');
        // Route::get('/market-details/{slug}', 'MarketController@show')->name('admin-market-details');
        // Route::post('/market-status-update', 'MarketController@updateMarketStatus')->name('admin-market-status-update');
        // Route::post('/market-delete', 'MarketController@delete')->name('admin-market-delete');
        //--------------ADMIN CMS PAGE ROUTE-----------------//
        Route::get('/page-list', 'CmsPageController@index')->name('admin-cms-page-list');
        Route::get('/page-add', 'CmsPageController@add')->name('admin-cms-page-add');
        Route::post('/page-save', 'CmsPageController@save')->name('admin-cms-page-save');
        Route::get('/page-edit/{slug}', 'CmsPageController@edit')->name('admin-cms-page-edit');
        Route::post('/page-update', 'CmsPageController@update')->name('admin-cms-page-update');
        Route::post('/page-status-update', 'CmsPageController@updatePageStatus')->name('admin-page-status-update');
        Route::post('/page-delete', 'CmsPageController@deletePage')->name('admin-page-delete');
        Route::get('/page-details/{slug}', 'CmsPageController@show')->name('admin-cms-page-detail');
        // === EmailTemplateController ===
        // Route::get('/emails', 'EmailTemplateController@index')->name('admin-emails');
        // Route::get('/add-email', 'EmailTemplateController@create')->name('admin-add-email');
        // Route::post('/add-email-post', 'EmailTemplateController@store')->name('admin-add-email-post');
        // Route::get('/edit-email/{slug}', 'EmailTemplateController@edit')->name('admin-edit-email');
        // Route::post('/edit-email-post', 'EmailTemplateController@update')->name('admin-edit-email-post');
        // Route::get('/view-email/{slug}', 'EmailTemplateController@show')->name('admin-view-email');
        // Route::get('/delete-email/{slug}', 'EmailTemplateController@destroy')->name('admin-delete-email');
        // Route::get('/email-status/{slug}', 'EmailTemplateController@emailStatus')->name('admin-email-status');

        // === SystemSettingController ===
        Route::get('/system-settings', 'SystemSettingController@index')->name('admin-system-settings');
        Route::get('/add-system-setting', 'SystemSettingController@create')->name('admin-add-system-setting');
        Route::post('/add-system-setting-post', 'SystemSettingController@store')->name('admin-add-system-setting-post');
        Route::get('/edit-system-setting/{slug}', 'SystemSettingController@edit')->name('admin-edit-system-setting');
        Route::post('/edit-system-setting-post', 'SystemSettingController@update')->name('admin-edit-system-setting-post');
        Route::get('/view-system-setting/{slug}', 'SystemSettingController@show')->name('admin-view-system-setting');
        Route::get('/delete-system-setting/{slug}', 'SystemSettingController@destroy')->name('admin-delete-system-setting');
        Route::get('option-status/{slug}', 'SystemSettingController@OptionStatus')->name('admin-option-status');
        Route::get('/site-logo', 'SystemSettingController@indexSiteLogo')->name('admin-site-logo');
        Route::post('/edit-site-logo', 'SystemSettingController@updateSiteLogo')->name('admin.edit.site.logo');
  Route::post('/edit-site-favicon', 'SystemSettingController@updateSiteFavIcon')->name('admin.edit.site.favicon');
      
        
        
        //___________SubAdminController______________
        Route::get('/sub-admins', 'SubAdminController@subAdminList')->name('admin-sub-admins');
        Route::get('/add-sub-admin', 'SubAdminController@subAdminAdd')->name('admin-add-sub-admin');
        Route::post('/add-sub-admin-post', 'SubAdminController@subAdminAddStore')->name('admin-add-sub-admin-post');
        Route::get('/edit-sub-admin/{slug}', 'SubAdminController@subAdminEdit')->name('admin-edit-sub-admin');
        Route::post('/edit-sub-admin-post', 'SubAdminController@subAdminUpdate')->name('admin-edit-sub-admin-post');
        Route::get('/view-sub-admin/{slug}', 'SubAdminController@subAdminView')->name('admin-view-sub-admin');
        Route::post('/delete-sub-admin', 'SubAdminController@subAdminDestroy')->name('admin-delete-sub-admin');
        Route::post('/sub-admin-status', 'SubAdminController@subAdminStatus')->name('admin-sub-admin-status');
        //Route::get('export-sub-admin', 'SubAdminController@exportsubAdmin')->name('export-sub-admin');
        Route::post('/sub-admin-change-password', 'SubAdminController@subAdminChangePass')->name('admin-sub-admin-change-password');
        Route::post('/sub-admin-phone-exist', 'SubAdminController@checkPhoneExist')->name('admin-check-subadmin-phone-exist');

    /* _________________________SALE TIMER OFFER ROUTES____________________________ */

    Route::get('/property-sales-offer-list','OfferPropertyController@index')->name('admin-property-sales-list');
    Route::get('/property-sales-offer-add','OfferPropertyController@add')->name('admin-property-sales-add');
    Route::post('/property-sales-offer-save','OfferPropertyController@save')->name('admin-property-sales-save');
    Route::get('/property-sales-offer-edit/{id}','OfferPropertyController@edit')->name('admin-property-sales-edit');
     Route::get('/property-sales-timer-edit/{slug}','OfferPropertyController@editByPropertyID')->name('admin-property-timer');
    
    Route::post('/property-sales-offer-update/{id}','OfferPropertyController@update')->name('admin-property-sales-update');
    Route::get('/property-sales-offer-detail/{id}','OfferPropertyController@show')->name('admin-property-sales-detail-show');
 
    Route::post('/property-sales-offer-status-update', 'OfferPropertyController@updateStatus')->name('admin-property-sales-status-update');
    Route::post('/property-sales-offer-delete-status', 'OfferPropertyController@editDeleteStatus')->name('admin-property-sales-delete-status');

    Route::post('/property-sales-offer-publish-status', 'OfferPropertyController@updateSaleOfferPublishStatus')->name('admin-property-sales-offer-publish-status');
    

    /*_______BIDS ROUTES__________ */

    Route::get('/bid-property-wise/{property_id}/{bid_status}','BidController@getBidsPropertyWise')->name('admin-bid-property-wise-get');
    Route::post('/bid-property-wise/{property_id}/{bid_status}', 'BidController@getBidsPropertyWise')->name('admin-bid-property-wise-post');


    Route::get('/bid-list','BidController@index')->name('admin-bid-list');
    Route::post('/bid-get-min-max-price', 'BidController@getMinMaxBidPrice')->name('admin-ajax-get-min-max-bid-price');
   
    // Route::get('/bid-add','BidController@add')->name('admin-bid-add');
    // Route::post('/bid-save','BidController@save')->name('admin-bid-save');
    // Route::get('/bid-edit/{id}','BidController@edit')->name('admin-bid-edit');
    // Route::post('/bid-update/{id}','BidController@update')->name('admin-bid-update');
    Route::post('/bid-status-update', 'BidController@updateBidStatus')->name('admin-bid-status-update');
    Route::post('/bid-status-change', 'BidController@updateStatus')->name('admin-bid-enable-disable');
    Route::post('/bid-delete-status', 'BidController@editDeleteStatus')->name('admin-bid-delete');
    Route::get('/view-bid-info/{id}','BidController@show')->name('admin-bid-view');
       
    //-------------------MAIL TEMPLATE ROUTES--------------
    Route::get('/mail-template-list','MailActionTemplateController@index')->name('admin-mail-template-list');
    // Route::post('/mail-template-lists','MailActionTemplateController@index')->name('admin-mail-ajax-template-list');
    Route::get('/mail-template-add','MailActionTemplateController@add')->name('admin-mail-template-add');
    Route::post('/mail-template-save','MailActionTemplateController@save')->name('admin-mail-template-save');
    Route::get('/mail-template-edit/{slug}','MailActionTemplateController@edit')->name('admin-mail-template-edit');
    Route::post('/mail-template-update','MailActionTemplateController@update')->name('admin-mail-template-update');
    Route::post('/mail-template-delete', 'MailActionTemplateController@delete')->name('admin-mail-template-delete');
    Route::post('/get-mail-options-list', 'MailActionTemplateController@getMailParameters')->name('admin-ajax-get-mail-options-list');
    Route::get('/mail-action-list','MailActionTemplateController@mailActionList')->name('admin-mail-action-list');
    Route::post('/mail-action-data-save','MailActionTemplateController@mailActionSave')->name('admin-mail-action-data-save');
    Route::get('/mail-template-view/{id}','MailActionTemplateController@show')->name('admin-mail-template-show');

    Route::post('/mail-template-status-update','MailActionTemplateController@updateStatus')->name('admin-mail-template-status-update');

     //----------------SMS TEMPLATE------------------------------------------------
       Route::get('/sms-template-list','SmsController@index')->name('admin-sms-template-list');
    // Route::post('/mail-template-lists','SmsController@index')->name('admin-mail-ajax-template-list');
    Route::get('/sms-template-add','SmsController@add')->name('admin-sms-template-add');
    Route::post('/sms-template-save','SmsController@save')->name('admin-sms-template-save');
    Route::get('/sms-template-edit/{slug}','SmsController@edit')->name('admin-sms-template-edit');
    Route::post('/sms-template-update','SmsController@update')->name('admin-sms-template-update');
    Route::post('/sms-template-delete', 'SmsController@delete')->name('admin-sms-template-delete');
    Route::post('/get-sms-options-list', 'SmsController@getSMSParameters')->name('admin-ajax-get-sms-options-list');
    Route::get('/sms-template-view/{id}','SmsController@show')->name('admin-sms-template-show');
    Route::post('/sms-action-list-get-ajax', 'SmsController@getActionBySmsType')->name('admin-get-ajax-sms-action-list');
    Route::post('/sms-template-status-update','SmsController@updateStatus')->name('admin-sms-template-status-update');

    //----------------FAV PROPERTY ------------------
    Route::post('/buyer-favourite-property-remove', 'FavPropertyController@deleteFavProperty')->name('admin-fav-property-remove');


    // === ROLE CONTROLLLER ===
    Route::get('/roles', 'RoleController@index')->name('admin-role-list');
    Route::get('/add-roles', 'RoleController@create')->name('admin-add-role');
    Route::post('/save-role', 'RoleController@store')->name('admin-save-role');
    Route::get('/edit-role/{id}', 'RoleController@edit')->name('admin-edit-role');
    Route::post('/update-role/{id}', 'RoleController@update')->name('admin-update-role');
    Route::get('/view-role/{id}', 'RoleController@show')->name('admin-view-role');
    Route::post('/delete-role', 'RoleController@destroy')->name('admin-delete-role');

    // === PERMISSION CONTROLLLER ===
    Route::get('/permissions', 'PermissionController@index')->name('admin-permission-list');
    Route::get('/add-permission', 'PermissionController@create')->name('admin-add-permission');
    Route::post('/save-permission', 'PermissionController@store')->name('admin-save-permission');
    Route::get('/edit-permission/{id}', 'PermissionController@edit')->name('admin-edit-permission');
    Route::post('/update-permission/{id}', 'PermissionController@update')->name('admin-update-permission');
    Route::get('/view-permission/{id}', 'PermissionController@show')->name('admin-view-permission');
    Route::post('/delete-permission', 'PermissionController@destroy')->name('admin-delete-permission');


// Route::prefix('admin')->group(function() {
//     Route::get('/', 'AdminController@index');
// });

// Route::get('/', function () {
//     dd("hello");
//     // if(Auth::check()) {
//     //     return redirect()->route('admin-dashboard');
//     // }
//     // return view('admin::auth.login');
// });
   
    });
});