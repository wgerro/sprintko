<?php

$install = 'Admin\InstallController@';
Route::get('/', $install.'index');
Route::post('/', $install.'install')->name('install');
Route::post('/check', $install.'check_db')->name('install-check');