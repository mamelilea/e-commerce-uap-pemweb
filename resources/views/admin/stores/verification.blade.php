@extends('layouts.admin.admin')

@section('title', 'Verifikasi Toko')

@section('content')
    <h1 class="admin-title">Verifikasi Toko</h1>

    @if($unverifiedStores->isEmpty())
        <p>Tidak ada toko yang menunggu verifikasi.</p>
    @endif

    @foreach($unverifiedStores as $store)
        <div class="store-card">
            <h3>{{ $store->name }}</h3>
            <p><strong>Pemilik:</strong> {{ $store->user->name }}</p>
            <p><strong>Kota:</strong> {{ $store->city }}</p>
            <p><strong>Deskripsi:</strong> {{ $store->about }}</p>

            <div class="actions">
                <form action="{{ route('admin.stores.verify', $store->id) }}" method="POST">
                    @csrf
                    <button class="btn-verify">Verifikasi</button>
                </form>

                <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn-reject">Tolak</button>
                </form>
            </div>
        </div>
    @endforeach

    {{ $unverifiedStores->links() }}
@endsection
