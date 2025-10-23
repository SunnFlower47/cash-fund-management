<x-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-4 text-gray-900 dark:text-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent flex items-center space-x-3">
                                <img src="{{ asset('seting.png') }}" alt="Settings" class="w-8 h-8 object-contain">
                                <span>Pengaturan Sistem</span>
                            </h1>
                            <p class="text-gray-600 dark:text-slate-400 mt-1">Kelola user dan role permission</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Actions -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">

                <div class="flex flex-wrap gap-2 sm:gap-3">
                    @can('manage_settings')
                    <a href="{{ route('settings.roles') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-400 to-pink-400 hover:from-purple-500 hover:to-pink-500 text-white font-semibold py-2 px-3 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105 text-xs sm:text-sm">
                        <img src="{{ asset('seting.png') }}" alt="Role Management" class="w-4 h-4 object-contain">
                        <span>Kelola Role</span>
                    </a>
                    <a href="{{ route('settings.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-semibold py-2 px-3 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105 text-xs sm:text-sm">
                        <img src="{{ asset('user.png') }}" alt="Add User" class="w-4 h-4 object-contain">
                        <span>Tambah User</span>
                    </a>
                    <a href="{{ route('backup.index') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-orange-400 to-red-400 hover:from-orange-500 hover:to-red-500 text-white font-semibold py-2 px-3 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105 text-xs sm:text-sm">
                        <img src="{{ asset('seting.png') }}" alt="Backup & Export" class="w-4 h-4 object-contain">
                        <span>Backup & Export</span>
                    </a>
                    <a href="{{ route('audit-logs.index') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-indigo-400 to-purple-400 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold py-2 px-3 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105 text-xs sm:text-sm">
                        <img src="{{ asset('history.png') }}" alt="Audit Log" class="w-4 h-4 object-contain">
                        <span>Audit Log</span>
                    </a>
                    @endcan
                </div>
            </div>

            <!-- Daftar User Section -->
            <div class="flex items-center space-x-3 mb-6">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('profile.png') }}" alt="Users" class="w-6 h-6 object-contain">
                </div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Daftar User</h3>
            </div>

            @if($users->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden md:block bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 overflow-hidden shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Role</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Tanggal Dibuat</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                                @foreach($users as $user)
                                <tr class="border-b border-slate-100 dark:border-slate-700 hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 dark:hover:from-slate-700 dark:hover:to-slate-600 transition-all duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex items-center justify-center">
                                                <img src="{{ asset('profile.png') }}" alt="User" class="w-6 h-6 object-contain">
                                            </div>
                                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        @php
                                            $userRole = $user->roles->first()?->name ?? 'anggota';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $userRole === 'bendahara' ? 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-700' : 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700' }}">
                                            {{ $userRole === 'bendahara' ? 'Bendahara' : 'Anggota' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <div class="flex space-x-2">
                                            @can('edit_users')
                                            <a href="{{ route('settings.edit', $user) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium hover:underline">Edit</a>
                                            @endcan
                                            @can('edit_users')
                                            <a href="{{ route('settings.reset-password', $user) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300 text-sm font-medium hover:underline">Reset Password</a>
                                            @endcan
                                            @can('delete_users')
                                            @if($user->id !== auth()->id())
                                            <a href="#" onclick="deleteUser('{{ $user->id }}', 'desktop')" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-medium hover:underline">Hapus</a>
                                            <form id="delete-user-desktop-{{ $user->id }}" method="POST" action="{{ route('settings.destroy', $user) }}" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-4">
                    @foreach($users as $user)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 p-3 shadow-sm hover:shadow-md transition-all duration-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center">
                                    <img src="{{ asset('profile.png') }}" alt="User" class="w-6 h-6 object-contain">
                                </div>
                                <div>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $user->name }}</span>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @php
                                    $userRole = $user->roles->first()?->name ?? 'anggota';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $userRole === 'bendahara' ? 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-700' : 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700' }}">
                                    {{ $userRole === 'bendahara' ? 'Bendahara' : 'Anggota' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @can('edit_users')
                            <a href="{{ route('settings.edit', $user) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium hover:underline">Edit</a>
                            @endcan
                            @can('edit_users')
                            <a href="{{ route('settings.reset-password', $user) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300 text-sm font-medium hover:underline">Reset Password</a>
                            @endcan
                            @can('delete_users')
                            @if($user->id !== auth()->id())
                            <a href="#" onclick="deleteUser('{{ $user->id }}', 'mobile')" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-medium hover:underline">Hapus</a>
                            <form id="delete-user-mobile-{{ $user->id }}" method="POST" action="{{ route('settings.destroy', $user) }}" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                            @endcan
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="flex items-center justify-center mx-auto mb-6">
                        <img src="{{ asset('profile.png') }}" alt="No Users" class="w-20 h-20 object-contain">
                    </div>
                    <h3 class="text-lg font-semibold text-slate-600 dark:text-slate-300 mb-2">Belum ada user</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6">Mulai dengan menambahkan user pertama</p>
                    <a href="{{ route('settings.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                        <img src="{{ asset('flash-sale.png') }}" alt="Add First User" class="w-5 h-5 object-contain">
                        <span>Tambah User Pertama</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- SweetAlert2 Delete Confirmation -->
    <script>
        function deleteUser(userId, type) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan user yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-user-' + type + '-' + userId).submit();
                }
            });
        }
    </script>
</x-app-layout>
