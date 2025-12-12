<x-app-layout>
    <x-slot name="header">
        <h2 class="font-header font-bold text-3xl uppercase text-hubbub-black leading-tight tracking-tighter">
            {{ __('Store Settings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 lg:p-12 rounded-3xl shadow-sm border border-gray-100">
                
                <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                         {{-- Logo Section --}}
                        <div class="flex flex-col items-center justify-start md:col-span-1">
                            <div class="mb-8 relative group">
                                <label class="block text-gray-400 text-[10px] font-sans font-bold uppercase mb-4 text-center tracking-widest">Current Logo</label>
                                @if($store->logo)
                                    <div class="p-2 border border-gray-100 bg-white rounded-full shadow-md">
                                        <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo" class="w-48 h-48 object-cover rounded-full">
                                    </div>
                                @else
                                    <div class="w-48 h-48 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 font-sans font-bold uppercase border border-gray-200 border-dashed shadow-inner text-xs tracking-widest">
                                        No Logo
                                    </div>
                                @endif
                            </div>

                            <div class="mb-4 w-full max-w-xs text-center">
                                <label for="logo" class="cursor-pointer inline-block bg-white text-hubbub-black border border-hubbub-black font-sans font-bold uppercase px-6 py-3 rounded-full hover:bg-hubbub-black hover:text-white transition-all text-xs tracking-wider shadow-sm">
                                    Change Logo
                                </label>
                                <input type="file" name="logo" id="logo" class="hidden">
                                <p class="text-[10px] text-gray-400 mt-2 font-sans">Max file size 2MB</p>
                            </div>
                        </div>

                        {{-- Details Section --}}
                        <div class="md:col-span-2">
                             <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black tracking-tight mb-8 border-b border-gray-100 pb-4">Store Details</h3>

                            <div class="mb-6">
                                <label for="name" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Store Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $store->name) }}" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800" required>
                            </div>

                            <div class="mb-6">
                                <label for="about" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">About Store</label>
                                <textarea name="about" id="about" rows="6" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans text-gray-600 resize-none" required>{{ old('about', $store->about) }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="city" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">City</label>
                                    <input type="text" name="city" id="city" value="{{ old('city', $store->city) }}" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800" required>
                                </div>
                                <div>
                                    <label for="address" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Address</label>
                                    <input type="text" name="address" id="address" value="{{ old('address', $store->address) }}" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800" required>
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="bg-hubbub-black text-white font-sans font-bold uppercase px-10 py-4 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 transform hover:-translate-y-0.5 text-xs tracking-wider">
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
