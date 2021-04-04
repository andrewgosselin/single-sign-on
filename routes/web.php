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
Route::view('/', 'welcome');
Route::get('/test', function () {
    //Applications
    $portfolio = \App\Models\Application::create([
        "name" => "Portfolio Site"
    ]);
    $portfolio->createPermission([
        "name" => "Access Site"
    ]);


    // Creating a tenant
    $tenant = \App\Models\Tenant::create([
        "name" => "Test Tenant"
    ]);
    $tenant->applications()->attach([$portfolio->guid]);
    $tenant->createRole($portfolio->guid, [
        "name" => "Admin"
    ]);

    //
    $user = $tenant->createUser([
        "first_name" => "andrew",
        "last_name" => "gosselin",
        "email" => \Illuminate\Support\Str::random(5) . "@example.com",
        "password" => "appletree734"
    ]);
    $user->roles()->attach($tenant->roles->where('application_guid', '=', $portfolio->guid)->first());


    dd([
        "Tenant" => $tenant->with('applications')->with('users')->with('roles')->first()->toArray(),
        "User" => $user->with('tenants')->with('roles')->first()->toArray(),
        "Applications" => \App\Models\Application::with('permissions')->get()->toArray(),
        "Application Client" => $portfolio->client
    ]);
});


Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/applications', function () {
    $application = \App\Models\Application::first();
    dd($application->client);
});