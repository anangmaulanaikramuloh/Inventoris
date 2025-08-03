<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 280px;
            min-height: 100vh;
            transition: margin-left .35s;
        }
        .sidebar.collapsed {
            margin-left: -280px;
        }
        .main-content {
            flex-grow: 1;
            transition: margin-left .35s;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                margin-left: -280px;
            }
            .sidebar.collapsed {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        @guest
            <main>
                @yield('content')
            </main>
        @else
            <div class="d-flex">
                <aside id="sidebar" class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
                    <a href="{{ url('/home') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <i class="bi bi-box-seam me-2" style="font-size: 2rem;"></i>
                        <span class="fs-4">Sistem Inventaris</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link text-white {{ request()->is('home') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}" class="nav-link text-white {{ request()->is('categories*') ? 'active' : '' }}">
                                <i class="bi bi-tags me-2"></i> Kategori
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('items.index') }}" class="nav-link text-white {{ request()->is('items*') ? 'active' : '' }}">
                                <i class="bi bi-list-ul me-2"></i> Barang
                            </a>
                        </li>
                        <li>
                            <a href="#reports-submenu" data-bs-toggle="collapse" class="nav-link text-white {{ request()->is('reports*') ? 'active' : '' }}" aria-expanded="{{ request()->is('reports*') ? 'true' : 'false' }}">
                                <i class="bi bi-graph-up me-2"></i> Laporan
                            </a>
                            <ul class="collapse list-unstyled {{ request()->is('reports*') ? 'show' : '' }}" id="reports-submenu">
                                <li>
                                    <a href="{{ route('reports.current_stock') }}" class="nav-link text-white {{ request()->is('reports/current-stock') ? 'active' : '' }}">
                                        <i class="bi bi-circle me-2"></i> Stok Saat Ini
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('reports.stock_movement') }}" class="nav-link text-white {{ request()->is('reports/stock-movement') ? 'active' : '' }}">
                                        <i class="bi bi-arrow-left-right me-2"></i> Pergerakan Stok
                                    </a>
                                </li>
                            </ul>
                        </li>
                @can('manage users')
                <li>
                    <a href="{{ route('users.index') }}" class="nav-link text-white {{ request()->is('users*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i> Manajemen Pengguna
                    </a>
                </li>
                @endcan
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i>
                            <strong>{{ Auth::user()->name }}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="bi bi-person me-2"></i>Profil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </aside>

                <div id="main-content" class="main-content">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                        <div class="container-fluid">
                            <button class="btn btn-primary" id="sidebar-toggler" type="button">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                    </nav>
                    <main class="container-fluid p-4">
                        @yield('content')
                    </main>
                </div>
            </div>
        @endguest
    </div>
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const toggler = document.getElementById('sidebar-toggler');

            toggler.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
            });
        });
    </script>
    @endauth
</body>
</html>