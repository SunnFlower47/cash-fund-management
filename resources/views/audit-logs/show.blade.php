<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center">
                <img src="{{ asset('history.png') }}" alt="Audit Log Detail" class="w-10 h-10 object-contain">
            </div>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                    {{ __('Detail Audit Log') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Detail lengkap aktivitas sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                <div class="p-4 text-slate-900 dark:text-slate-100">
                    <!-- Header Info -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-400 to-purple-400 flex items-center justify-center">
                                <span class="text-white font-medium text-sm">{{ substr($auditLog->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $auditLog->user->name }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $auditLog->user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{
                                $auditLog->action === 'CREATE' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' :
                                ($auditLog->action === 'UPDATE' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300' :
                                ($auditLog->action === 'DELETE' ? 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300' :
                                ($auditLog->action === 'LOGIN' ? 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300' :
                                ($auditLog->action === 'LOGOUT' ? 'bg-gray-100 dark:bg-gray-900/50 text-gray-800 dark:text-gray-300' :
                                'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300'))))
                            }}">
                                {{ $auditLog->action_display }}
                            </span>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Informasi Dasar</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500 dark:text-slate-400">Aksi:</span>
                                    <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $auditLog->action_display }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500 dark:text-slate-400">Model:</span>
                                    <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $auditLog->model_display }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500 dark:text-slate-400">Waktu:</span>
                                    <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $auditLog->created_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Informasi Teknis</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500 dark:text-slate-400">IP Address:</span>
                                    <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $auditLog->ip_address }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500 dark:text-slate-400">User Agent:</span>
                                    <span class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate max-w-xs">{{ $auditLog->user_agent }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($auditLog->description)
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi</h4>
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                            <p class="text-sm text-slate-900 dark:text-slate-100">{{ $auditLog->description }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Old Values -->
                    @if($auditLog->old_values)
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nilai Lama</h4>
                        <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border border-red-200 dark:border-red-700">
                            <pre class="text-sm text-slate-900 dark:text-slate-100 whitespace-pre-wrap">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                    @endif

                    <!-- New Values -->
                    @if($auditLog->new_values)
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nilai Baru</h4>
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-700">
                            <pre class="text-sm text-slate-900 dark:text-slate-100 whitespace-pre-wrap">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('audit-logs.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                            Kembali ke Audit Log
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
