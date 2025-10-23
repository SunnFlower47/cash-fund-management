<x-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-4 text-gray-900 dark:text-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent flex items-center space-x-3">
                                <img src="{{ asset('history.png') }}" alt="Audit Log" class="w-8 h-8 object-contain">
                                <span>Audit Log</span>
                            </h1>
                            <p class="text-gray-600 dark:text-slate-400 mt-1">Riwayat aktivitas sistem dan perubahan data</p>
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

            <!-- Filter Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-4">
                    <form method="GET" action="{{ route('audit-logs.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                            <div>
                                <label for="action" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Aksi:</label>
                                <select name="action" id="action" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                                    <option value="">Semua Aksi</option>
                                    @foreach($actions as $action)
                                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                            {{ $action }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="model_type" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Model:</label>
                                <select name="model_type" id="model_type" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                                    <option value="">Semua Model</option>
                                    @foreach($modelTypes as $type => $label)
                                        <option value="{{ $type }}" {{ request('model_type') === $type ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">User:</label>
                                <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                                    <option value="">Semua User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Dari Tanggal:</label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                            </div>

                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Sampai Tanggal:</label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-medium rounded-lg hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Audit Logs List -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-slate-700">
                <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-slate-200">
                        Daftar Audit Log - {{ $auditLogs->total() }} Total
                    </h2>
                </div>

                @if($auditLogs->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Model</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">IP Address</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Waktu</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach($auditLogs as $log)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-indigo-400 to-purple-400 flex items-center justify-center">
                                                    <span class="text-white font-medium text-xs">{{ substr($log->user->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $log->user->name }}</div>
                                                <div class="text-sm text-slate-500 dark:text-slate-400">{{ $log->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{
                                            $log->action === 'CREATE' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' :
                                            ($log->action === 'UPDATE' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300' :
                                            ($log->action === 'DELETE' ? 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300' :
                                            ($log->action === 'LOGIN' ? 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300' :
                                            ($log->action === 'LOGOUT' ? 'bg-gray-100 dark:bg-gray-900/50 text-gray-800 dark:text-gray-300' :
                                            'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300'))))
                                        }}">
                                            {{ $log->action_display }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                        {{ $log->model_display }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">
                                        {{ $log->description ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                                        {{ $log->ip_address }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <a href="{{ route('audit-logs.show', $log) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium hover:underline">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden">
                        @foreach($auditLogs as $log)
                        <div class="p-3 border-b border-gray-200 dark:border-slate-700 last:border-b-0">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-r from-indigo-400 to-purple-400 flex items-center justify-center">
                                        <span class="text-white font-medium text-xs">{{ substr($log->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $log->user->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $log->user->email }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{
                                        $log->action === 'CREATE' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' :
                                        ($log->action === 'UPDATE' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300' :
                                        ($log->action === 'DELETE' ? 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300' :
                                        ($log->action === 'LOGIN' ? 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300' :
                                        ($log->action === 'LOGOUT' ? 'bg-gray-100 dark:bg-gray-900/50 text-gray-800 dark:text-gray-300' :
                                        'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300'))))
                                    }}">
                                        {{ $log->action_display }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>
                                    <span class="text-slate-500 dark:text-slate-400">Model:</span>
                                    <span class="text-slate-700 dark:text-slate-300">{{ $log->model_display }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 dark:text-slate-400">IP:</span>
                                    <span class="text-slate-700 dark:text-slate-300">{{ $log->ip_address }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 dark:text-slate-400">Waktu:</span>
                                    <span class="text-slate-700 dark:text-slate-300">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('audit-logs.show', $log) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-xs font-medium hover:underline">
                                        Detail
                                    </a>
                                </div>
                            </div>

                            @if($log->description)
                            <div class="mt-2 text-xs text-slate-600 dark:text-slate-400">
                                {{ $log->description }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 px-4 py-3 border-t border-gray-200 dark:border-slate-700">
                        {{ $auditLogs->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="flex items-center justify-center mx-auto mb-6">
                            <img src="{{ asset('history.png') }}" alt="No Audit Logs" class="w-20 h-20 object-contain">
                        </div>
                        <h3 class="text-lg font-semibold text-slate-600 dark:text-slate-400 mb-2">Belum ada audit log</h3>
                        <p class="text-slate-500 dark:text-slate-400">Aktivitas sistem akan tercatat di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
