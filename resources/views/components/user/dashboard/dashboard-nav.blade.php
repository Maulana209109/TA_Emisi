<header class="w-full py-3 border-b bg-white sticky top-0 z-30 shadow-sm">
  <div class="container mx-auto flex items-center justify-between ">
    <!-- Logo -->
    <a href="{{ route('user.dashboard') }}" class="text-2xl font-bold text-gray-800 ">Jejak Karbon</a>

    <!-- Desktop Navigation -->
    <nav class="hidden lg:flex space-x-4 items-center">
      {{-- <a href="#" class="text-xs font-semibold text-gray-700  hover:text-gray-500">Homepage</a> --}}
      <a href="{{ route('emission.dashboard') }}" class="text-xs font-semibold text-gray-700  hover:text-gray-500">Hitung Karbon</a>
      <a href="#" class="text-xs font-semibold text-gray-700  hover:text-gray-500">Features</a>
      <a href="#" class="text-xs font-semibold text-gray-700  hover:text-gray-500">Blog</a>
      <a href="#" class="text-xs font-semibold text-gray-700  hover:text-gray-500">Contact Us</a>
    </nav>

    <!-- Desktop Buttons -->
    <div class="hidden lg:flex space-x-4">
      {{-- <button class="text-sm py-1 px-3 border border-gray-800 text-gray-800 dark:text-white rounded-xl shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">Demo</button> --}}
      <form class="text-sm py-1 px-3 border border-gray-800 text-gray-800  rounded-xl shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition" action="{{ route('logout') }}"
            method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
      <button class="text-sm py-1 px-3 bg-black text-white rounded-xl shadow-lg hover:bg-gray-900 transition">Get Started</button>
    </div>

    <!-- Mobile Hamburger -->
    <button class="lg:hidden flex flex-col justify-between w-6 h-5">
      <span class="block h-1 w-full bg-gray-800 dark:bg-white rounded"></span>
      <span class="block h-1 w-full bg-gray-800 dark:bg-white rounded"></span>
      <span class="block h-1 w-full bg-gray-800 dark:bg-white rounded"></span>
    </button>
  </div>
</header>