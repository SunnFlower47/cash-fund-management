<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center">
                <img src="{{ asset('seting.png') }}" alt="Role Management" class="w-10 h-10 object-contain">
            </div>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                    {{ __('Kelola Role & Permission') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Atur role dan permission untuk user</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Actions -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('profile.png') }}" alt="Roles" class="w-6 h-6 object-contain">
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Daftar Role</h3>
                </div>
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    <a href="{{ route('settings.index') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-2 px-3 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-xs sm:text-sm">
                        <img src="{{ asset('profile.png') }}" alt="Back to Users" class="w-4 h-4 object-contain">
                        <span>Kembali ke User</span>
                    </a>
                    <a href="{{ route('settings.create-role') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-semibold py-2 px-3 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105 text-xs sm:text-sm">
                        <img src="{{ asset('flash-sale.png') }}" alt="Add Role" class="w-4 h-4 object-contain">
                        <span>Tambah Role</span>
                    </a>
                </div>
            </div>

            @if($roles->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden md:block bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 overflow-hidden shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Role</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Permission</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Jumlah User</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                                @foreach($roles as $role)
                                <tr class="border-b border-slate-100 dark:border-slate-700 hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 dark:hover:from-slate-700 dark:hover:to-slate-600 transition-all duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <div class="flex items-center space-x-3 min-h-[28px]">
                                            <img src="{{ asset('profile.png') }}" alt="Role" class="w-6 h-6 object-contain flex-shrink-0" />
                                            <div class="leading-tight">
                                                <span class="font-semibold text-slate-800 dark:text-slate-200 block">{{ ucfirst($role->name) }}</span>
                                                @if($role->name === 'bendahara' || $role->name === 'anggota')
                                                <span class="text-xs text-slate-500 dark:text-slate-400">(Default)</span>
                                                @endif
                                            </div>
                                        </div>

                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($role->permissions as $permission)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700">
                                                {{ $permission->name }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                        {{ $role->users->count() }} user
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <div class="flex space-x-2">
                                            @can('edit_users')
                                            <a href="{{ route('settings.edit-role', $role) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium hover:underline">Edit</a>
                                            @endcan
                                            @can('delete_users')
                                            @if($role->name !== 'bendahara' && $role->name !== 'anggota')
                                            <a href="#" onclick="deleteRole('{{ $role->id }}', 'desktop')" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-medium hover:underline">Hapus</a>
                                            <form id="delete-role-desktop-{{ $role->id }}" method="POST" action="{{ route('settings.destroy-role', $role) }}" class="hidden">
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
                    @foreach($roles as $role)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 p-3 shadow-sm hover:shadow-md transition-all duration-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center">
                                    <img src="{{ asset('profile.png') }}" alt="Role" class="w-6 h-6 object-contain">
                                </div>
                                <div>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200">{{ ucfirst($role->name) }}</span>
                                    @if($role->name === 'bendahara' || $role->name === 'anggota')
                                    <p class="text-xs text-slate-500 dark:text-slate-400">(Default)</p>
                                    @endif
                                    <p class="text-xs text-slate-400 dark:text-slate-500">{{ $role->users->count() }} user</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="flex flex-wrap gap-1">
                                @foreach($role->permissions as $permission)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700">
                                    {{ $permission->name }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @can('edit_users')
                            <a href="{{ route('settings.edit-role', $role) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium hover:underline">Edit</a>
                            @endcan
                            @can('delete_users')
                            @if($role->name !== 'bendahara' && $role->name !== 'anggota')
                            <a href="#" onclick="deleteRole('{{ $role->id }}', 'mobile')" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-medium hover:underline">Hapus</a>
                            <form id="delete-role-mobile-{{ $role->id }}" method="POST" action="{{ route('settings.destroy-role', $role) }}" class="hidden">
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
                        <img src="{{ asset('profile.png') }}" alt="No Roles" class="w-20 h-20 object-contain">
                    </div>
                    <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada role</h3>
                    <p class="text-slate-500 mb-6">Mulai dengan membuat role pertama</p>
                    <a href="{{ route('settings.create-role') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                        <img src="{{ asset('flash-sale.png') }}" alt="Add First Role" class="w-5 h-5 object-contain">
                        <span>Tambah Role Pertama</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- SweetAlert2 Delete Confirmation -->
    <script>
        function deleteRole(roleId, type) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan role yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-role-' + type + '-' + roleId).submit();
                }
            });
        }
    </script>
</x-app-layout>
