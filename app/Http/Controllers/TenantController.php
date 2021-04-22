<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantController extends Controller
{
    
    public function tenant() {
        $application = \App\Models\Application::first();
        dd($application->client);
    }
}
