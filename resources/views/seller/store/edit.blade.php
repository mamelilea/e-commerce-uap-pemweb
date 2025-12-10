<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Store Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('seller.store.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')


                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Store Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $store->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>


                        <div class="mb-4">
                            <x-input-label for="about" :value="__('Description')" />
                            <textarea id="about" name="about" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4" required>{{ old('about', $store->about) }}</textarea>
                            <x-input-error :messages="$errors->get('about')" class="mt-2" />
                        </div>


                        <div class="mb-4">
                            <x-input-label for="city" :value="__('City')" />
                            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city', $store->city)" required />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                        

                        <div class="mb-4">
                            <x-input-label for="address" :value="__('Address')" />
                            <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2">{{ old('address', $store->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('seller.dashboard') }}" class="text-gray-600 underline mr-4">Cancel</a>
                            <x-primary-button class="ml-4">
                                {{ __('Update Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
