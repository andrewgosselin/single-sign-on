@extends('layouts.app')

@section('content')
<div class="container pt-3">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="mb-0">User Information</h3>
                </div>
                <div class="card-body">

                    @if(isset($user))
                        {{$user->name}} <br>
                        {{$user->email}} <br>
                        Tenant: {{$user->tenant->name}} ({{$user->tenant->guid}}) <br>
                        Editable: {{$editable}}
                    @else
                        This user is invalid.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
