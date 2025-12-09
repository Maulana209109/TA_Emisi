<aside class="w-64 bg-white shadow-md max-h-screen sticky top-0">
    <div class="p-6 font-bold text-purple-700 text-2xl">AdminPanel</div>
    <nav class="mt-8">
        <a href="#" class="block py-3 px-6 text-gray-700 hover:bg-purple-100">Dashboard</a>
        <a href="#" class="block py-3 px-6 text-gray-700 hover:bg-purple-100">Users</a>
        <a href="#" class="block py-3 px-6 text-gray-700 hover:bg-purple-100">Analytics</a>
        <a href="#" class="block py-3 px-6 text-gray-700 hover:bg-purple-100">Settings</a>
        <form class="block py-3 px-6 text-gray-700 hover:bg-purple-100 cursor-pointer" action="{{ route('logout') }}"
            method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>
</aside>
