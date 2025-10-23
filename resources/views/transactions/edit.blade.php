<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4 sm:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <div class="flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl shadow-lg">
                        <img src="{{ asset('searching.png') }}" alt="Edit Transaksi" class="w-8 h-8 sm:w-10 sm:h-10 object-contain">
                    </div>
                    <div class="text-center sm:text-left">
                        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
                            Edit Transaksi
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Edit detail transaksi kas</p>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4 sm:p-6">
                <div class="text-slate-900 dark:text-slate-100">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="type" :value="__('Jenis Transaksi')" />
                            <select id="type" name="type" class="block mt-1 w-full border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100" required>
                                <option value="">Pilih Jenis Transaksi</option>
                                <option value="income" {{ old('type', $transaction->type) === 'income' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="expense" {{ old('type', $transaction->type) === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Jumlah (Rp)')" />
                            <input id="amount" class="block mt-1 w-full border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100" type="number" name="amount" value="{{ old('amount', $transaction->amount) }}" required step="0.01" min="0" />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="3" required class="mt-1 block w-full border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ old('description', $transaction->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="source" :value="__('Sumber (Opsional)')" />
                            <input id="source" class="block mt-1 w-full border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100" type="text" name="source" value="{{ old('source', $transaction->source) }}" />
                            <x-input-error :messages="$errors->get('source')" class="mt-2" />
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Contoh: manual_income, member_payment, expense</p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Catatan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="2" class="mt-1 block w-full border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ old('notes', $transaction->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-end gap-3 sm:gap-4">
                            <a href="{{ route('transactions.show', $transaction) }}" class="bg-slate-500 hover:bg-slate-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto text-center">
                                Batal
                            </a>
                            <x-primary-button class="w-full sm:w-auto">
                                {{ __('Update Transaksi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
