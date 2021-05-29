@extends('layouts.app')

@section('content')
<div class="container pt-3">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in! You should be automatically logged into any site implementing this SSO!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
