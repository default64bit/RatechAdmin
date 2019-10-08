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
        Route::resources(['roles'=>'RolesController']);
        Route::resources(['permissions'=>'PermissionsController']);
        
    });
});


Route::get('/{path?}',function(){
    return view('app');
})->where('path','.*');

