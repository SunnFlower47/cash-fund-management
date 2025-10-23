<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-slate-200 leading-tight">
            {{ __('Tambah Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-slate-100">
                    <form method="POST" action="{{ route('transactions.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="type" :value="__('Jenis Transaksi')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100" required>
                                <option value="">Pilih Jenis Transaksi</option>
                                <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Jumlah (Rp)')" />
                            <input id="amount" class="block mt-1 w-full border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100" type="number" name="amount" value="{{ old('amount') }}" required step="0.01" min="0" />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Deskripsi</label>
                            <textarea id="description" name="description" rows="3" required class="mt-1 block w-full border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="source" :value="__('Sumber (Opsional)')" />
                            <input id="source" class="block mt-1 w-full border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100" type="text" name="source" value="{{ old('source') }}" />
                            <x-input-error :messages="$errors->get('source')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Contoh: manual_income, member_payment, expense</p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Catatan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="2" class="mt-1 block w-full border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 dark:bg-slate-600 hover:bg-gray-600 dark:hover:bg-slate-500 text-white font-bold py-2 px-4 rounded mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Transaksi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
