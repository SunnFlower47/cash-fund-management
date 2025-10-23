<x-app-layout>
    <div class="py-12"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-4 text-gray-900 dark:text-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-emerald-600 bg-clip-text text-transparent flex items-center space-x-3">
                                <img src="{{ asset('calendar.png') }}" alt="Calendar" class="w-8 h-8 object-contain">
                                <span>Tracking Pembayaran Kas Mingguan</span>
                            </h1>
                            <p class="text-gray-600 dark:text-slate-400 mt-1">Kelola pembayaran kas mingguan anggota</p>
                        </div>

                        @can('manage_weekly_payments')
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Generate Button -->
                            <button onclick="showGenerateModal()"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-medium rounded-lg hover:from-blue-600 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Generate Tagihan
                            </button>

                            <!-- Approve Payment Button -->
                            <button onclick="showApprovePaymentModal()"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Approve Pembayaran
                            </button>

                            <!-- Export Excel Button -->
                            {{-- <a href="{{ route('weekly-payments.export-excel', request()->query()) }}"
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-lg hover:from-purple-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Export Excel
                            </a> --}}

                        </div>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-4">
                    <form method="GET" action="{{ route('weekly-payments.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Tahun:</label>
                                <select name="year" id="year" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100" onchange="updateMonths()">
                                    <option value="">Semua Tahun</option>
                                    @foreach($years as $yearValue => $yearName)
                                        <option value="{{ $yearValue }}" {{ $selectedYear == $yearValue ? 'selected' : '' }}>
                                            {{ $yearName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="month" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Bulan:</label>
                                <select name="month" id="month" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                                    <option value="">Semua Bulan</option>
                                    @foreach($months as $monthValue => $monthName)
                                        <option value="{{ $monthValue }}" {{ $selectedMonth == $monthValue ? 'selected' : '' }}>
                                            {{ $monthName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="filter_week" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Minggu:</label>
                                <select name="week" id="filter_week" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                                    <option value="">Semua Minggu</option>
                                    <option value="1" {{ $selectedWeek == '1' ? 'selected' : '' }}>Minggu 1</option>
                                    <option value="2" {{ $selectedWeek == '2' ? 'selected' : '' }}>Minggu 2</option>
                                    <option value="3" {{ $selectedWeek == '3' ? 'selected' : '' }}>Minggu 3</option>
                                    <option value="4" {{ $selectedWeek == '4' ? 'selected' : '' }}>Minggu 4</option>
                                </select>
                            </div>

                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Anggota:</label>
                                <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                                    <option value="">Semua Anggota</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $selectedUser == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="w-full px-6 py-2 bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium rounded-lg hover:from-teal-600 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-slate-700">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Anggota</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-slate-200">{{ $weeklyPayments->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-slate-700">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Sudah Bayar</p>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $weeklyPayments->where('is_paid', true)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-slate-700">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-100 dark:bg-red-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Belum Bayar</p>
                                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $weeklyPayments->where('is_paid', false)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment List -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-slate-200">
                        Daftar Pembayaran - {{ $weeklyPayments->first()->week_period_display ?? 'Periode Terpilih' }}
                    </h2>
                </div>

                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Anggota</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Jumlah</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Tanggal Bayar</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Catatan</th>
                                @can('manage_weekly_payments')
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                            @forelse($weeklyPayments as $payment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-teal-400 to-emerald-400 flex items-center justify-center">
                                                <span class="text-white font-medium text-sm">{{ substr($payment->user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-slate-200">{{ $payment->user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-slate-400">{{ $payment->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-200">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($payment->is_paid)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            Belum Bayar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                    {{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                    {{ $payment->notes ?? '-' }}
                                </td>
                                @can('manage_weekly_payments')
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($payment->is_paid)
                                        <button onclick="markAsUnpaid({{ $payment->id }})"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 mr-3">
                                            Mark Unpaid
                                        </button>
                                    @else
                                        <button onclick="markAsPaid({{ $payment->id }})"
                                                class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">
                                            Mark Paid
                                        </button>
                                    @endif
                                </td>
                                @endcan
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-slate-200">Tidak ada data pembayaran</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Belum ada data pembayaran untuk periode ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden">
                    @forelse($weeklyPayments as $payment)
                    <div class="p-3 border-b border-gray-200 dark:border-slate-700 last:border-b-0">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-teal-400 to-emerald-400 flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">{{ substr($payment->user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-slate-200">{{ $payment->user->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-slate-400">{{ $payment->user->email }}</div>
                                </div>
                            </div>
                            @if($payment->is_paid)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Lunas
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Belum Bayar
                                </span>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-slate-400">Jumlah:</span>
                                <div class="font-medium text-gray-900 dark:text-slate-200">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-slate-400">Tanggal Bayar:</span>
                                <div class="font-medium text-gray-900 dark:text-slate-200">{{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : '-' }}</div>
                            </div>
                        </div>

                        @if($payment->notes)
                        <div class="mt-3">
                            <span class="text-gray-500 dark:text-slate-400 text-sm">Catatan:</span>
                            <div class="text-sm text-gray-900 dark:text-slate-200">{{ $payment->notes }}</div>
                        </div>
                        @endif

                        @can('manage_weekly_payments')
                        <div class="mt-3 flex gap-2">
                            @if($payment->is_paid)
                                <button onclick="markAsUnpaid({{ $payment->id }})"
                                        class="flex-1 px-3 py-1 text-sm bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-800/50">
                                    Mark Unpaid
                                </button>
                            @else
                                <button onclick="markAsPaid({{ $payment->id }})"
                                        class="flex-1 px-3 py-1 text-sm bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-800/50">
                                    Mark Paid
                                </button>
                            @endif
                        </div>
                        @endcan
                    </div>
                    @empty
                    <div class="p-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data pembayaran</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada data pembayaran untuk periode ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Generate Modal -->
    <div id="generateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-4 sm:top-20 mx-auto p-3 sm:p-4 border w-11/12 sm:w-96 max-w-md shadow-lg rounded-md bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-700">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-200">Generate Tagihan Mingguan</h3>
                    <button onclick="hideGenerateModal()" class="text-gray-400 dark:text-slate-400 hover:text-gray-600 dark:hover:text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('weekly-payments.generate') }}" method="POST">
                    @csrf
                        <div class="mb-4">
                            <label for="generate_year" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pilih Tahun:</label>
                            <select name="year" id="generate_year" required class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100" onchange="updateGenerateMonths()">
                                @for($i = 0; $i < 6; $i++)
                                    @php
                                        $year = now()->addYears($i)->format('Y');
                                    @endphp
                                    <option value="{{ $year }}" {{ $i == 0 ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="generate_month" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pilih Bulan:</label>
                            <select name="month" id="generate_month" required class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                                <option value="">Pilih Bulan</option>
                                @for($i = 0; $i < 12; $i++)
                                    @php
                                        $date = now()->addMonths($i);
                                        $monthValue = $date->format('Y-m');
                                        $monthName = $date->format('F Y');
                                    @endphp
                                    <option value="{{ $monthValue }}" {{ $i == 0 ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pilih Minggu:</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" id="generate_all_weeks" class="mr-2 text-teal-600 focus:ring-teal-500" onchange="toggleWeekSelection()">
                                    <span class="text-sm font-medium text-gray-700 dark:text-slate-300">Generate Semua Minggu (1-4)</span>
                                </label>
                                <select name="week" id="generate_week" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                                    <option value="">Pilih Minggu</option>
                                    <option value="1">Minggu 1</option>
                                    <option value="2">Minggu 2</option>
                                    <option value="3">Minggu 3</option>
                                    <option value="4">Minggu 4</option>
                                </select>
                            </div>
                        </div>

                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Jumlah Tagihan (Rp):</label>
                        <input type="number" name="amount" id="amount" value="10000" min="0" required class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="hideGenerateModal()" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 bg-gray-100 dark:bg-slate-600 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-500">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-emerald-500 rounded-lg hover:from-teal-600 hover:to-emerald-600">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Approve Payment Modal -->
    <div id="approvePaymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-4 sm:top-20 mx-auto p-3 sm:p-4 border w-11/12 sm:w-96 max-w-md shadow-lg rounded-md bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-700">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-200">Approve Pembayaran</h3>
                    <button onclick="hideApprovePaymentModal()" class="text-gray-400 dark:text-slate-400 hover:text-gray-600 dark:hover:text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('weekly-payments.approve') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="approve_user_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pilih Anggota:</label>
                        <select name="user_id" id="approve_user_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                            <option value="">Pilih Anggota</option>
                            @foreach(\App\Models\User::role('anggota')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="amount_paid" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Nominal Pembayaran (Rp):</label>
                        <input type="number" name="amount_paid" id="amount_paid" min="0" required class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100" placeholder="Contoh: 30000">
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Sistem akan otomatis hitung berapa minggu yang lunas (1 minggu = Rp 10.000)</p>
                    </div>

                    <div class="mb-6">
                        <label for="approve_notes" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Catatan (Opsional):</label>
                        <textarea name="notes" id="approve_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="hideApprovePaymentModal()" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 bg-gray-100 dark:bg-slate-600 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-500">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg hover:from-green-600 hover:to-emerald-600">
                            Approve Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Bulk Approve Modal -->
    <div id="bulkApproveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-4 sm:top-20 mx-auto p-3 sm:p-4 border w-11/12 sm:w-96 max-w-md shadow-lg rounded-md bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-700">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-200">Bulk Approve Pembayaran</h3>
                    <button onclick="hideBulkApproveModal()" class="text-gray-400 dark:text-slate-400 hover:text-gray-600 dark:hover:text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('weekly-payments.bulk-approve') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="bulk_week_period" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pilih Periode:</label>
                        <select name="week_period" id="bulk_week_period" required class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                            @foreach($periods as $period)
                                <option value="{{ $period }}">
                                    @php
                                        $parts = explode('-', $period);
                                        $year = $parts[0];
                                        $month = $parts[1];
                                        $week = str_replace('W', '', $parts[2]); // Remove 'W' prefix from week

                                        $monthNames = [
                                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                        ];
                                    @endphp
                                    Minggu {{ $week }} {{ $monthNames[$month] }} {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Pilih Anggota:</label>
                        <div class="max-h-40 overflow-y-auto border border-gray-300 dark:border-slate-600 rounded-lg p-3 bg-white dark:bg-slate-700">
                            @foreach(\App\Models\User::role('anggota')->get() as $user)
                                <label class="flex items-center mb-2">
                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="mr-2 rounded border-gray-300 dark:border-slate-600 text-green-600 focus:ring-green-500">
                                    <span class="text-sm text-gray-900 dark:text-slate-200">{{ $user->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="hideBulkApproveModal()" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 bg-gray-100 dark:bg-slate-600 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-500">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg hover:from-green-600 hover:to-emerald-600">
                            Approve Selected
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Mark as Paid Modal -->
    <div id="markPaidModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-4 sm:top-20 mx-auto p-3 sm:p-5 border w-11/12 sm:w-96 max-w-md shadow-lg rounded-md bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-700">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-200">Tandai sebagai Lunas</h3>
                    <button onclick="hideMarkPaidModal()" class="text-gray-400 dark:text-slate-400 hover:text-gray-600 dark:hover:text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="markPaidForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Catatan (Opsional):</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="hideMarkPaidModal()" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 bg-gray-100 dark:bg-slate-600 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-500">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg hover:from-green-600 hover:to-emerald-600">
                            Tandai Lunas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showGenerateModal() {
            document.getElementById('generateModal').classList.remove('hidden');
        }

        function hideGenerateModal() {
            document.getElementById('generateModal').classList.add('hidden');
        }

        function showApprovePaymentModal() {
            document.getElementById('approvePaymentModal').classList.remove('hidden');
        }

        function hideApprovePaymentModal() {
            document.getElementById('approvePaymentModal').classList.add('hidden');
        }


        function toggleWeekSelection() {
            const checkbox = document.getElementById('generate_all_weeks');
            const select = document.getElementById('generate_week');

            if (checkbox.checked) {
                select.disabled = true;
                select.value = '';
                select.classList.add('bg-gray-100');
            } else {
                select.disabled = false;
                select.classList.remove('bg-gray-100');
            }
        }

        function updateMonths() {
            const yearSelect = document.getElementById('year');
            const monthSelect = document.getElementById('month');
            const selectedYear = yearSelect.value;

            // Clear current options except first one
            monthSelect.innerHTML = '<option value="">Semua Bulan</option>';

            if (selectedYear) {
                // Add months for selected year
                const months = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];

                months.forEach((month, index) => {
                    const monthValue = selectedYear + '-' + String(index + 1).padStart(2, '0');
                    const option = document.createElement('option');
                    option.value = monthValue;
                    option.textContent = month + ' ' + selectedYear;
                    monthSelect.appendChild(option);
                });
            } else {
                // Add all available months
                const allMonths = {!! json_encode($months) !!};
                Object.entries(allMonths).forEach(([value, name]) => {
                    const option = document.createElement('option');
                    option.value = value;
                    option.textContent = name;
                    monthSelect.appendChild(option);
                });
            }
        }

        function updateGenerateMonths() {
            const yearSelect = document.getElementById('generate_year');
            const monthSelect = document.getElementById('generate_month');
            const selectedYear = yearSelect.value;

            // Clear current options except first one
            monthSelect.innerHTML = '<option value="">Pilih Bulan</option>';

            // Add months for selected year
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            months.forEach((month, index) => {
                const monthValue = selectedYear + '-' + String(index + 1).padStart(2, '0');
                const option = document.createElement('option');
                option.value = monthValue;
                option.textContent = month + ' ' + selectedYear;
                monthSelect.appendChild(option);
            });
        }

        function showBulkApproveModal() {
            document.getElementById('bulkApproveModal').classList.remove('hidden');
        }

        function hideBulkApproveModal() {
            document.getElementById('bulkApproveModal').classList.add('hidden');
        }

        function markAsPaid(paymentId) {
            document.getElementById('markPaidForm').action = `{{ url('/weekly-payments') }}/${paymentId}/mark-paid`;
            document.getElementById('markPaidModal').classList.remove('hidden');
        }

        function markAsUnpaid(paymentId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menandai pembayaran ini sebagai belum lunas?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tandai Belum Lunas',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang mengubah status pembayaran',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`{{ url('/weekly-payments') }}/${paymentId}/mark-unpaid`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message || 'Status pembayaran berhasil diubah!',
                                icon: 'success',
                                confirmButtonColor: '#10b981'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Terjadi kesalahan saat mengubah status pembayaran',
                                icon: 'error',
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengubah status pembayaran. Silakan refresh halaman dan coba lagi.',
                            icon: 'error',
                            confirmButtonColor: '#ef4444'
                        });
                    });
                }
            });
        }

        function hideMarkPaidModal() {
            document.getElementById('markPaidModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const generateModal = document.getElementById('generateModal');
            const approvePaymentModal = document.getElementById('approvePaymentModal');
            const bulkApproveModal = document.getElementById('bulkApproveModal');
            const markPaidModal = document.getElementById('markPaidModal');

            if (event.target === generateModal) {
                hideGenerateModal();
            }
            if (event.target === approvePaymentModal) {
                hideApprovePaymentModal();
            }
            if (event.target === bulkApproveModal) {
                hideBulkApproveModal();
            }
            if (event.target === markPaidModal) {
                hideMarkPaidModal();
            }
        }
    </script>
</x-app-layout>
