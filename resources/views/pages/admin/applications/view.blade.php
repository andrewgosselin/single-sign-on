@extends('layouts.app')

@section('content')
<div class="container pt-3">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="mb-0">Application Information</h3>
                </div>
                <div class="card-body">

                    @if(isset($application))
                        Name: {{$application->name}} <br>
                        Client ID: {{$application->client->id}} <br>
                        Client Secret: {{$application->client->secret}} <br>
                    @else
                        This application is invalid.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
