@extends('layouts.admin.admin')

@section('title', 'Manajemen Pengguna & Toko')

@section('content')
    <h1 class="admin-title">Manajemen Pengguna & Toko</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Toko</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>

                <td>
                    @if($user->store)
                        {{ $user->store->name }}
                        <span class="badge {{ $user->store->is_verified ? 'verified' : 'pending' }}">
                            {{ $user->store->is_verified ? 'Verified' : 'Pending' }}
                        </span>
                    @else
                        <span class="badge none">Tidak punya toko</span>
                    @endif
                </td>

                <td>
                    <a class="btn-edit" href="{{ route('admin.users-stores.edit', $user->id) }}">Edit</a>

                    <form action="{{ route('admin.users-stores.destroy', $user->id) }}"
                          method="POST"
                          style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn-delete" onclick="return confirm('Hapus user ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
@endsection
