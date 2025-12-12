<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <h1 class="font-sans text-4xl font-bold uppercase text-hubbub-black tracking-tight mb-8">Account Settings</h1>

            <div class="p-10 bg-white rounded-[40px] shadow-sm border border-gray-100 hover:shadow-[0px_10px_30px_rgba(234,92,136,0.1)] transition-all duration-300">
                <div class="max-w-xl">
                    <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black mb-6 flex items-center gap-3 tracking-wide">
                        <div class="w-10 h-10 bg-pink-50 rounded-full flex items-center justify-center text-hubbub-pink">
                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        Profile Information
                    </h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-10 bg-white rounded-[40px] shadow-sm border border-gray-100 hover:shadow-[0px_10px_30px_rgba(234,92,136,0.1)] transition-all duration-300">
                <div class="max-w-xl">
                     <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black mb-6 flex items-center gap-3 tracking-wide">
                        <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-hubbub-black">
                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                         Update Password
                    </h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-10 bg-white rounded-[40px] shadow-sm border border-red-50 hover:shadow-lg hover:shadow-red-50 transition-all duration-300">
                <div class="max-w-xl">
                    <h3 class="font-sans text-xl font-bold uppercase text-red-500 mb-6 flex items-center gap-3 tracking-wide">
                        <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center text-red-500">
                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        Danger Zone
                    </h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
