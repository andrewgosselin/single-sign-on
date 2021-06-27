<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users_index() {
        $users = \App\Models\User::paginate(5);
        return view('pages.admin.users.index')
            ->with('users', $users);
    }
    public function users_view($guid) {
        $user = \App\Models\User::where("guid", '=', $guid);
        if($user->count() > 0) {
            $user = $user->first();
        } else {
            abort(404, "User not found.");
        }
        $editable = ($guid == \Auth::user()->guid); // TODO: Check permission for editing users in tenant.
        return view('pages.admin.users.view')
            ->with('editable', $editable)
            ->with('user', $user);
    }
    public function applications_index() {
        $applications = \App\Models\Application::paginate(5);
        return view('pages.admin.applications.index')
            ->with('applications', $applications);
    }
    public function applications_view($guid) {
        $application = \App\Models\Application::where("guid", '=', $guid);
        if($application->count() > 0) {
            $application = $application->first();
        } else {
            abort(404, "Application not found.");
        }
        // dd($application->getClientAttribute());
        $editable = true; // TODO: Check permission for editing application.
        return view('pages.admin.applications.view')
            ->with('editable', $editable)
            ->with('application', $application);
    }

    public function tenants_index() {
        $tenants = \App\Models\Tenant::paginate(5);
        $editable = true; // TODO: Check permission for editing application.
        return view('pages.admin.tenants.index')
            ->with('editable', $editable)
            ->with('tenants', $tenants);
    }
}