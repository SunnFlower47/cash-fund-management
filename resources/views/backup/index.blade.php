<x-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-8 border border-gray-200 dark:border-slate-700">
                <div class="p-4 text-gray-900 dark:text-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent flex items-center space-x-3">
                                <img src="{{ asset('seting.png') }}" alt="Backup & Export" class="w-8 h-8 object-contain">
                                <span>Backup & Export</span>
                            </h1>
                            <p class="text-gray-600 dark:text-slate-400 mt-1">Kelola backup database dan export data</p>
                        </div>
                        <div class="flex flex-wrap gap-2 sm:gap-3">
                            <a href="{{ route('settings.index') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-2 px-3 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-xs sm:text-sm">
                                <img src="{{ asset('profile.png') }}" alt="Back to Settings" class="w-4 h-4 object-contain">
                                <span>Kembali ke Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Database Backup Section -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 overflow-hidden shadow-lg mb-8">
                <div class="p-4">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('seting.png') }}" alt="Database Backup" class="w-8 h-8 object-contain">
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Database Backup</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200/60 dark:border-blue-700/60">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('seting.png') }}" alt="Create Backup" class="w-6 h-6 object-contain">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200">Buat Backup</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-300">Backup database saat ini</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('backup.create') }}" id="backup-form">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg" onclick="showBackupLoading()">
                                    Buat Backup
                                </button>
                            </form>
                        </div>

                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 border border-green-200/60 dark:border-green-700/60">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('seting.png') }}" alt="Download Backup" class="w-6 h-6 object-contain">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200">Download Backup</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-300">Download file backup terbaru</p>
                                </div>
                            </div>
                            <a href="{{ route('backup.download', 'latest') }}" class="block w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center">
                                Download Backup Terbaru
                            </a>
                            <div class="mt-3 text-xs text-slate-500 dark:text-slate-400 text-center">
                                File backup akan otomatis ditemukan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Files List -->
            @if(isset($backupFiles) && count($backupFiles) > 0)
            <div class="mt-8">
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 overflow-hidden shadow-lg">
                    <div class="p-4 lg:p-6 text-gray-900 dark:text-slate-100">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('seting.png') }}" alt="Backup Files" class="w-8 h-8 object-contain">
                            </div>
                            <div class="text-lg font-medium text-gray-900 dark:text-slate-200">Daftar File Backup</div>
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                <thead class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Nama File</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Ukuran</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                                    @foreach($backupFiles as $backup)
                                    <tr class="hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 dark:hover:from-slate-700 dark:hover:to-slate-600 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center">
                                                    <img src="{{ asset('seting.png') }}" alt="Backup" class="w-6 h-6 object-contain">
                                                </div>
                                                <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $backup['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                            {{ $backup['size_formatted'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                            {{ $backup['date_formatted'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                            <a href="{{ route('backup.download', $backup['name']) }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 text-sm font-medium hover:underline">Download</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="sm:hidden space-y-4">
                            @foreach($backupFiles as $backup)
                            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 p-4 shadow-sm hover:shadow-md transition-all duration-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center">
                                            <img src="{{ asset('seting.png') }}" alt="Backup" class="w-6 h-6 object-contain">
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800 dark:text-slate-200">{{ $backup['name'] }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $backup['date_formatted'] }}</p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ $backup['size_formatted'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('backup.download', $backup['name']) }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 text-sm font-medium hover:underline">Download</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Export Data Section -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm mt-8 rounded-2xl border border-slate-200/60 dark:border-slate-700/60 overflow-hidden shadow-lg">
                <div class="p-4">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('seting.png') }}" alt="Export Data" class="w-8 h-8 object-contain">
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Export Data ke Excel</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Export Transactions -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6 border border-purple-200/60 dark:border-purple-700/60">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('book-history.png') }}" alt="Transactions" class="w-6 h-6 object-contain">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200">Log Kas</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-300">Export semua Log Kas</p>
                                </div>
                            </div>
                            <a href="{{ route('backup.export.transactions') }}" onclick="showExportLoading('Log Kas')" class="block w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center">
                                Export Log Kas
                            </a>
                        </div>

                        <!-- Export Payment Proofs -->
                        <div class="bg-gradient-to-br from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 rounded-xl p-6 border border-orange-200/60 dark:border-orange-700/60">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('receipt.png') }}" alt="Payment Proofs" class="w-6 h-6 object-contain">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200">Bukti Pembayaran</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-300">Export bukti pembayaran</p>
                                </div>
                            </div>
                            <a href="{{ route('backup.export.payment-proofs') }}" onclick="showExportLoading('Bukti Pembayaran')" class="block w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center">
                                Export Bukti Pembayaran
                            </a>
                        </div>

                        <!-- Export Users -->
                        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20 rounded-xl p-6 border border-teal-200/60 dark:border-teal-700/60">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('user.png') }}" alt="Users" class="w-6 h-6 object-contain">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200">Users</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-300">Export data user</p>
                                </div>
                            </div>
                            <a href="{{ route('backup.export.users') }}" class="block w-full bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center">
                                Export Users
                            </a>
                        </div>

                        <!-- Export Weekly Payments -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 border border-green-200/60 dark:border-green-700/60">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('calendar.png') }}" alt="Weekly Payments" class="w-6 h-6 object-contain">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-800 dark:text-slate-200">Kas Mingguan</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-300">Export data kas mingguan</p>
                                </div>
                            </div>
                            <a href="{{ route('backup.export.weekly-payments') }}" onclick="showExportLoading('Kas Mingguan')" class="block w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center">
                                Export Kas Mingguan
                            </a>
                        </div>
                    </div>

                    <!-- Export All Data -->
                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                        <div class="bg-gradient-to-br from-slate-50 to-gray-50 dark:from-slate-900/20 dark:to-gray-900/20 rounded-xl p-6 border border-slate-200/60 dark:border-slate-700/60">
                          <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-slate-500 to-gray-500 rounded-lg flex items-center justify-center">
                              <img
                                src="{{ asset('seting.png') }}"
                                alt="All Data"
                                class="w-6 h-6 object-contain"
                              >
                            </div>
                            <div>
                              <h4 class="font-semibold text-slate-800 dark:text-slate-200">Export Semua Data</h4>
                              <p class="text-sm text-slate-600 dark:text-slate-300">Export semua data dalam satu file Excel</p>
                            </div>
                          </div>
                          <a
                            href="{{ route('backup.export.all') }}"
                            class="block w-full bg-gradient-to-r from-slate-500 to-gray-500 hover:from-slate-600 hover:to-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center"
                          >
                            Export Semua Data
                          </a>
                        </div>
                      </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Backup Loading Animation -->
    <script>
        function showBackupLoading() {
            Swal.fire({
                title: 'Membuat Backup...',
                text: 'Mohon tunggu, sedang memproses backup database',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function showExportLoading(type) {
            Swal.fire({
                title: 'Export ' + type + '...',
                text: 'Mohon tunggu, sedang memproses export data',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        // Auto-hide loading when page loads (after redirect)
        @if(session('success') || session('error'))
            Swal.close();
        @endif
    </script>
</x-app-layout>
