<x-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-8 border border-gray-200 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent flex items-center space-x-3">
                                <img src="{{ asset('profile.png') }}" alt="Dashboard Anggota" class="w-8 h-8 object-contain">
                                <span>Dashboard Anggota</span>
                            </h1>
                            <p class="text-gray-600 dark:text-slate-400 mt-1">Kelola transaksi dan pembayaran</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cash Balance Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4 mb-6">
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-xl border border-green-200/60 dark:border-green-700/60 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="p-4 text-slate-900 dark:text-slate-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('wallet.png') }}" alt="Wallet" class="w-8 h-8 object-contain">
                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Saldo Kas</p>
                                <p class="text-lg font-bold text-slate-900 dark:text-slate-100">Rp {{ number_format($cashBalance->current_balance, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-xl border border-blue-200/60 dark:border-blue-700/60 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="p-4 text-slate-900 dark:text-slate-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('cryptocurrency.png') }}" alt="Income" class="w-8 h-8 object-contain">
                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Total Pemasukan</p>
                                <p class="text-lg font-bold text-slate-900 dark:text-slate-100">Rp {{ number_format($cashBalance->total_income, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-xl border border-rose-200/60 dark:border-rose-700/60 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="p-4 text-slate-900 dark:text-slate-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('calculator.png') }}" alt="Expense" class="w-8 h-8 object-contain">
                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Total Pengeluaran</p>
                                <p class="text-lg font-bold text-slate-900 dark:text-slate-100">Rp {{ number_format($cashBalance->total_expense, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-xl border border-amber-200/60 dark:border-amber-700/60 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="p-4 text-slate-900 dark:text-slate-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('book.png') }}" alt="Pending" class="w-8 h-8 object-contain">
                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Status Pembayaran</p>
                                <p class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $userPaymentProofs->where('status', 'pending')->count() }} Pending</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-4 mb-6">
                <a href="{{ route('payment-proofs.create') }}" class="bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-bold py-3 px-4 rounded-xl text-center transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105">
                    <img src="{{ asset('flash-sale.png') }}" alt="Upload Payment Proof" class="w-6 h-6 object-contain">
                    <span class="text-base font-semibold">Upload Bukti Pembayaran</span>
                </a>

                <a href="{{ route('payment-proofs.index') }}" class="bg-gradient-to-r from-purple-400 to-pink-400 hover:from-purple-500 hover:to-pink-500 text-white font-bold py-3 px-4 rounded-xl text-center transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105">
                    <img src="{{ asset('book.png') }}" alt="View Payment Status" class="w-5 h-5 object-contain">
                    <span class="text-sm font-semibold">Lihat Status Pembayaran</span>
                </a>

                @can('view_weekly_payments')
                <a href="{{ route('weekly-payments.index') }}" class="bg-gradient-to-r from-teal-400 to-emerald-400 hover:from-teal-500 hover:to-emerald-500 text-white font-bold py-3 px-4 rounded-xl text-center transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105">
                    <img src="{{ asset('calendar.png') }}" alt="Kas Mingguan" class="w-5 h-5 object-contain">
                    <span class="text-sm font-semibold">Lihat Kas Mingguan</span>
                </a>
                @else
                <div class="bg-gray-400 text-white font-bold py-3 px-4 rounded-xl text-center">
                    <span class="text-sm font-semibold">No Permission</span>
                </div>
                @endcan
            </div>

            <!-- My Transactions -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-3 lg:p-4 text-gray-900 dark:text-slate-100">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('book-history.png') }}" alt="Log Kas" class="w-8 h-8 object-contain">
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-slate-200">Log Kas Terbaru</h3>
                    </div>

                    @if($userTransactions->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                <thead class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Anggota</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Jenis</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                                    @foreach($userTransactions as $transaction)
                                    <tr class="hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 dark:hover:from-slate-700 dark:hover:to-slate-600 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                                            <div class="flex items-center space-x-3">
                                                @if($transaction->type === 'expense')
                                                <div class="flex items-center justify-center">
                                                    <img src="{{ asset('calculator.png') }}" alt="Expense" class="w-10 h-10 object-contain">
                                                </div>
                                                <span class="font-semibold text-slate-800 dark:text-slate-200">Pengeluaran</span>
                                                @else
                                                <div class="flex items-center justify-center">
                                                    <img src="{{ asset('flash-sale.png') }}" alt="Income" class="w-10 h-10 object-contain">
                                                </div>
                                                <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $transaction->user->name ?? 'Unknown' }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->type === 'income' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700' }}">
                                                {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : ($transaction->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700') }}">
                                                {{ $transaction->status === 'approved' ? 'Disetujui' : ($transaction->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="md:hidden space-y-4">
                            @foreach($userTransactions as $transaction)
                            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 p-3 shadow-sm hover:shadow-md transition-all duration-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        @if($transaction->type === 'expense')
                                        <div class="flex items-center justify-center">
                                            <img src="{{ asset('calculator.png') }}" alt="Expense" class="w-8 h-8 object-contain">
                                        </div>
                                        <div>
                                            <span class="font-semibold text-slate-800 dark:text-slate-200">Pengeluaran</span>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        @else
                                        <div class="flex items-center justify-center">
                                            <img src="{{ asset('flash-sale.png') }}" alt="Income" class="w-8 h-8 object-contain">
                                        </div>
                                        <div>
                                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $transaction->user->name ?? 'Unknown' }}</span>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->type === 'income' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300' }}">
                                        {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->status === 'approved' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' : ($transaction->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300' : 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300') }}">
                                        {{ $transaction->status === 'approved' ? 'Disetujui' : ($transaction->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-slate-400">Belum ada transaksi.</p>
                    @endif
                </div>
            </div>

            <!-- Weekly Payment Status -->
            @can('view_weekly_payments')
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-3 lg:p-4 text-gray-900 dark:text-slate-100">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('calendar.png') }}" alt="Kas Mingguan" class="w-8 h-8 object-contain">
                        </div>
                        <div class="text-lg font-medium text-gray-900 dark:text-slate-200">Status Pembayaran Kas Mingguan</div>
                    </div>

                    @if(isset($weeklyPayments) && $weeklyPayments->count() > 0)

                        <!-- Current Month Summary -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-slate-300 mb-3">Ringkasan Bulan Ini</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-2">
                                            <p class="text-sm font-medium text-green-800 dark:text-green-300">Sudah Bayar</p>
                                            <p class="text-lg font-bold text-green-900 dark:text-green-200">{{ $weeklyPayments->where('is_paid', true)->count() }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-2">
                                            <p class="text-sm font-medium text-red-800 dark:text-red-300">Belum Bayar</p>
                                            <p class="text-lg font-bold text-red-900 dark:text-red-200">{{ $weeklyPayments->where('is_paid', false)->count() }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-2">
                                            <p class="text-sm font-medium text-blue-800 dark:text-blue-300">Total Tagihan</p>
                                            <p class="text-lg font-bold text-blue-900 dark:text-blue-200">Rp {{ number_format($weeklyPayments->sum('amount'), 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Weekly Payment Details -->
                        <div class="space-y-3">
                            @foreach($weeklyPayments->groupBy('week_period') as $weekPeriod => $payments)
                                @php
                                    $parts = explode('-', $weekPeriod);
                                    $year = $parts[0];
                                    $month = $parts[1];
                                    $week = str_replace('W', '', $parts[2]);

                                    $monthNames = [
                                        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                    ];
                                @endphp

                                <div class="bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg p-3">
                                    <div class="flex items-center justify-between mb-3">
                                        <h5 class="font-medium text-gray-900 dark:text-slate-200">Minggu {{ $week }} {{ $monthNames[$month] }} {{ $year }}</h5>
                                        @php
                                            $userPayment = $payments->where('user_id', auth()->id())->first();
                                        @endphp
                                        @if($userPayment)
                                            @if($userPayment->is_paid)
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
                                        @endif
                                    </div>

                                    @if($userPayment)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-500 dark:text-slate-400">Jumlah Tagihan:</span>
                                                <div class="font-medium text-gray-900 dark:text-slate-200">Rp {{ number_format($userPayment->amount, 0, ',', '.') }}</div>
                                            </div>
                                            <div>
                                                <span class="text-gray-500 dark:text-slate-400">Tanggal Bayar:</span>
                                                <div class="font-medium text-gray-900 dark:text-slate-200">
                                                    {{ $userPayment->paid_at ? $userPayment->paid_at->format('d/m/Y H:i') : '-' }}
                                                </div>
                                            </div>
                                        </div>

                                        @if($userPayment->notes)
                                            <div class="mt-3">
                                                <span class="text-gray-500 dark:text-slate-400 text-sm">Catatan:</span>
                                                <div class="text-sm text-gray-700 dark:text-slate-300">{{ $userPayment->notes }}</div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('weekly-payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500 to-emerald-500 text-white text-sm font-medium rounded-lg hover:from-teal-600 hover:to-emerald-600 transition-all duration-200">
                                <img src="{{ asset('calendar.png') }}" alt="Kas Mingguan" class="w-4 h-4 mr-2 object-contain">
                                Lihat Detail Lengkap
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 100-8 4 4 0 000 8z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-slate-200">Belum ada data pembayaran mingguan</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Data pembayaran kas mingguan akan muncul setelah bendahara membuat tagihan.</p>
                        </div>
                    @endif
                </div>
            </div>
            @endcan

                <!-- My Payment Proofs -->
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-3 lg:p-4 text-gray-900 dark:text-slate-100">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('receipt.png') }}" alt="Bukti Pembayaran" class="w-8 h-8 object-contain">
                        </div>
                        <div class="text-lg font-medium text-gray-900 dark:text-slate-200">Bukti Pembayaran Uang Kas</div>
                    </div>

                    @if($userPaymentProofs->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                <thead class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">File</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Ukuran</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                                    @foreach($userPaymentProofs as $proof)
                                    <tr class="hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 dark:hover:from-slate-700 dark:hover:to-slate-600 transition-all duration-200">
                                        <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center">
                                                    <img src="{{ asset('receipt.png') }}" alt="File" class="w-8 h-8 object-contain">
                                                </div>
                                                <a href="{{ $proof->file_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium hover:underline truncate max-w-xs">
                                                    {{ Str::limit($proof->file_name, 30, '...') }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                            {{ $proof->formatted_file_size }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $proof->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : ($proof->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700') }}">
                                                {{ $proof->status === 'approved' ? 'Disetujui' : ($proof->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                            {{ $proof->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                                            <a href="{{ route('payment-proofs.show', $proof) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium hover:underline">Lihat</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="sm:hidden space-y-4">
                            @foreach($userPaymentProofs as $proof)
                            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 p-3 shadow-sm hover:shadow-md transition-all duration-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center">
                                            <img src="{{ asset('receipt.png') }}" alt="File" class="w-8 h-8 object-contain">
                                        </div>
                                        <div>
                                            <a href="{{ $proof->file_url }}" target="_blank" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                                                {{ Str::limit($proof->file_name, 20, '...') }}
                                            </a>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $proof->created_at->format('d/m/Y H:i') }}</p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500">by {{ $proof->user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ $proof->formatted_file_size }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $proof->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : ($proof->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700') }}">
                                        {{ $proof->status === 'approved' ? 'Disetujui' : ($proof->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('payment-proofs.show', $proof) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium hover:underline">Lihat</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada bukti pembayaran uang kas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
