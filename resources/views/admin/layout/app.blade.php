
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin | Dashboard</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

{{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">

<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
</li>
<li class="nav-item d-none d-sm-inline-block">
<a href="index3.html" class="nav-link">Home</a>
</li>
<li class="nav-item d-none d-sm-inline-block">
<a href="#" class="nav-link">Contact</a>
</li>
</ul>

<ul class="navbar-nav ml-auto">

<li class="nav-item">
<a class="nav-link" data-widget="navbar-search" href="#" role="button">
<i class="fas fa-search"></i>
</a>
<div class="navbar-search-block">
<form class="form-inline">
<div class="input-group input-group-sm">
<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
<div class="input-group-append">
<button class="btn btn-navbar" type="submit">
<i class="fas fa-search"></i>
</button>
<button class="btn btn-navbar" type="button" data-widget="navbar-search">
<i class="fas fa-times"></i>
</button>
</div>
</div>
</form>
</div>
</li>

<li class="nav-item dropdown">
<a class="nav-link" data-toggle="dropdown" href="#">
<i class="far fa-comments"></i>
<span class="badge badge-danger navbar-badge">3</span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
<a href="#" class="dropdown-item">

<div class="media">
<img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
<div class="media-body">
<h3 class="dropdown-item-title">
Brad Diesel
<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
</h3>
<p class="text-sm">Call me whenever you can...</p>
<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
</div>
</div>

</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">

<div class="media">
<img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
<div class="media-body">
<h3 class="dropdown-item-title">
John Pierce
<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
</h3>
<p class="text-sm">I got your message bro</p>
<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
</div>
</div>

</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">

<div class="media">
<img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
<div class="media-body">
<h3 class="dropdown-item-title">
Nora Silvester
<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
</h3>
<p class="text-sm">The subject goes here</p>
<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
</div>
</div>

</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
</div>
</li>

<li class="nav-item dropdown">
<a class="nav-link" data-toggle="dropdown" href="#">
<i class="far fa-bell"></i>
<span class="badge badge-warning navbar-badge">15</span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
<span class="dropdown-header">15 Notifications</span>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">
<i class="fas fa-envelope mr-2"></i> 4 new messages
<span class="float-right text-muted text-sm">3 mins</span>
</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">
<i class="fas fa-users mr-2"></i> 8 friend requests
<span class="float-right text-muted text-sm">12 hours</span>
</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">
<i class="fas fa-file mr-2"></i> 3 new reports
<span class="float-right text-muted text-sm">2 days</span>
</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
</div>
</li>
<li class="nav-item">
<a class="nav-link" data-widget="fullscreen" href="#" role="button">
<i class="fas fa-expand-arrows-alt"></i>
</a>
</li>
<li class="nav-item">
<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
<i class="fas fa-th-large"></i>
</a>
</li>
</ul>
</nav>


<aside class="main-sidebar sidebar-dark-primary elevation-4">

<a href="index3.html" class="brand-link">
<img src="" alt="{{ settings('app_name') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
<span class="brand-text font-weight-light">{{ settings('app_name') }}</span>
</a>

<div class="sidebar">

<div class="user-panel mt-3 pb-3 mb-3 d-flex">
<div class="image">
<img src="{{  auth()->user()->avatar}}" class="img-circle elevation-2" alt="User Image">
</div>
<div class="info">
<a href="#" class="d-block">{{ auth()->user()->name }}</a>
</div>
</div>



<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
<li class="nav-item">
<router-link to="/admin/dashboard" active-class="active" class="nav-link">
<i class="nav-icon fas fa-tachometer-alt"></i>
<p>
Dashboard
<span class="right badge badge-danger">New</span>
</p>
</router-link>
</li>

<li class="nav-item">
    <router-link to="/admin/appointments" :class="$route.path.startsWith('/admin/appointments') ? 'active' : ''" class="nav-link">
    <i class="nav-icon fas fa-calendar-alt"></i>
    <p>
        Appointments
    <span class="right badge badge-danger">New</span>
    </p>
    </router-link>
    </li>
    <li class="nav-item">
        <router-link to="/admin/listUsers" active-class="active" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
        <p>
            Users
        <span class="right badge badge-danger">New</span>
        </p>
        </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/admin/updateSettings"  active-class="active" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
            <p>
                Settings
            <span class="right badge badge-danger">New</span>
            </p>
            </router-link>            </li>
            <li class="nav-item">
                <router-link to="/admin/profile"  active-class="active" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                <p>
                    Profile
                <span class="right badge badge-danger">New</span>
                </p>
                </router-link>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="nav-link">
                        @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"  >
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                        Logout
                    </p>
                   </a>
                </form>
                </form>
                    </li>

</ul>
</nav>

</div>

</aside>

<div class="content-wrapper">

<router-view></router-view>
</div>


<aside class="control-sidebar control-sidebar-dark">

<div class="p-3">
<h5>Title</h5>
<p>Sidebar content</p>
</div>
</aside>


<footer class="main-footer">

<div class="float-right d-none d-sm-inline">
Anything you want
</div>

<strong>Copyright &copy; {{ date('y') }} <a href="https://adminlte.io">{{ settings('app_name') }}</a>.</strong> All rights reserved.
</footer> --}}
</div>





</body>
</html>
