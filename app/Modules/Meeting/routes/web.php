<?php

Route::group(['module' => 'Meeting', 'middleware' => ['web','auth', 'XssProtection'], 'namespace' => '\App\Modules\Meeting\Controllers'], function() {

    Route::get('/dashboard/task-meeting-calendar', "MeetingController@getTaskMeeting");

    Route::get('/meeting/lists', "MeetingController@lists");
    Route::get('/meeting/add-new/{ref?}/{ref_id?}', "MeetingController@addNew");
    Route::get('/meeting/get-meeting-list', "MeetingController@getList");
    Route::patch('/meeting/store-new-meeting', "MeetingController@storeNewMeetingData");
    Route::get('/meeting/edit/{id}', "MeetingController@editMeetingData");
    Route::get('/meeting/view/{id}', "MeetingController@viewMeetingData");
    Route::patch('/meeting/update-meeting', "MeetingController@updateMeetingData");
    
    Route::get('meeting/advance-against-expense', "MeetingController@AAElists");
    Route::get('meeting/import/sample_file', "MeetingController@sample");
    Route::patch('meeting/import/upload-excel', "MeetingController@uploadExcel");


    Route::get('/search-panel', "MeetingController@searchForm");
    Route::get('meeting/get-employee-with-user', "MeetingController@getEmployeeUser");

});