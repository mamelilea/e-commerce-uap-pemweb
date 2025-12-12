<x-app-layout>
    <div class="py-12 bg-white md:bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-12">
                <h1 class="font-header text-4xl md:text-5xl font-bold uppercase text-hubbub-black tracking-tighter mb-4">
                    Join the <span class="text-hubbub-pink">Revolution</span>
                </h1>
                <p class="text-gray-500 font-sans text-lg max-w-xl mx-auto">
                    Start selling your unique style on Hubbub today. Create your store and reach thousands of trendsetters.
                </p>
            </div>

            {{-- Registration Form --}}
            <div class="bg-white border-2 border-hubbub-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-8 md:p-10 relative">
                {{-- Decorative Corner --}}
                <div class="absolute -top-3 -left-3 w-8 h-8 bg-hubbub-pink border-2 border-hubbub-black"></div>
                
                <h2 class="font-header text-2xl font-bold uppercase text-hubbub-black mb-8 border-b-2 border-gray-100 pb-4">
                    Register Your Store
                </h2>

                <form action="{{ route('store.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Store Name --}}
                    <div class="mb-6">
                        <label for="name" class="block text-hubbub-black font-header font-bold uppercase text-sm mb-2 tracking-wide">
                            Store Name
                        </label>
                        <input type="text" name="name" id="name" 
                            class="w-full bg-gray-50 border-2 border-gray-200 p-4 font-sans focus:border-hubbub-black focus:ring-0 transition-colors placeholder-gray-400"
                            placeholder="e.g. Urban Threads"
                            value="{{ old('name') }}"
                            required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Store Logo --}}
                    <div class="mb-6">
                        <label for="logo" class="block text-hubbub-black font-header font-bold uppercase text-sm mb-2 tracking-wide">
                            Store Logo
                        </label>
                        <input type="file" name="logo" id="logo" 
                            class="w-full bg-gray-50 border-2 border-gray-200 p-3 font-sans focus:border-hubbub-black focus:ring-0 transition-colors file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-hubbub-black file:text-white hover:file:bg-hubbub-pink"
                            accept="image/*">
                        @error('logo')
                             <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- About Store --}}
                    <div class="mb-6">
                        <label for="about" class="block text-hubbub-black font-header font-bold uppercase text-sm mb-2 tracking-wide">
                            About Your Brand
                        </label>
                        <textarea name="about" id="about" rows="4" 
                            class="w-full bg-gray-50 border-2 border-gray-200 p-4 font-sans focus:border-hubbub-black focus:ring-0 transition-colors placeholder-gray-400"
                            placeholder="Tell us what makes your store unique..."
                            required>{{ old('about') }}</textarea>
                         @error('about')
                            <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="city" class="block text-hubbub-black font-header font-bold uppercase text-sm mb-2 tracking-wide">
                                City
                            </label>
                            <input type="text" name="city" id="city" 
                                class="w-full bg-gray-50 border-2 border-gray-200 p-4 font-sans focus:border-hubbub-black focus:ring-0 transition-colors placeholder-gray-400"
                                placeholder="e.g. Jakarta Selatan"
                                value="{{ old('city') }}"
                                required>
                        </div>
                        <div>
                            <label for="address" class="block text-hubbub-black font-header font-bold uppercase text-sm mb-2 tracking-wide">
                                Full Address
                            </label>
                            <input type="text" name="address" id="address" 
                                class="w-full bg-gray-50 border-2 border-gray-200 p-4 font-sans focus:border-hubbub-black focus:ring-0 transition-colors placeholder-gray-400"
                                placeholder="Street name, number, etc."
                                value="{{ old('address') }}"
                                required>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="w-full bg-hubbub-black text-white font-header font-bold uppercase text-xl py-4 border-2 border-transparent hover:bg-white hover:text-hubbub-black hover:border-hubbub-black shadow-md transition-all duration-300">
                        Launch My Store
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
