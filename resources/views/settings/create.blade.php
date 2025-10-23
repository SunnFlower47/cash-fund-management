<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center">
                <img src="{{ asset('flash-sale.png') }}" alt="Tambah User" class="w-10 h-10 object-contain">
            </div>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                    {{ __('Tambah User Baru') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Buat akun user baru dengan role yang sesuai</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                <div class="p-4 text-slate-900 dark:text-slate-100">
                    <form method="POST" action="{{ route('settings.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        </div>

                        <div>
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role" class="border-slate-300 dark:border-slate-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100" required>
                                <option value="">Pilih Role</option>
                                <option value="anggota" {{ old('role') === 'anggota' ? 'selected' : '' }}>Anggota</option>
                                <option value="bendahara" {{ old('role') === 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-3">
                            <a href="{{ route('settings.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center space-x-2 bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                                <img src="{{ asset('flash-sale.png') }}" alt="Create User" class="w-5 h-5 object-contain">
                                <span>Buat User</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
