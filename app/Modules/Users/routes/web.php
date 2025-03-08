<?php


Route::group(array('module' => 'Users', 'middleware' => ['web', 'auth'], 'namespace' => '\App\Modules\Users\Controllers'), function() {

    /* User related */
    Route::get('/users/lists', "UsersController@lists");
    Route::get('/users/contact-lists', "UsersController@getContactUserList");
    Route::get('/users/rejected-user-lists', "UsersController@rejectedUserLists");


   
    Route::get('users/view/{id}', "UsersController@view");
    Route::patch('/users/update/{id}', "UsersController@update");
    Route::get('/users/activate/{id}', "UsersController@activate");
    Route::get('/users/edit/{id}', "UsersController@edit");
   

    /* End of User related */

    /* New User Creation by Admin */
    
    Route::get('users/create-new-user', "UsersController@createNewUser");
    Route::patch('/users/store-new-user', "UsersController@storeNewUser");
    /* End of New User Creation by Admin */


    /* Reset Password from profile and Admin list */

    Route::get('users/reset-password/{confirmationCode}', [
        'as' => 'confirmation_path',
        'uses' => 'UsersController@resetPassword'
    ]);

    /*
     * datatable
     */
    Route::post('users/get-user-list', "UsersController@getList");
    Route::post('users/get-server-time', "UsersController@getServerTime");

//    user approval or reject
    Route::post('/users/approve/{id}', "UsersController@approveUser");
    Route::post('/users/reject/{id}', "UsersController@rejectUser");

    /*   To step Verification */
    Route::get('/users/two-step', 'UsersController@twoStep');
    Route::patch('/users/check-two-step', 'UsersController@checkTwoStep');
    Route::patch('/users/verify-two-step', 'UsersController@verifyTwoStep');
});

// Only Login User can do it.
Route::group(array('module' => 'Users', 'middleware' => ['web', 'auth','XssProtection'], 'namespace' => '\App\Modules\Users\Controllers'), function() {

    /* User profile update */
    Route::get('users/profileinfo', "UsersController@profileInfo");
    Route::post('users/profile_updates/{id}', [
        'uses' => 'UsersController@profile_update'
    ]);

    Route::patch('users/update-password-from-profile', "UsersController@updatePassFromProfile");

});


// Without Authorization (Login is not required)

Route::group(array('module' => 'Users', 'middleware' => ['web'], 'namespace' => '\App\Modules\Users\Controllers'), function() {

    Route::get('/users/login', function () {
        return redirect('login');
    });

    Route::get('/users/message', "UsersController@message");
   

    Route::get('/users/create', [
        'as' => 'user_create_url',
        'uses' => 'UsersController@create'
    ]);
    Route::patch('/users/store', "UsersController@store");


    Route::get('/users/get-userdesk-by-type', 'UsersController@getUserDeskByType');

    //Mail Re-sending
    Route::get('users/reSendEmail', "UsersController@reSendEmail");
    Route::patch('users/reSendEmailConfirm', "UsersController@reSendEmailConfirm");
    Route::get('users/helpdesk-contact', "UsersController@helpdeskContact");

    Route::get('/users/get-district-by-division', 'UsersController@getDistrictByDivision');
    Route::get('/users/get-thana-by-district-id', 'UsersController@get_thana_by_district_id');


    Route::get('/users/get-uisc', 'UsersController@getUISClist');
    Route::get('/users/get-barnch-by-bank-id', 'UsersController@getBranchByBankId');
    Route::get('/users/get-routing-no-by-branch-id', 'UsersController@getRoutingNoByBranchId');
    Route::post('/users/validateAutoCompleteData/{type}', 'UsersController@validateAutoCompleteData');
    Route::get('/users/get-agency', 'UsersController@getAgencylist');
    Route::get('/users/resendMail', 'UsersController@resendMail');
    Route::get('users/get-user-session', 'UsersController@getUserSession');
    Route::get('users/resendMailByAdmin/{email}', "UsersController@resendMailByAdmin");

    Route::get('users/view/{id}/{openMode}', "UsersController@appFormEditView");

    /*     * ********************** End of Route Group *********************** */
});
