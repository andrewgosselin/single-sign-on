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
    $logged = \Auth::check();
    if($logged) {
        return redirect('/dashboard');
    } else {
        return view('welcome');
    }
});

Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
});

Auth::routes();



Route::get('/oauth/redirect', 'App\Http\Controllers\Auth\LoginController@oauthRedirect');
Route::get('/oauth/callback', 'App\Http\Controllers\Auth\LoginController@oauthCallback');

// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'pages.dashboard')->name('dashboard');

    Route::get('/applications', 'App\Http\Controllers\ApplicationController@index');
    Route::get('/applications/{guid}', 'App\Http\Controllers\ApplicationController@view');

    // Route::post('/applications', 'App\Http\Controllers\ApplicationController@store');
    // Route::put('/applications/{guid}', 'App\Http\Controllers\ApplicationController@update');
    
    Route::get('/tenant', 'App\Http\Controllers\TenantController@tenant'); // TODO
    
    Route::get('/profile', 'App\Http\Controllers\UserController@profile');
    Route::get('/users', 'App\Http\Controllers\UserController@index');
    Route::get('/users/{guid}', 'App\Http\Controllers\UserController@view');
    
    Route::get('/admin/tenants', 'App\Http\Controllers\AdminController@tenants_index'); // TODO
    Route::get('/admin/applications', 'App\Http\Controllers\AdminController@applications_index');
    Route::get('/admin/applications/{guid}', 'App\Http\Controllers\AdminController@applications_view');
    Route::get('/admin/users', 'App\Http\Controllers\AdminController@users_index');
    Route::get('/admin/users/{guid}', 'App\Http\Controllers\AdminController@users_view');
});