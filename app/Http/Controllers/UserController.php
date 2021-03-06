<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        if(config('application.general.multiTenant')) {
            $tenant = \Auth::user()->tenant;
            $users = $tenant->users->paginate(5);
        } else {
            $users = \App\Models\User::paginate(5);
        }
        return view('pages.users.index')
            ->with('users', $users);
    }
    public function view($id) {
        if(config('application.general.multiTenant')) {
            $user = \Auth::user()->tenant->users->where("id", '=', $id);
        } else {
            $user = \App\Models\User::where("id", '=', $id);
        }
        if($user->count() > 0) {
            $user = $user->first();
        } else {
            abort(404, "User not found.");
        }
        $editable = ($id == \Auth::user()->id); // TODO: Check permission for editing users in tenant.
        return view('pages.users.view')
            ->with('editable', $editable)
            ->with('user', $user);
    }
    public function profile() {
        $user = \Auth::user();
        return view('pages.users.view')
            ->with('editable', true)
            ->with('user', $user);
    }
}
