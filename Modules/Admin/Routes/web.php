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

//Auth::routes();
/*--------------------ADMIN ROUTES AFTER LOGIN-------------------------------*/
Route::group(['middleware' => 'Isadmin'], function () {
    Route::prefix('admin')->group(function() {
        //------------------SEND GLOBAL SMS----------------------

       
       /*-------------ADMIN PROFILE ROUTES-------------------*/
 
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

         // ------- Booking -------------//
        Route::get('/booking-list', 'BookingController@index')->name('admin-booking-list');

        Route::get('/booking-details/{id}', 'BookingController@show')->name('admin-booking-details');


        Route::get('/booking-invoice/{id}', 'BookingController@showinvoice')->name('admin-booking-invoice');


        // ------- Booking -------------//



         // ------- Enquiry -------------//
        Route::get('/enquiry-list', 'EnquiryController@index')->name('admin-enquiry-list');

        Route::post('/enquiry-status-update', 'EnquiryController@updateEnquiryStatus')->name('admin-enquiry-status-update');

        Route::get('/enquiry-details/{id}', 'EnquiryController@show')->name('admin-enquiry-details');


        // ------- Enquiry -------------//


        //--------STATE COUNTRY AJAX ROUTE---------------//

        Route::post('/ajax-state-get','UserController@getState')->name('admin-ajax-get-state-list');
        Route::post('/ajax-city-get', 'UserController@getCity')->name('admin-ajax-get-city-list');
        Route::post('/ajax-email-get','UserController@getEmail')->name('admin-ajax-email-get');

        
           /* _________________________REASON ROUTES____________________________ */
        Route::get('/reason-list','ReasonController@index')->name('admin-reason-list');
        Route::get('/reason-add','ReasonController@add')->name('admin-reason-add');
        Route::post('/reason-save','ReasonController@save')->name('admin-reason-save');
        Route::get('/reason-edit/{slug}','ReasonController@edit')->name('admin-reason-edit');
        Route::post('/reason-update','ReasonController@update')->name('admin-reason-update');
        Route::post('/reason-status-update','ReasonController@updateReasonStatus')->name('admin-reason-status-update');
        Route::post('/reason-delete-status', 'ReasonController@editDeleteStatus')->name('admin-reason-delete-status');
        
        //-----------------------------ADMIN PROPERTY ROUTE-----------------//
        Route::get('/property-list', 'PropertyController@index')->name('admin-property-list');


        Route::get('/property-list-seller-wise', 'PropertyController@seller_wise_property')->name('admin-property-list-seller-wise');

        Route::post('/ajax-get-category-list', 'PropertyController@ajaxgetcategorylist')->name('admin-ajax-get-category-list');

        Route::post('/ajax-property-image-delete', 'PropertyController@ajaxpropertyimagedelete')->name('admin-ajax-property-image-delete');


        Route::post('/ajax-get-ownder-details', 'PropertyController@ajaxgetownderdetails')->name('admin-ajax-get-ownder-details');
        
        //Pending Property where timer expire sale status 0 in offfer table
        Route::get('/pending-property-list', 'PropertyController@pendingProperty')->name('admin-pending-property-list');

        Route::get('/property-add', 'PropertyController@add')->name('admin-property-add');

        Route::post('/property-save', 'PropertyController@save')->name('admin-property-save');

        Route::get('/property-edit/{slug}', 'PropertyController@edit')->name('admin-property-edit');

        Route::post('/property-update', 'PropertyController@update')->name('admin-property-update');

        Route::get('/property-details/{slug}', 'PropertyController@show')->name('admin-property-details');

        Route::post('/property-status-update', 'PropertyController@updatePropertyStatus')->name('admin-property-status-update');

        Route::post('/property-publish-status-update', 'PropertyController@updatePropertyPublishStatus')->name('admin-property-publish-status-update');

        Route::post('/property-delete', 'PropertyController@deleteProperty')->name('admin-property-delete');

        Route::get('/soft-deleted-property-list', 'PropertyController@softDeletedProperty')->name('admin-soft-deleted-property-list');
        
        Route::get('/property-gallery/{slug}', 'PropertyGalleryController@viewGallery')->name('admin-property-gallery-view');


        //--------------ADMIN PROPERTY GALLERY ROUTE-----------------//

        Route::post('/property-gallery-attachment-save-ajax', 'PropertyGalleryController@storepropertyimage')->name('admin-upload-gallery-ajax');

        Route::post('/property-gallery-attachment-delete', 'PropertyGalleryController@deleteImage')->name('admin-property-image-delete');


        //=================CMS PAGE======================================

        Route::get('/faq-list', 'FaqController@index')->name('admin-faq-list');
        Route::get('/faq-add', 'FaqController@add')->name('admin-faq-add');
        Route::post('/faq-save', 'FaqController@save')->name('admin-faq-save');
        Route::get('/faq-edit/{id}', 'FaqController@edit')->name('admin-faq-edit');
        Route::post('/faq-update', 'FaqController@update')->name('admin-faq-update');
        Route::post('/faq-delete', 'FaqController@deleteFaq')->name('admin-faq-delete');
        Route::post('/status-update', 'FaqController@statusUpdateFaq')->name('admin-faq-status-update');

        //--------------ADMIN CMS PAGE ROUTE-----------------//
        Route::get('/page-list', 'CmsPageController@index')->name('admin-cms-page-list');
        Route::get('/page-add', 'CmsPageController@add')->name('admin-cms-page-add');
        Route::post('/page-save', 'CmsPageController@save')->name('admin-cms-page-save');
        Route::get('/page-edit/{slug}', 'CmsPageController@edit')->name('admin-cms-page-edit');
        Route::post('/page-update', 'CmsPageController@update')->name('admin-cms-page-update');
        Route::post('/page-status-update', 'CmsPageController@updatePageStatus')->name('admin-page-status-update');
        Route::post('/page-delete', 'CmsPageController@deletePage')->name('admin-page-delete');
        Route::get('/page-details/{slug}', 'CmsPageController@show')->name('admin-cms-page-detail');

        // === SystemSettingController ===
        Route::get('/system-settings', 'SystemSettingController@index')->name('admin-system-settings');

        Route::post('/edit-system-setting-post', 'SystemSettingController@update')->name('admin-edit-system-setting-post');

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
   
    });
});