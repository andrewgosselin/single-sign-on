<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index() {
        if(config('application.general.multiTenant')) {
            $tenant = \Auth::user()->tenant;
            $applications = $tenant->applications()->paginate(5);
        } else {
            $tenant = \Auth::user()->tenant;
            $tenant->applications()->sync(\App\Models\Application::pluck('guid'));
        }
        $tenant = \Auth::user()->tenant;
        $applications = $tenant->applications()->paginate(5);
        return view('pages.applications.index')
            ->with('applications', $applications);
    }
    public function view($guid) {
        $tenant = \Auth::user()->tenant;
        $applications = $tenant->applications;
        $application = $applications->where("guid", '=', $guid);
        
        if($application->count() > 0) {
            $application = $application->first();
        } else {
            abort(404, "Application not found.");
        }
        $editable = true; // TODO: Check permission for editing application.
        return view('pages.applications.view')
            ->with('editable', $editable)
            ->with('application', $application);
    }

    public function store() {
        $tenant = \Auth::user()->tenant;
        $applications = $tenant->applications;
    }

    public function update() {
        $tenant = \Auth::user()->tenant;
        $applications = $tenant->applications;
        $application = $applications->where("guid", '=', $guid);
        
        if($application->count() > 0) {
            $application = $application->first();
        } else {
            abort(404, "Application not found.");
        }
    }
}
