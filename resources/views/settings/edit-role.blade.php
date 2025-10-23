<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center">
                <img src="{{ asset('profile.png') }}" alt="Edit Role" class="w-10 h-10 object-contain">
            </div>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                    {{ __('Edit Role') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Edit role: {{ ucfirst($role->name) }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                <div class="p-4 text-slate-900 dark:text-slate-100">
                    <form method="POST" action="{{ route('settings.update-role', $role) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Nama Role')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $role->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="permissions" :value="__('Permission')" />
                            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($permissions as $permission)
                                <label class="flex items-center space-x-2 p-3 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                           {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
                                           class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $permission->name }}</span>
                                </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-3">
                            <a href="{{ route('settings.roles') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-400 to-indigo-400 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                                <img src="{{ asset('flash-sale.png') }}" alt="Update Role" class="w-5 h-5 object-contain">
                                <span>Update Role</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
