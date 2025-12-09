<main class="p-6 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-sm text-gray-500">Total Users</p>
            <h2 class="text-3xl font-bold text-purple-700 mt-2">1,240</h2>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-sm text-gray-500">Revenue</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">$24,500</h2>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-sm text-gray-500">New Orders</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">320</h2>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-sm text-gray-500">Pending Tickets</p>
            <h2 class="text-3xl font-bold text-red-500 mt-2">12</h2>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b bg-purple-50 border-purple-100 flex justify-between items-center">
            <div class="font-bold text-purple-700 text-lg">User List</div>
            <span class="text-xs font-semibold bg-purple-200 text-purple-800 py-1 px-3 rounded-full">
                Total: {{ $users->count() }} Pengguna
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-purple-50 text-purple-800 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="p-4 border-b border-purple-100">Name</th>
                        <th class="p-4 border-b border-purple-100">Email</th>
                        <th class="p-4 border-b border-purple-100">Role</th>
                        <th class="p-4 border-b border-purple-100">Joined Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-purple-50 transition-colors duration-200">
                            <td class="p-4 font-medium text-gray-900">
                                <div class="flex items-center">
                                    <!-- Avatar Initials -->
                                    <div
                                        class="h-8 w-8 rounded-full bg-purple-200 flex items-center justify-center text-purple-700 font-bold text-xs mr-3">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="p-4 text-gray-600">{{ $user->email }}</td>
                            <td class="p-4">
                                @if ($user->role === 'admin')
                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-200">
                                        Admin
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-500 text-sm">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md grid grid-cols-2 md:grid-cols-4 gap-4">
        <button class="bg-purple-600 text-white py-3 rounded-lg shadow hover:bg-purple-700">Add User</button>
        <button class="bg-blue-600 text-white py-3 rounded-lg shadow hover:bg-blue-700">Export Data</button>
        <button class="bg-green-600 text-white py-3 rounded-lg shadow hover:bg-green-700">Generate
            Report</button>
        <button class="bg-red-600 text-white py-3 rounded-lg shadow hover:bg-red-700">Delete Records</button>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-6">
        <img src="https://i.pravatar.cc/100" alt="Profile" class="w-20 h-20 rounded-full shadow">
        <div>
            <h3 class="text-xl font-bold text-purple-700">Sophia Ray</h3>
            <p class="text-gray-500">Administrator</p>
            <button class="mt-2 bg-purple-600 text-white px-4 py-2 rounded-lg shadow hover:bg-purple-700">Edit
                Profile</button>
        </div>
    </div>

    <footer class="bg-white p-4 mt-10 text-center text-sm text-gray-400 border-t">
        © 2025 AdminPanel. All rights reserved.
    </footer>

</main>
