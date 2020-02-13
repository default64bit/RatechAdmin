<?php

Route::group(['namespace'=>'AdminPanel','prefix'=>'admin'], function () {
    Route::get('/', 'HomeController@index');

    Route::group(['namespace' => 'AdminAuth'], function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::any('/logout', 'LoginController@logout')->name('logout');    
        // Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.request');
        // Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        // Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
        // Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.email');
    });

    Route::group(['middleware' => ['admin', 'auth:admin']], function () {
        Route::get('/home', 'HomeController@home');
        Route::get('/profile', 'HomeController@profile');
        Route::post('/edit_profile', 'HomeController@edit_profile');
        Route::post('/change_password', 'HomeController@change_password');

        Route::resources(['admins'=>'AdminsController']);
        Route::post('admins/{id}/disable','AdminsController@disable');
        Route::get('admins/{id}/transform','AdminsController@transform_page');
        Route::post('admins/{id}/transform','AdminsController@transform');
        
        Route::resources(['roles'=>'RolesController']);
        Route::post('roles/{id}/disable','RolesController@disable');
        Route::get('roles/{id}/transform','RolesController@transform_page');
        Route::post('roles/{id}/transform','RolesController@transform');

        // Route::resources(['permissions'=>'PermissionsController']);

        //route insert head ->
        
        Route::resources(['panel_settings' => 'Panel_settingsController']);
    });
});


Route::get('/{path?}',function(){
    return view('app');
})->where('path','.*');

