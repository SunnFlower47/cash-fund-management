<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center">
                <img src="{{ asset('receipt.png') }}" alt="Upload Bukti Pembayaran" class="w-10 h-10 object-contain">
            </div>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                    {{ __('Upload Bukti Pembayaran') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Upload bukti pembayaran untuk transaksi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                <div class="p-6 text-slate-900 dark:text-slate-100">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-blue-400 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Upload Bukti Pembayaran</h3>
                    </div>

                    <form method="POST" action="{{ route('payment-proofs.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="file" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">File Bukti Pembayaran</label>
                            <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-slate-300 dark:border-slate-600 border-dashed rounded-2xl hover:border-slate-400 dark:hover:border-slate-500 transition-all duration-200 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600">
                                <div class="space-y-3 text-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-blue-100 dark:from-green-900/50 dark:to-blue-900/50 rounded-2xl flex items-center justify-center mx-auto">
                                        <svg class="h-8 w-8 text-slate-500 dark:text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="flex text-sm text-slate-600 dark:text-slate-400">
                                        <label for="file" class="relative cursor-pointer bg-white dark:bg-slate-700 rounded-xl font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-4 py-2 border border-indigo-200 dark:border-indigo-600 hover:border-indigo-300 dark:hover:border-indigo-500 transition-all duration-200">
                                            <span>Pilih File</span>
                                            <input id="file" name="file" type="file" class="sr-only" required accept="image/*,application/pdf" onchange="updateFileName(this)">
                                        </label>
                                        <p class="pl-2 self-center">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">PNG, JPG, PDF hingga 10MB</p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <div>
                            <label for="member_name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Nama Anggota yang Membayar</label>
                            <select id="member_name" name="member_name" required class="mt-1 block w-full border-slate-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 px-4 py-3 transition-all duration-200">
                                <option value="">Pilih Nama Anggota</option>
                                <option value="Ridwan" {{ old('member_name') === 'Ridwan' ? 'selected' : '' }}>Ridwan</option>
                                <option value="Ilham" {{ old('member_name') === 'Ilham' ? 'selected' : '' }}>Ilham</option>
                                <option value="Nabas" {{ old('member_name') === 'Nabas' ? 'selected' : '' }}>Nabas</option>
                                <option value="Burman" {{ old('member_name') === 'Burman' ? 'selected' : '' }}>Burman</option>
                                <option value="Ganda" {{ old('member_name') === 'Ganda' ? 'selected' : '' }}>Ganda</option>
                                <option value="Karlos" {{ old('member_name') === 'Karlos' ? 'selected' : '' }}>Karlos</option>
                            </select>
                            @error('member_name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>



                        <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6">
                            <a href="{{ route('payment-proofs.index') }}" class="w-full sm:w-auto bg-slate-100 dark:bg-slate-600 hover:bg-slate-200 dark:hover:bg-slate-500 text-slate-700 dark:text-slate-300 font-bold py-3 px-6 rounded-2xl transition-all duration-200 flex items-center justify-center space-x-2 border border-slate-200 dark:border-slate-500 hover:border-slate-300 dark:hover:border-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Batal</span>
                            </a>
                            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>Upload Bukti Pembayaran</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name;
            if (fileName) {
                const label = input.parentElement.querySelector('span');
                label.textContent = fileName;
            }
        }
    </script>
</x-app-layout>
