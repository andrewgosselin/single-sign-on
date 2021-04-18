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

// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/dashboard', 'pages.dashboard')->name('dashboard');

Route::get('/applications', function () {
    $applications = \App\Models\Application::all();
    return view('pages.applications.index')
        ->with('applications', $applications);
});


Route::get('/tenants', function () {
    $application = \App\Models\Application::first();
    dd($application->client);
});
Route::get('/tenant', function () {
    $application = \App\Models\Application::first();
    dd($application->client);
});

Route::get('/profile', function () {
    $user = \Auth::user();
    return view('pages.users.profile')
        ->with('editable', true)
        ->with('user', $user);
});
Route::get('/users', function () {
    if(!config('application.general.multiTenant')) {
        $users = \App\Models\User::paginate(5);
    } else {
        $tenant = \Auth::user()->tenant;
        $users = $tenant->users->paginate(5);
    }
    return view('pages.users.index')
        ->with('users', $users);
});

Route::get('/users/{guid}', function ($guid) {
    if(config('application.general.multiTenant')) {
        $user = \Auth::user()->tenant->users->where("guid", '=', $guid);
    } else {
        $user = \App\Models\User::where("guid", '=', $guid);
    }
    
    if($user->count() > 0) {
        $user = $user->first();
    } else {
        abort(404, "User not found.");
    }
    $editable = ($guid == \Auth::user()->guid); // TODO: Check permission for editing users in tenant.
    return view('pages.users.profile')
        ->with('editable', $editable)
        ->with('user', $user);
});