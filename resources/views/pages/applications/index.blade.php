@extends('layouts.app')

@section('content')
<style>

    </style>
<div class="container pt-3">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                <h3 class="mb-0">Applications</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Roles</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $aIndex => $application)
                            <tr>
                                <td>
                                {{$application->name}}
                                </td>
                                <td>
                                {{$application->roles->count()}}
                                </td>
                                <td class="text-right">
                                    <a type="button" class="btn btn-primary btn-sm" href="/applications/{{$application->guid}}">View</a>
                                    <a type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Options
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Terminate</a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                    
                </div>
                <div class="card-footer py-4">
                    <nav aria-label="...">
                    <ul class="pagination justify-content-end mb-0">
                    {!! $applications->links() !!}
                    </ul>
                    </nav>
                </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
