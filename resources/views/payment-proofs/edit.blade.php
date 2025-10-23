<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4 sm:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <div class="flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl shadow-lg">
                        <img src="{{ asset('receipt.png') }}" alt="Edit Bukti Pembayaran" class="w-8 h-8 sm:w-10 sm:h-10 object-contain">
                    </div>
                    <div class="text-center sm:text-left">
                        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
                            Edit Bukti Pembayaran
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Edit bukti pembayaran yang sudah diupload</p>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4 sm:p-6">
                <div class="text-slate-900 dark:text-slate-100">
                    <form method="POST" action="{{ route('payment-proofs.update', $paymentProof) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="file" :value="__('File Bukti Pembayaran Baru (Opsional)')" />
                            <x-text-input id="file" class="block mt-1 w-full" type="file" name="file" accept="image/*,application/pdf" />
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Format yang didukung: JPG, PNG, PDF. Maksimal 10MB. Kosongkan jika tidak ingin mengubah file.</p>
                        </div>

                        <div>
                            <x-input-label for="current_file" :value="__('File Saat Ini')" />
                            <div class="mt-1 p-3 bg-slate-50 dark:bg-slate-700 rounded-md border border-slate-200 dark:border-slate-600">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-slate-200 dark:bg-slate-600 rounded flex items-center justify-center">
                                            <span class="text-slate-500 dark:text-slate-400 text-sm">📄</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate">
                                            {{ $paymentProof->file_name }}
                                        </p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $paymentProof->formatted_file_size }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="{{ $paymentProof->file_url }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 text-sm font-medium">
                                            Lihat File
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-end gap-3 sm:gap-4">
                            <a href="{{ route('payment-proofs.show', $paymentProof) }}" class="bg-slate-500 hover:bg-slate-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto text-center">
                                Batal
                            </a>
                            <x-primary-button class="w-full sm:w-auto">
                                {{ __('Update Bukti Pembayaran') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
