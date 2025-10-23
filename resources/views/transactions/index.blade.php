<x-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-8 border border-gray-200 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center space-x-3">
                                <img src="{{ asset('searching.png') }}" alt="Search" class="w-8 h-8 object-contain">
                                <span>Log Kas</span>
                            </h1>
                            <p class="text-gray-600 dark:text-slate-400 mt-1">Riwayat transaksi pemasukan dan pengeluaran kas</p>
                        </div>
                        @can('create_transactions')
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white font-medium rounded-lg hover:from-green-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                                <img src="{{ asset('calculator.png') }}" alt="Add Transaction" class="w-4 h-4 mr-2 object-contain">
                                Tambah Transaksi
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                <div class="p-4 text-slate-900 dark:text-slate-100">
                    <!-- Filter Section -->
                    <div class="mb-6 bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600 rounded-2xl p-4 border border-slate-200/60 dark:border-slate-600/60 shadow-sm">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('filter.png') }}" alt="Filter" class="w-8 h-8 object-contain">
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Filter Transaksi</h3>
                        </div>
                        <form method="GET" action="{{ route('transactions.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:space-x-4">
                            <div class="flex-1">
                                <label for="type_filter" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Jenis Transaksi</label>
                                <select id="type_filter" name="type" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 shadow-sm transition-all duration-200">
                                    <option value="">Semua Transaksi</option>
                                    <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                                    <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <label for="status_filter" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Status</label>
                                <select id="status_filter" name="status" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 shadow-sm transition-all duration-200">
                                    <option value="">Semua Status</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <label for="user_name_filter" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Nama Anggota</label>
                                <input type="text" id="user_name_filter" name="user_name" value="{{ request('user_name') }}" placeholder="Cari nama anggota..." class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 shadow-sm transition-all duration-200">
                            </div>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-400 to-purple-400 text-white text-sm font-bold rounded-xl hover:from-indigo-500 hover:to-purple-500 transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl">
                                    <img src="{{ asset('searching.png') }}" alt="Apply Filter" class="w-5 h-5 object-contain">
                                    <span>Terapkan Filter</span>
                                </button>
                                @if(request()->hasAny(['type', 'status', 'user_name']))
                                <a href="{{ route('transactions.index') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-sm font-bold rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-all duration-200 flex items-center justify-center space-x-2">
                                    <img src="{{ asset('cryptocurrency.png') }}" alt="Reset" class="w-5 h-5 object-contain">
                                    <span>Reset</span>
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    @if($transactions->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden md:block bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 overflow-hidden shadow-lg">
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600">
                                        <tr>
                                            @if(auth()->user()->isBendahara())
                                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">User</th>
                                            @endif
                                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Jenis</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Nama</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Jumlah</th>
                                            <th class="hidden sm:table-cell px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Deskripsi</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                                        @foreach($transactions as $transaction)
                                        <tr class="border-b border-slate-100 dark:border-slate-700 hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 dark:hover:from-slate-700 dark:hover:to-slate-600 transition-all duration-200">
                                            {{-- Kolom nama anggota (hanya untuk bendahara) --}}
                                            @if(auth()->user()->isBendahara())
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900 dark:text-slate-100">
                                                {{ $transaction->user->name }}
                                            </td>
                                            @endif

                                            {{-- Jenis transaksi (Pemasukan / Pengeluaran) --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                    {{ $transaction->type === 'income'
                                                        ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-700'
                                                        : 'bg-rose-100 dark:bg-rose-900 text-rose-800 dark:text-rose-200 border border-rose-200 dark:border-rose-700' }}">
                                                    {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                                </span>
                                            </td>

                                            {{-- Nama transaksi + Icon --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                                <div class="flex items-center space-x-3 min-h-[44px]">
                                                    <img
                                                        src="{{ asset($transaction->type === 'expense' ? 'calculator.png' : 'cryptocurrency.png') }}"
                                                        alt="{{ $transaction->type === 'expense' ? 'Expense' : 'Income' }}"
                                                        class="w-10 h-10 object-contain flex-shrink-0"
                                                    />
                                                    <span class="font-semibold text-slate-800 dark:text-slate-200 leading-tight">
                                                        {{ $transaction->type === 'expense'
                                                            ? 'Pengeluaran'
                                                            : ($transaction->user->name ?? 'Unknown') }}
                                                    </span>
                                                </div>
                                            </td>

                                            {{-- Nominal --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold
                                                {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </td>

                                            {{-- Deskripsi tambahan --}}
                                            <td class="hidden sm:table-cell px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                                <div class="max-w-xs truncate">{{ $transaction->description }}</div>
                                            </td>

                                            {{-- Status transaksi --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                    {{ $transaction->status === 'approved'
                                                        ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-700'
                                                        : ($transaction->status === 'pending'
                                                            ? 'bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-700'
                                                            : 'bg-rose-100 dark:bg-rose-900 text-rose-800 dark:text-rose-200 border border-rose-200 dark:border-rose-700') }}">
                                                    {{ $transaction->status === 'approved'
                                                        ? 'Disetujui'
                                                        : ($transaction->status === 'pending'
                                                            ? 'Pending'
                                                            : 'Ditolak') }}
                                                </span>
                                            </td>

                                            {{-- Tanggal --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                                            </td>

                                            {{-- Aksi --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('transactions.show', $transaction) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium hover:underline">
                                                        Lihat
                                                    </a>

                                                    @can('edit_transactions')
                                                        @if($transaction->user_id === auth()->id() || auth()->user()->isBendahara())
                                                            <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline">
                                                                Edit
                                                            </a>
                                                        @endif
                                                    @endcan

                                                    @can('delete_transactions')
                                                        @if($transaction->user_id === auth()->id() || auth()->user()->isBendahara())
                                                            <a href="#" onclick="deleteTransaction('{{ $transaction->id }}', 'desktop')" class="text-rose-600 hover:text-rose-800 text-sm font-medium hover:underline">
                                                                Hapus
                                                            </a>
                                                            <form id="delete-form-desktop-{{ $transaction->id }}" method="POST" action="{{ route('transactions.destroy', $transaction) }}" class="hidden">
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
                            @foreach($transactions as $transaction)
                            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 p-3 shadow-sm hover:shadow-md transition-all duration-200">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center space-x-3">
                                        @if($transaction->type === 'expense')
                                        <div class="flex items-center justify-center">
                                            <img src="{{ asset('calculator.png') }}" alt="Expense" class="w-8 h-8 object-contain">
                                        </div>
                                        <div>
                                            <span class="font-semibold text-slate-800 dark:text-slate-200">Pengeluaran</span>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                            @if(auth()->user()->isBendahara())
                                            <p class="text-xs text-slate-400 dark:text-slate-500">by {{ $transaction->user->name }}</p>
                                            @endif
                                        </div>
                                        @else
                                        <div class="flex items-center justify-center">
                                            <img src="{{ asset('cryptocurrency.png') }}" alt="Income" class="w-8 h-8 object-contain">
                                        </div>
                                        <div>
                                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $transaction->user->name ?? 'Unknown' }}</span>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                            @if(auth()->user()->isBendahara())
                                            <p class="text-xs text-slate-400 dark:text-slate-500">by {{ $transaction->user->name }}</p>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->type === 'income' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700' }}">
                                        {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $transaction->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : ($transaction->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700') }}">
                                        {{ $transaction->status === 'approved' ? 'Disetujui' : ($transaction->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-2 mt-3">
                                    <a href="{{ route('transactions.show', $transaction) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium hover:underline">Lihat</a>
                                    @can('edit_transactions')
                                    @if($transaction->user_id === auth()->id() || auth()->user()->isBendahara())
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium hover:underline">Edit</a>
                                    @endif
                                    @endcan
                                    @can('delete_transactions')
                                    @if($transaction->user_id === auth()->id() || auth()->user()->isBendahara())
                                    <a href="#" onclick="deleteTransaction('{{ $transaction->id }}', 'mobile')" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-medium hover:underline">Hapus</a>
                                    <form id="delete-form-mobile-{{ $transaction->id }}" method="POST" action="{{ route('transactions.destroy', $transaction) }}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $transactions->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="flex items-center justify-center mx-auto mb-6">
                                <img src="{{ asset('searching.png') }}" alt="No Transactions" class="w-20 h-20 object-contain">
                            </div>
                            <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada transaksi</h3>
                            <p class="text-slate-500 mb-6">Mulai dengan menambahkan transaksi pertama Anda</p>
                            @can('create_transactions')
                            <a href="{{ route('transactions.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                                <img src="{{ asset('money.png') }}" alt="Add First Transaction" class="w-5 h-5 object-contain">
                                <span>Tambah Transaksi Pertama</span>
                            </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Delete Confirmation -->
    <script>
        function deleteTransaction(transactionId, type) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan transaksi yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formId = 'delete-form-' + type + '-' + transactionId;
                    const form = document.getElementById(formId);

                    if (form) {
                        form.submit();
                    } else {
                        console.error('Form not found:', formId);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Form tidak ditemukan. Silakan refresh halaman dan coba lagi.',
                            icon: 'error'
                        });
                    }
                }
            });
        }
    </script>

</x-app-layout>
