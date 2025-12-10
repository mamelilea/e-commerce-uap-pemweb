@extends('layouts.admin.admin')

@section('title', 'Edit User')

@section('content')
<div class="admin-container">
    <h1 class="admin-title">Edit User</h1>

    <div class="edit-card">
        <form action="{{ route('admin.users-stores.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Nama:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
            </select>

            @if($user->store)
                <p><strong>Toko:</strong> {{ $user->store->name }}</p>
                <p>Status:
                    <span class="badge {{ $user->store->is_verified ? 'verified' : 'pending' }}">
                        {{ $user->store->is_verified ? 'Verified' : 'Pending' }}
                    </span>
                </p>
            @endif

            <button class="btn-submit">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
