<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center">
                <img src="{{ asset('seting.png') }}" alt="Reset Password" class="w-10 h-10 object-contain">
            </div>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                    {{ __('Reset Password') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Reset password untuk: {{ $user->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                <div class="p-4 text-slate-900 dark:text-slate-100">
                    <form method="POST" action="{{ route('settings.update-password', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('seting.png') }}" alt="Warning" class="w-5 h-5 object-contain">
                                <span class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Peringatan</span>
                            </div>
                            <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-2">Password baru akan mengganti password lama. User harus login ulang dengan password baru.</p>
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password Baru')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-3">
                            <a href="{{ route('settings.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center space-x-2 bg-gradient-to-r from-yellow-400 to-orange-400 hover:from-yellow-500 hover:to-orange-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                                <img src="{{ asset('seting.png') }}" alt="Reset Password" class="w-5 h-5 object-contain">
                                <span>Reset Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
