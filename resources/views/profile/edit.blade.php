@extends('layouts.customer')

@section('title', 'Profile')

@section('content')
<div class="bg-gray-100 min-h-screen py-10">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-6">

            <!-- SIDEBAR -->
            <div class="w-full md:w-1/4">
                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <!-- Profile Header -->
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                        <img src="{{ auth()->user()->buyer && auth()->user()->buyer->profile_picture ? asset('storage/' . auth()->user()->buyer->profile_picture) : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png' }}" 
                             alt="Profile" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                        <div>
                            <p class="text-xs text-gray-500">Hello,</p>
                            <p class="font-semibold text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
                        </div>
                    </div>

                    <!-- Menu Links -->
                    <div class="space-y-1">
                        <a href="#" onclick="showBiodata()" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-md transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Profile</span>
                        </a>
                        <a href="#" onclick="showPasswordForm()" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-md transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            <span>Reset Password</span>
                        </a>
                        <a href="#" onclick="showDeleteAccount()" class="flex items-center gap-3 px-3 py-2 text-red-600 hover:bg-red-50 rounded-md transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Delete Account</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-md transition w-full text-left">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- PROFILE CONTENT -->
            <div class="w-full md:w-3/4">

                @if(session('status') === 'profile-updated')
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                        Profile updated successfully!
                    </div>
                @endif

                <!-- BIODATA SECTION (Read-Only View) -->
                <div id="biodataSection" class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-xl font-bold text-gray-800">Personal Information</h4>
                        <button onclick="toggleEditMode()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm font-medium">
                            Edit Profile
                        </button>
                    </div>

                    <!-- Read-Only View -->
                    <div id="biodataReadOnly" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">First Name</label>
                                <p class="text-gray-800 font-medium">{{ auth()->user()->buyer->first_name ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Last Name</label>
                                <p class="text-gray-800 font-medium">{{ auth()->user()->buyer->last_name ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Date of Birth</label>
                                <p class="text-gray-800 font-medium">{{ auth()->user()->buyer && auth()->user()->buyer->date_of_birth ? auth()->user()->buyer->date_of_birth->format('d M Y') : 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                                <p class="text-gray-800 font-medium">{{ auth()->user()->email }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Phone Number</label>
                                <p class="text-gray-800 font-medium">{{ auth()->user()->buyer->phone_number ?? 'Not set' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Form (Hidden by default) -->
                    <div id="biodataEditForm" class="hidden">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <!-- FOTO PROFIL -->
                            <div class="text-center mb-6">
                                <img id="previewImg"
                                    src="{{ auth()->user()->buyer && auth()->user()->buyer->profile_picture ? asset('storage/' . auth()->user()->buyer->profile_picture) : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png' }}"
                                    class="w-40 h-40 rounded-full object-cover border-4 border-gray-200 mx-auto">
                                <input type="file" name="profile_picture" id="photoUpload" class="mt-4 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100
                                    mx-auto max-w-xs
                                ">
                                @error('profile_picture')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <hr class="my-6 border-gray-200">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->buyer->first_name ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="First" required>
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', auth()->user()->buyer->last_name ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Last" required>
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Date of Birth</label>
                                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', auth()->user()->buyer && auth()->user()->buyer->date_of_birth ? auth()->user()->buyer->date_of_birth->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('date_of_birth')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="email@example.com" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number', auth()->user()->buyer->phone_number ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="+62xxx">
                                    @error('phone_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition font-medium">Save Changes</button>
                                <button type="button" onclick="toggleEditMode()" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition font-medium">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- CHANGE PASSWORD SECTION -->
                <div id="passwordSection" class="bg-white p-6 rounded-xl shadow-sm hidden">
                    <h4 class="mb-6 text-xl font-bold text-gray-800">Reset Password</h4>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" name="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('current_password', 'updatePassword')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('password', 'updatePassword')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition font-medium">Update Password</button>
                    </form>
                </div>

                <!-- DELETE ACCOUNT SECTION -->
                <div id="deleteAccountSection" class="bg-white p-6 rounded-xl shadow-sm hidden">
                    <h4 class="mb-6 text-xl font-bold text-red-600">Delete Account</h4>
                    
                    <div class="bg-red-50 p-4 rounded-lg mb-6">
                        <p class="text-red-800 text-sm">
                            <strong>Warning:</strong> This action cannot be undone. Once your account is deleted, all of your resources and data will be permanently deleted.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        @csrf
                        @method('delete')

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="Enter your password to confirm">
                            @error('password', 'userDeletion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition font-medium">Delete Account Permanently</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview Foto
    const photoUpload = document.getElementById('photoUpload');
    if (photoUpload) {
        photoUpload.addEventListener('change', function (event) {
            const img = document.getElementById('previewImg');
            if (event.target.files && event.target.files[0]) {
                img.src = URL.createObjectURL(event.target.files[0]);
            }
        });
    }

    // Toggle Edit Mode
    window.toggleEditMode = function() {
        const readOnly = document.getElementById('biodataReadOnly');
        const editForm = document.getElementById('biodataEditForm');
        
        if (readOnly.classList.contains('hidden')) {
            readOnly.classList.remove('hidden');
            editForm.classList.add('hidden');
        } else {
            readOnly.classList.add('hidden');
            editForm.classList.remove('hidden');
        }
    }

    // Show Ganti Password
    window.showPasswordForm = function() {
        document.getElementById('passwordSection').classList.remove('hidden');
        document.getElementById('biodataSection').classList.add('hidden');
        document.getElementById('deleteAccountSection').classList.add('hidden');
    }

    // Show Biodata
    window.showBiodata = function() {
        document.getElementById('passwordSection').classList.add('hidden');
        document.getElementById('biodataSection').classList.remove('hidden');
        document.getElementById('deleteAccountSection').classList.add('hidden');
        // Reset to read-only mode
        document.getElementById('biodataReadOnly').classList.remove('hidden');
        document.getElementById('biodataEditForm').classList.add('hidden');
    }

    // Show Delete Account
    window.showDeleteAccount = function() {
        document.getElementById('passwordSection').classList.add('hidden');
        document.getElementById('biodataSection').classList.add('hidden');
        document.getElementById('deleteAccountSection').classList.remove('hidden');
    }
</script>
@endpush
@endsection