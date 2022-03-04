@extends('layouts.app')

@section('content')
<style>

    </style>
<div class="container pt-3">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                <h3 class="mb-0">Users</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Email</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $uIndex => $user)
                            <tr>
                                <td scope="row">
                                    <div class="media align-items-center">
                                    <a href="#" class="avatar rounded-circle mr-3">
                                        <img alt="Image placeholder" src="/img/default_avatar.png">
                                    </a>
                                    <div class="media-body">
                                        <span class="mb-0 text-sm">{{$user->name}}</span>
                                    </div>
                                    </div>
                                </td>
                                <td>
                                Active
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td class="text-right">
                                    <a type="button" class="btn btn-primary btn-sm" href="/users/{{$user->id}}">View</a>
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
                    {!! $users->links() !!}
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
