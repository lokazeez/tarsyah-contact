<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InfluencerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// GENERAL & AUTOCOMPLETE ROUTES
Route::get('/', [HomeController::class,'dashboard'])
    ->name('dashboard');


Route::get('/changeLanguage.{local}',[HomeController::class, 'changeLanguage'])
    ->name('changeLanguage');

Route::get('/usersAutoComplete',[UserController::class, 'usersAutoComplete'])
    ->name('usersAutoComplete');

// RESOURCES
Route::resource('admins', '\App\Http\Controllers\Admin\AdminController');
Route::resource('roles', '\App\Http\Controllers\Admin\RoleController');
Route::resource('users', '\App\Http\Controllers\Admin\UserController');
Route::resource('contacts', '\App\Http\Controllers\Admin\ContactController');
Route::resource('notifications', '\App\Http\Controllers\Admin\NotificationController');
Route::resource('settings', '\App\Http\Controllers\Admin\SettingController');

//Data Tables
Route::prefix('datatables')->name('datatables.')->group(function () {
    Route::POST('/getAdmins',[AdminController::class, 'getAdmins'])
        ->name('getAdmins');

    Route::POST('/getUsers',[UserController::class, 'getUsers'])
        ->name('getUsers');

    Route::POST('/getContacts',[ContactController::class, 'getContacts'])
        ->name('getContacts');

});



