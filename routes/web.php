<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/notifications', 'Users\Recruiter\RecruiterNotificationController@show')->name('notifications.show');

Route::middleware('roles:admin')->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', 'Users\Admin\DashboardController@index')->name('dashboard');
    Route::resource('/notifications', 'Users\Admin\NotificationController');
});
