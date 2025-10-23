<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4 sm:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl shadow-lg">
                            <img src="{{ asset('searching.png') }}" alt="Detail Transaksi" class="w-8 h-8 sm:w-10 sm:h-10 object-contain">
                        </div>
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                Detail Transaksi
                            </h1>
                            <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Lihat detail transaksi #{{ $transaction->id }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                        <a href="{{ route('transactions.index') }}" class="bg-gradient-to-r from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl text-center">
                            Kembali
                        </a>
                        @can('edit_transactions')
                        @if($transaction->user_id === auth()->id() || auth()->user()->isBendahara())
                        <a href="{{ route('transactions.edit', $transaction) }}" class="bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl text-center">
                            Edit
                        </a>
                        @endif
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Content Container -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg overflow-hidden">
                <div class="p-4 sm:p-6 text-slate-900 dark:text-slate-100 dark:text-slate-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 dark:text-slate-100 mb-4">Informasi Transaksi</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 dark:text-slate-400">ID Transaksi</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100 dark:text-slate-100 font-semibold">#{{ $transaction->id }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Jenis</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->type === 'income' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700' }}">
                                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Jumlah</dt>
                                    <dd class="mt-1 text-lg font-bold {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : ($transaction->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700') }}">
                                            {{ $transaction->status === 'approved' ? 'Disetujui' : ($transaction->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Deskripsi</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $transaction->description }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Sumber</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $transaction->source ?? '-' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Tanggal Dibuat</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</dd>
                                </div>

                                @if($transaction->approved_at)
                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Tanggal Disetujui</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $transaction->approved_at->format('d/m/Y H:i:s') }}</dd>
                                </div>
                                @endif

                                @if($transaction->approver)
                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Disetujui Oleh</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $transaction->approver->name }}</dd>
                                </div>
                                @endif

                                @if($transaction->notes)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Catatan</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $transaction->notes }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        @if($transaction->paymentProof)
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="flex items-center justify-center">
                                    <img src="{{ asset('receipt.png') }}" alt="Bukti Pembayaran" class="w-8 h-8 object-contain">
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Bukti Pembayaran</h3>
                            </div>
                            <div class="bg-slate-50/50 dark:bg-slate-700/50 border border-slate-200/60 dark:border-slate-600/60 rounded-2xl p-6">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/50 dark:to-indigo-900/50 rounded-xl flex items-center justify-center">
                                            <img src="{{ asset('receipt.png') }}" alt="File" class="w-6 h-6 object-contain">
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">
                                            {{ $transaction->paymentProof->file_name }}
                                        </p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $transaction->paymentProof->formatted_file_size }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="{{ $transaction->paymentProof->file_url }}" target="_blank" class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-400 to-indigo-400 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                                            <img src="{{ asset('receipt.png') }}" alt="View File" class="w-4 h-4 object-contain">
                                            <span>Lihat File</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
