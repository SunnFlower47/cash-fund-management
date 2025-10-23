<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg p-4 sm:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl shadow-lg">
                            <img src="{{ asset('receipt.png') }}" alt="Detail Bukti Pembayaran" class="w-8 h-8 sm:w-10 sm:h-10 object-contain">
                        </div>
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                Detail Bukti Pembayaran
                            </h1>
                            <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Lihat detail bukti pembayaran</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                        <a href="{{ route('payment-proofs.index') }}" class="bg-gradient-to-r from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl text-center">
                            Kembali
                        </a>
                        @can('edit_payment_proofs')
                        @if($paymentProof->user_id === auth()->id())
                        <a href="{{ route('payment-proofs.edit', $paymentProof) }}" class="bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl text-center">
                            Edit
                        </a>
                        @endif
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Content Container -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg overflow-hidden">
                <div class="p-4 sm:p-6 text-slate-900 dark:text-slate-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Informasi File</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">ID Bukti</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">#{{ $paymentProof->id }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Nama File</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $paymentProof->file_name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Ukuran File</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $paymentProof->formatted_file_size }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Tipe File</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $paymentProof->file_type }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentProof->status === 'approved' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' : ($paymentProof->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300' : 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300') }}">
                                            {{ $paymentProof->status === 'approved' ? 'Disetujui' : ($paymentProof->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Tanggal Upload</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $paymentProof->created_at->format('d/m/Y H:i:s') }}</dd>
                                </div>

                                @if($paymentProof->reviewed_at)
                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Tanggal Review</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $paymentProof->reviewed_at->format('d/m/Y H:i:s') }}</dd>
                                </div>
                                @endif

                                @if($paymentProof->reviewer)
                                <div>
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Direview Oleh</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $paymentProof->reviewer->name }}</dd>
                                </div>
                                @endif

                                @if($paymentProof->review_notes)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Catatan Review</dt>
                                    <dd class="mt-1 text-sm text-slate-900 dark:text-slate-100">{{ $paymentProof->review_notes }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Preview File</h3>
                            <div class="border border-slate-200 dark:border-slate-600 rounded-lg p-4 bg-slate-50 dark:bg-slate-700"></div>
                                @if(str_starts_with($paymentProof->file_type, 'image/'))
                                    <img src="{{ $paymentProof->file_url }}" alt="Preview" class="max-w-full h-auto rounded-lg">
                                @else
                                    <div class="text-center">
                                        <div class="w-24 h-24 bg-slate-200 dark:bg-slate-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                                            <span class="text-slate-500 dark:text-slate-400 text-2xl">📄</span>
                                        </div>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">{{ $paymentProof->file_name }}</p>
                                        <a href="{{ $paymentProof->file_url }}" target="_blank" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded">
                                            Buka File
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->isBendahara() && $paymentProof->status === 'pending')
                    <div class="mt-6 sm:mt-8 border-t border-slate-200 dark:border-slate-700 pt-4 sm:pt-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Aksi Review</h3>
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                            <button onclick="openApproveModal({{ $paymentProof->id }})" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
                                Setujui
                            </button>
                            <button onclick="openRejectModal({{ $paymentProof->id }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
                                Tolak
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    @if(auth()->user()->isBendahara() && $paymentProof->status === 'pending')
    <div id="approveModal" class="fixed inset-0 bg-slate-900/50 dark:bg-slate-900/75 backdrop-blur-sm overflow-y-auto h-full w-full hidden">
        <div class="relative top-4 sm:top-20 mx-auto p-4 sm:p-5 border border-slate-200 dark:border-slate-700 w-11/12 sm:w-96 max-w-md shadow-lg rounded-md bg-white dark:bg-slate-800">
            <div class="mt-3">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Setujui Bukti Pembayaran</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Ini hanya mengubah status bukti pembayaran. Untuk menambah kas, gunakan menu Kas Mingguan.</p>
                <form id="approveForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Catatan (Opsional)</label>
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-2">
                        <button type="button" onclick="closeApproveModal()" class="bg-slate-500 hover:bg-slate-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
                            Batal
                        </button>
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
                            Setujui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-slate-900/50 dark:bg-slate-900/75 backdrop-blur-sm overflow-y-auto h-full w-full hidden">
        <div class="relative top-4 sm:top-20 mx-auto p-4 sm:p-5 border border-slate-200 dark:border-slate-700 w-11/12 sm:w-96 max-w-md shadow-lg rounded-md bg-white dark:bg-slate-800">
            <div class="mt-3">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Tolak Bukti Pembayaran</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="review_notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Alasan Penolakan</label>
                        <textarea id="review_notes" name="review_notes" rows="3" class="mt-1 block w-full border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100" required></textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-2">
                        <button type="button" onclick="closeRejectModal()" class="bg-slate-500 hover:bg-slate-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
                            Batal
                        </button>
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openApproveModal(proofId) {
            document.getElementById('approveForm').action = `/payment-proofs/${proofId}/approve`;
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function openRejectModal(proofId) {
            document.getElementById('rejectForm').action = `/payment-proofs/${proofId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
    @endif
</x-app-layout>
