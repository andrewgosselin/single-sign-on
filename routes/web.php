<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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



Route::get('/oauth/redirect', function () {
    return Socialite::driver(request()->get('type'))->redirect();
});
Route::get('/oauth/callback', function () {
    if(!in_array(request()->get("type"), ["github"])) {
        abort(404);
    }
    $githubUser = Socialite::driver(request()->get("type"))->user();
    $user = User::where("email", $githubUser->email)->first();
    if($user) {
        $user->update([
            "github_id" => $githubUser->id
        ]);
    } else {
        return redirect("/register");
    }
    // $user = User::updateOrCreate([
    //     'github.id' => $githubUser->id,
    // ], [
    //     'name' => $githubUser->name,
    //     'email' => $githubUser->email,
    //     // 'github_token' => $githubUser->token,
    //     // 'github_refresh_token' => $githubUser->refreshToken,
    // ]);
 
    Auth::login($user);

    return redirect("/home");
});

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