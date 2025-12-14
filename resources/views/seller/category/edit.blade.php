<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori: ') . $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('seller.categories.update', $category) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Kategori')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name', $category->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Gambar Kategori (Biarkan kosong jika tidak ingin diubah)')" />
                        @if ($category->image)
                            <div class="mt-2 mb-2">
                                <span class="text-sm text-gray-600">Gambar saat ini:</span>
                                <img src="{{ asset($category->image) }}" alt="Gambar Kategori"
                                    class="h-20 w-20 object-cover rounded-md">
                            </div>
                        @endif
                        <input id="image"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none mt-1"
                            type="file" name="image">
                        <p class="mt-1 text-xs text-gray-500">Maks. 2MB, format JPEG/PNG.</p>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="tagline" :value="__('Tagline (Opsional)')" />
                        <x-text-input id="tagline" class="block mt-1 w-full" type="text" name="tagline"
                            :value="old('tagline', $category->tagline)" />
                        <x-input-error :messages="$errors->get('tagline')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="description"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                            name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-secondary-button href="{{ route('seller.categories.index') }}" class="mr-2">
                            {{ __('Batal') }}
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Perbarui Kategori') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-seller-layout>
