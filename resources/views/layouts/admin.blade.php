<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Carbon Tracker</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            -webkit-font-smoothing: antialiased;
        }
        /* Sidebar */
        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #064e3b 0%, #065f46 60%, #047857 100%);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 40;
        }
        .sidebar-logo {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }
        .sidebar-nav { padding: 1rem 0.75rem; flex: 1; }
        .nav-section-label {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            padding: 0.75rem 0.5rem 0.35rem;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.6rem 0.75rem;
            border-radius: 0.625rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.15s;
            margin-bottom: 2px;
        }
        .nav-link:hover { background: rgba(255,255,255,0.1); color: white; }
        .nav-link.active { background: rgba(255,255,255,0.18); color: white; font-weight: 600; }
        .nav-link i { width: 16px; text-align: center; font-size: 0.8rem; opacity: 0.85; }
        /* Content */
        .main-content { margin-left: 240px; min-height: 100vh; }
        .top-bar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 30;
        }
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white; padding: 0.5rem 1rem;
            border-radius: 0.5rem; font-weight: 600; font-size: 0.8rem;
            border: none; cursor: pointer; transition: transform 0.15s, box-shadow 0.15s;
            display: inline-flex; align-items: center; gap: 0.375rem;
            text-decoration: none;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(22,163,74,0.3); }
        .btn-danger {
            background: #fef2f2; color: #dc2626;
            padding: 0.4rem 0.75rem; border-radius: 0.5rem;
            font-weight: 600; font-size: 0.75rem; border: 1px solid #fecaca;
            cursor: pointer; transition: background 0.15s; display: inline-flex; align-items: center; gap: 0.25rem;
        }
        .btn-danger:hover { background: #fee2e2; }
        .btn-edit {
            background: #eff6ff; color: #2563eb;
            padding: 0.4rem 0.75rem; border-radius: 0.5rem;
            font-weight: 600; font-size: 0.75rem; border: 1px solid #bfdbfe;
            cursor: pointer; transition: background 0.15s; display: inline-flex; align-items: center; gap: 0.25rem;
        }
        .btn-edit:hover { background: #dbeafe; }
        /* Card */
        .card { background: white; border-radius: 1rem; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            background: #f8fafc; padding: 0.75rem 1rem;
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.05em; color: #64748b;
            border-bottom: 1px solid #e2e8f0; text-align: left;
        }
        .data-table td {
            padding: 0.875rem 1rem; font-size: 0.825rem;
            border-bottom: 1px solid #f1f5f9; color: #374151;
        }
        .data-table tr:hover td { background: #f8fafc; }
        /* Input */
        .input-field {
            width: 100%; padding: 0.625rem 0.875rem;
            border: 1.5px solid #e2e8f0; border-radius: 0.5rem;
            font-size: 0.85rem; background: #f8fafc; color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
            font-family: inherit;
        }
        .input-field:focus { border-color: #16a34a; box-shadow: 0 0 0 3px rgba(22,163,74,0.12); background: white; }
        /* Animations */
        .fade-in { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Alert */
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 0.75rem; padding: 0.875rem 1rem; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-radius: 0.75rem; padding: 0.875rem 1rem; }
        /* Modal */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); backdrop-filter: blur(4px); z-index: 100; display: none; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal-box { background: white; border-radius: 1.25rem; padding: 2rem; width: 100%; max-width: 460px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); margin: 1rem; }
    </style>
</head>
<body>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar">
        {{-- Logo --}}
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-leaf text-white text-sm"></i>
                </div>
                <div>
                    <p class="text-white font-bold text-sm leading-tight">Carbon Tracker</p>
                    <p class="text-white/50 text-xs">Admin Panel</p>
                </div>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            <p class="nav-section-label">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>

            <p class="nav-section-label" style="margin-top: 0.5rem;">Data Master</p>

            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Manajemen Pengguna
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Kategori Emisi
            </a>

            <a href="{{ route('admin.factors.index') }}"
               class="nav-link {{ request()->routeIs('admin.factors.*') ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i> Faktor Emisi
            </a>
        </nav>

        {{-- Footer / Logout --}}
        <div class="px-3 pb-5 mt-auto border-t border-white/10 pt-4">
            <div class="flex items-center gap-2.5 px-2 mb-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-xs">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-white/40 text-xs">Administrator</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link w-full text-left" style="color: rgba(255,255,255,0.55); hover:color: white;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="main-content">
        {{-- Top Bar --}}
        <div class="top-bar">
            <div>
                <h2 class="font-bold text-gray-800 text-base">@yield('page-title', 'Dashboard')</h2>
                <p class="text-xs text-gray-400">@yield('page-subtitle', 'Panel Administrasi Carbon Tracker')</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400">{{ now()->format('d M Y, H:i') }} WIB</span>
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-green-700 font-bold text-sm">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                </div>
            </div>
        </div>

        {{-- Page Content --}}
        <div class="p-6 fade-in">
            @if(session('success'))
                <div class="alert-success mb-5 flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-600"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-danger mb-5 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>