<?php

Route::group(['module' => 'CRM', 'middleware' => ['api'], 'namespace' => 'App\Modules\Meeting\Controllers'], function() {

//    Route::resource('Payment', 'PaymentController');
    Route::post('get-client-information', "AccountsController@getClientInformation");

});
