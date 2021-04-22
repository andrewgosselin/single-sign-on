<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x: hidden;">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Andrew Gosselin">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="/css/app.layout.css" rel="stylesheet">
    <script src="/js/app.layout.js"></script>

    <link href="/css/tables.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .avatar {
        vertical-align: middle;
        width: 50px;
        height: 50px;
        border-radius: 50%;
      }

    </style>

      
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  @auth
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">{{\Auth::user()->tenant->name}}</a>
  @endauth
  @guest
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">{{config('application.general.baseName')}}</a>
  @endguest
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="/logout">Sign out</a>
    </li>
  </ul>
</header>
<header class="navbar sub sticky-top bg-transparent flex-md-nowrap p-0 shadow">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#" onclick="window.history.back();">Back</a>
    </li>
  </ul>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-1">
        
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}" aria-current="page" href="/dashboard">
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('profile')) ? 'active' : '' }}" href="/profile">
              Profile
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          @if(config('application.general.multiTenant'))
          <span>Tenant Settings</span>
          @else
          <span>Settings</span>
          @endif
        </h6>
        <ul class="nav flex-column mb-2">
          <!-- <li class="nav-item">
            <a class="nav-link {{ (request()->is('dictionary')) ? 'active' : '' }}" href="/dictionary">
              <span data-feather="file-text"></span>
              Dictionary
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('branding')) ? 'active' : '' }}" href="/branding">
              <span data-feather="file-text"></span>
              Branding
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('applications*')) ? 'active' : '' }}" href="/applications">
              <span data-feather="file-text"></span>
              Applications
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('users*')) ? 'active' : '' }}" href="/users">
              Users
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Administration</span>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('admin/tenants*')) ? 'active' : '' }}" href="/admin/tenants">
              <span data-feather="file-text"></span>
              Tenants
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('admin/applications*')) ? 'active' : '' }}" href="/admin/applications">
              <span data-feather="file-text"></span>
              Applications
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('admin/users*')) ? 'active' : '' }}" href="/admin/users">
              <span data-feather="file-text"></span>
              Users
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      @yield('content')
    </main>
  </div>
</div>


  </body>
</html>
