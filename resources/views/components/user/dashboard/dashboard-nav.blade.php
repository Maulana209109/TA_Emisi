<header class="w-full h-16 bg-white border-b border-gray-100 sticky top-0 z-30 shadow-sm">
    <div class="max-w-5xl mx-auto h-full flex items-center justify-between px-6">

        {{-- Logo --}}
        <a href="{{ route('emission.dashboard') }}" class="flex items-center gap-2.5 group">
            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center shadow-sm group-hover:bg-green-700 transition">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                </svg>
            </div>
            <span class="font-bold text-gray-800 text-lg tracking-tight">Jejak Karbon</span>
        </a>

        {{-- Navigation Links --}}
        <nav class="hidden md:flex items-center gap-1">
            <a href="{{ route('emission.dashboard') }}"
               class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-sm font-medium transition
               {{ request()->routeIs('emission.dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('emission.create') }}"
               class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-sm font-medium transition
               {{ request()->routeIs('emission.create') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Catat Emisi
            </a>
            <a href="{{ route('emission.history') }}"
               class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-sm font-medium transition
               {{ request()->routeIs('emission.history') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Riwayat
            </a>
        </nav>

        {{-- User Menu --}}
        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-2.5 border-r border-gray-200 pr-3 mr-1">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-green-700 font-semibold text-sm">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                </div>
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Pengguna' }}</p>
                    <p class="text-xs text-gray-400">Pengguna</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-red-50 hover:text-red-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="hidden md:inline">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>