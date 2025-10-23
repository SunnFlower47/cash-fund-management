<x-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-8 border border-gray-200 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent flex items-center space-x-3">
                                <img src="{{ asset('profile.png') }}" alt="Dashboard Bendahara" class="w-8 h-8 object-contain">
                                <span>Dashboard Bendahara</span>
                            </h1>
                            <p class="text-gray-600 dark:text-slate-400 mt-1">Kelola keuangan dan Log Kas</p>
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
                                <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Pending</p>
                                <p class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $pendingTransactions + $pendingProofs }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4 mb-6">
                <a href="{{ route('transactions.create') }}" class="bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-bold py-3 px-4 rounded-xl text-center transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105">
                    <img src="{{ asset('calculator.png') }}" alt="Add Transaction" class="w-6 h-6 object-contain">
                    <span class="text-base font-semibold">Tambah Log Kas</span>
                </a>

                <a href="{{ route('payment-proofs.index') }}" class="bg-gradient-to-r from-purple-400 to-pink-400 hover:from-purple-500 hover:to-pink-500 text-white font-bold py-3 px-4 rounded-xl text-center transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105">
                    <img src="{{ asset('book.png') }}" alt="Payment Proof" class="w-5 h-5 object-contain">
                    <span class="text-sm font-semibold">Review Bukti Pembayaran</span>
                </a>

                <a href="{{ route('transactions.index') }}" class="bg-gradient-to-r from-purple-400 to-indigo-400 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-3 px-4 rounded-xl text-center transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105">
                    <img src="{{ asset('worldwide-shipping.png') }}" alt="View Transactions" class="w-5 h-5 object-contain">
                    <span class="text-sm font-semibold">Lihat Semua Log Kas</span>
                </a>

                @can('manage_weekly_payments')
                <a href="{{ route('weekly-payments.index') }}" class="bg-gradient-to-r from-teal-400 to-emerald-400 hover:from-teal-500 hover:to-emerald-500 text-white font-bold py-3 px-4 rounded-xl text-center transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105">
                    <img src="{{ asset('calendar.png') }}" alt="Kas Mingguan" class="w-5 h-5 object-contain">
                    <span class="text-sm font-semibold">Kas Mingguan</span>
                </a>
                @endcan
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-3 lg:p-4 text-gray-900 dark:text-slate-100">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('book-history.png') }}" alt="Log Kas" class="w-8 h-8 object-contain">
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100">Log Kas Terbaru</h3>
                    </div>

                    @if($recentTransactions->count() > 0)
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
                                    @foreach($recentTransactions as $transaction)
                                    <tr class="hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 dark:hover:from-slate-700 dark:hover:to-slate-600 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->type === 'income' ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-700' : 'bg-rose-100 dark:bg-rose-900 text-rose-800 dark:text-rose-200 border border-rose-200 dark:border-rose-700' }}">
                                                {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-700' : ($transaction->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900 text-rose-800 dark:text-rose-200 border border-rose-200 dark:border-rose-700') }}">
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
                            @foreach($recentTransactions as $transaction)
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
                                        <p class="text-lg font-bold {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->type === 'income' ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-700' : 'bg-rose-100 dark:bg-rose-900 text-rose-800 dark:text-rose-200 border border-rose-200 dark:border-rose-700' }}">
                                        {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-700' : ($transaction->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900 text-rose-800 dark:text-rose-200 border border-rose-200 dark:border-rose-700') }}">
                                        {{ $transaction->status === 'approved' ? 'Disetujui' : ($transaction->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium">Belum ada Log Kas</p>
                            <p class="text-sm text-slate-400 mt-1">Log Kas akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>


        <!-- Bukti Pembayaran Section -->
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
            <div class="p-3 lg:p-4 text-gray-900 dark:text-slate-100">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('receipt.png') }}" alt="Bukti Pembayaran" class="w-8 h-8 object-contain">
                    </div>
                    <div class="text-lg font-medium text-gray-900 dark:text-slate-100">Bukti Pembayaran Uang Kas</div>
                </div>

                @if($allPaymentProofs->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">File</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Ukuran</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                                @foreach($allPaymentProofs as $proof)
                                <tr class="hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 dark:hover:from-slate-700 dark:hover:to-slate-600 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex items-center justify-center">
                                                <img src="{{ asset('profile.png') }}" alt="Nama" class="w-8 h-8 object-contain">
                                            </div>
                                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ explode(' - ', $proof->transactions->first()->description ?? '')[0] ?? $proof->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $proof->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-700' : ($proof->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900 text-rose-800 dark:text-rose-200 border border-rose-200 dark:border-rose-700') }}">
                                            {{ $proof->status === 'approved' ? 'Disetujui' : ($proof->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                        {{ $proof->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                        <a href="{{ route('payment-proofs.show', $proof) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium hover:underline">Lihat</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="sm:hidden space-y-4">
                        @foreach($allPaymentProofs as $proof)
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
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <img src="{{ asset('receipt.png') }}" alt="No Payment Proofs" class="w-8 h-8 object-contain">
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">Belum ada bukti pembayaran</p>
                        <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Bukti pembayaran akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
