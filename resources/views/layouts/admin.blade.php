<!DOCTY    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('vendor/admin-lte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'VisualImpairedAssistance') }} - Admin</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('vendor/admin-lte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- start of trial -->
            <div class="section-menu-left d-flex justify-content-left w-100 min-h-screen">
               <aside id="sidebarMenu" class="menu-list main-sidebar sidebar-dark-primary elevation-4 p-4 md:w-64 flex-shrink-0 transition-all duration-300 ease-in-out">
                    <a href="{{ route('admin.dashboard') }}" class="menu-item brand-link" style="text-decoration: none; font-size: 1.1em; font-weight: 800; color: #374151;">
                        <span class="center-heading brand-text font-weight-light">VisualImpairedAssistance</span>
                    </a>
                    <div class="sidebar center">
                        <nav class="center-item mt-2 center-item">
                            <ul class="menu-list nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                                
                                <li class="nav-item menu-item">
                                    <a href="{{ route('admin.dashboard') }}" class="d-flex justify-content-left align-items-center nav-link" style="text-decoration: none;">
                                        <i class="nav-icon mb-3 p-2 fas fa-tachometer-alt" width="20" height="20"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}" class="d-flex justify-content-left align-items-center nav-link" style="text-decoration: none;">
                                        <i class="nav-icon mb-3 p-2 fas fa-users"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a href="{{ route('admin.devices.index') }}" class="d-flex justify-content-left align-items-center nav-link" style="text-decoration: none;">
                                        <i class="nav-icon mb-3 p-2 fas fa-microchip"></i>
                                        <p >Devices</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}" class="d-flex justify-content-left align-items-center nav-link" style="text-decoration: none;">
                                        <i class="nav-icon mb-3 p-2 fas fa-user-shield"></i>
                                        <p>Roles & Permissions</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.danger-zones.index') }}" class="d-flex justify-content-left align-items-center nav-link" style="text-decoration: none;">
                                        <i class="nav-icon mb-3 p-2 fas fa-exclamation-triangle"></i>
                                        <p>Danger Zones</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.reports.index') }}" class="d-flex justify-content-left align-items-center nav-link" style="text-decoration: none; ">
                                        <i class="nav-icon mb-3 p-2 fas fa-file-alt"></i>
                                        <p>Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('logout') }}" class="d-flex justify-content-left align-items-center nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); closeDropdown(this);" style="text-decoration: none; ">
                                        <i class="nav-icon mb-3 p-2 fas fa-sign-out-alt"></i>
                                        <p>
                                                Logout
                                            
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </aside> 
                <!-- starting of nested div -->
                <div class="p-2 w-100 flex-grow">
                    <nav class="main-header d-flex justify-content justify-between navbar navbar-expand navbar-white navbar-light bg-white shadow-sm rounded-md p-2">
                        <ul class="navbar-nav menu-list">
                            <li class="nav-item menu-item">
                                <a id="pushMenuToggle" class="nav-link cursor-pointer text-gray-800 hover:text-blue-500 text-xl" href="#">
                                    <i class="fas fa-bars"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link" data-toggle="dropdown" href="#">
                                    {{ Auth::user()->name }} <i class="fas fa-user"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('logout') }}" class="dropdown-item logout-link"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit(); closeDropdown(this);">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </nav>

                    <div class="content-wrapper">
                        <div class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                <div class="col-sm-6">
                                <h1 class="m-0">@yield('title')</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="container-fluid">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('error') }}
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
                <footer class="main-footer p-4">
                    <strong>VisualImpairedAssistance © {{ date('Y') }}</strong>
                </footer>
            </div>


                </div>
            </div>
            <!-- end of trial  -->
            
        </div>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
        <!-- <script>
            function closeDropdown(element) {
                // Find the closest dropdown-menu and hide it
                var dropdownMenu = element.closest('.dropdown-menu');
                if (dropdownMenu) {
                    dropdownMenu.classList.remove('show');
                }
                // Also close the parent if needed (Bootstrap 4/5 compatibility)
                var parent = dropdownMenu && dropdownMenu.parentElement;
                if (parent && parent.classList.contains('show')) {
                    parent.classList.remove('show');
                }
            }
        </script> -->
        <script>
            /**
             * Closes the closest Bootstrap dropdown menu by removing the 'show' class.
             */
            function closeDropdown(element) {
                // Find the closest parent element with the 'dropdown-menu' class
                var dropdownMenu = element.closest('.dropdown-menu');
                if (dropdownMenu) {
                    // Remove Bootstrap's 'show' class to hide the dropdown menu
                    dropdownMenu.classList.remove('show');
                }
                
                // Also check and remove 'show' from the parent dropdown container
                // This is important for Bootstrap's dropdown component where 'show' can be on the parent `.dropdown` element.
                var parent = dropdownMenu && dropdownMenu.parentElement;
                if (parent && parent.classList.contains('show')) {
                    parent.classList.remove('show');
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const pushMenuToggle = document.getElementById('pushMenuToggleID');
                const sidebarMenu = document.getElementById('sidebarMenuID');

                if (pushMenuToggle && sidebarMenu) {
                    pushMenuToggle.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent default link behavior (e.g., navigating to #)

                        // Toggle the 'hidden' Tailwind CSS class on the sidebar to show/hide it
                        sidebarMenu.classList.toggle('hidden');
                    });
                }
            });
        </script>

    </body>
</html>