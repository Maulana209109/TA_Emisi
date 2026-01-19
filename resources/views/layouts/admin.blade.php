<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .h-350-px { height: 350px; }
    </style>
</head>
<body class="text-blueGray-700 antialiased">
    <div class="flex">
        <!-- Sidebar -->
        <nav class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6">
            <div class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
                <!-- Brand -->
                <a href="{{ route('admin.dashboard') }}" class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0">
                    Carbon Tracker Admin
                </a>

                <!-- Collapse -->
                <div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded">
                    <!-- Divider -->
                    <hr class="my-4 md:min-w-full">
                    
                    <!-- Heading -->
                    <h6 class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
                        Menu Admin
                    </h6>

                    <!-- Navigation -->
                    <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                        <li class="items-center">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="text-xs uppercase py-3 font-bold block {{ request()->routeIs('admin.dashboard') ? 'text-pink-500' : 'text-blueGray-700 hover:text-blueGray-500' }}">
                                <i class="fas fa-tv mr-2 text-sm {{ request()->routeIs('admin.dashboard') ? 'opacity-75' : 'text-blueGray-300' }}"></i>
                                Dashboard
                            </a>
                        </li>

                        <li class="items-center">
                            <a href="{{ route('admin.users.index') }}" 
                               class="text-xs uppercase py-3 font-bold block {{ request()->routeIs('admin.users.*') ? 'text-pink-500' : 'text-blueGray-700 hover:text-blueGray-500' }}">
                                <i class="fas fa-users mr-2 text-sm {{ request()->routeIs('admin.users.*') ? 'opacity-75' : 'text-blueGray-300' }}"></i>
                                Users
                            </a>
                        </li>

                        <li class="items-center">
                            <a href="{{ route('admin.categories.index') }}" 
                               class="text-xs uppercase py-3 font-bold block {{ request()->routeIs('admin.categories.*') ? 'text-pink-500' : 'text-blueGray-700 hover:text-blueGray-500' }}">
                                <i class="fas fa-layer-group mr-2 text-sm {{ request()->routeIs('admin.categories.*') ? 'opacity-75' : 'text-blueGray-300' }}"></i>
                                Kategori
                            </a>
                        </li>

                        <li class="items-center">
                            <a href="{{ route('admin.factors.index') }}" 
                               class="text-xs uppercase py-3 font-bold block {{ request()->routeIs('admin.factors.*') ? 'text-pink-500' : 'text-blueGray-700 hover:text-blueGray-500' }}">
                                <i class="fas fa-leaf mr-2 text-sm {{ request()->routeIs('admin.factors.*') ? 'opacity-75' : 'text-blueGray-300' }}"></i>
                                Faktor Emisi
                            </a>
                        </li>
                    </ul>

                    <!-- Divider -->
                    <hr class="my-4 md:min-w-full">

                    <!-- User Section -->
                    <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                        {{-- <li class="items-center">
                            <a href="{{ route('user.dashboard') }}" 
                               class="text-blueGray-700 hover:text-blueGray-500 text-xs uppercase py-3 font-bold block">
                                <i class="fas fa-home text-blueGray-300 mr-2 text-sm"></i>
                                Ke Beranda
                            </a>
                        </li> --}}
                        <li class="items-center">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blueGray-700 hover:text-blueGray-500 text-xs uppercase py-3 font-bold block w-full text-left">
                                    <i class="fas fa-sign-out-alt text-blueGray-300 mr-2 text-sm"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="relative md:ml-64 bg-blueGray-100 w-full min-h-screen">
            @yield('content')

            <!-- Footer -->
            {{-- <footer class="block py-4">
                <div class="container mx-auto px-4">
                    <hr class="mb-4 border-b-1 border-blueGray-200">
                    <div class="flex flex-wrap items-center md:justify-between justify-center">
                        <div class="w-full md:w-4/12 px-4">
                            <div class="text-sm text-blueGray-500 font-semibold py-1 text-center md:text-left">
                                Copyright © {{ date('Y') }} Carbon Tracker
                            </div>
                        </div>
                    </div>
                </div>
            </footer> --}}
        </div>
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>