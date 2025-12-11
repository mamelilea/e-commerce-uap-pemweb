@extends('admin.layouts.app')

@section('title', 'Verifikasi Toko')
@section('page-title', 'Verifikasi Toko')

@section('content')
<style>
    .content-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    thead {
        background: linear-gradient(135deg, #ff6b9d, #ff8fb3);
        color: white;
    }

    th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    tbody tr:hover {
        background: #fff5f8;
    }

    .store-logo {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #fce4ec;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-approve {
        background: #28a745;
        color: white;
        margin-right: 5px;
    }

    .btn-approve:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .btn-reject {
        background: #dc3545;
        color: white;
    }

    .btn-reject:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .btn-detail {
        background: #ff6b9d;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .btn-detail:hover {
        background: #ff5089;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .empty-state-icon {
        font-size: 80px;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #ff6b9d;
        margin-bottom: 10px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
    }

    .pagination a,
    .pagination span {
        padding: 8px 15px;
        border-radius: 6px;
        text-decoration: none;
        color: #ff6b9d;
        border: 2px solid #fce4ec;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: #ff6b9d;
        color: white;
        border-color: #ff6b9d;
    }

    .pagination .active {
        background: #ff6b9d;
        color: white;
        border-color: #ff6b9d;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
    }

    .store-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .store-details h4 {
        color: #333;
        margin-bottom: 3px;
        font-size: 15px;
    }

    .store-details p {
        color: #666;
        font-size: 13px;
        margin: 0;
    }
</style>

<div class="content-card">
    <h2 style="color: #ff6b9d; margin-bottom: 10px;">📝 Pengajuan Toko Menunggu Verifikasi</h2>
    <p style="color: #666; margin-bottom: 20px;">Verifikasi atau tolak pengajuan pembuatan toko baru</p>

    @if($pendingStores->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Toko</th>
                        <th>Pemilik</th>
                        <th>Kota</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingStores as $store)
                    <tr>
                        <td>
                            <div class="store-info">
                                <img src="{{ asset('storage/' . $store->logo) }}" 
                                     alt="{{ $store->name }}" 
                                     class="store-logo">
                                <div class="store-details">
                                    <h4>{{ $store->name }}</h4>
                                    <p>{{ Str::limit($store->about, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $store->user->name }}</strong><br>
                            <small style="color: #666;">{{ $store->user->email }}</small>
                        </td>
                        <td>{{ $store->city }}</td>
                        <td>{{ $store->phone }}</td>
                        <td>
                            <span class="badge badge-pending">⏳ Pending</span>
                        </td>
                        <td>
                            <form method="POST" 
                                  action="{{ route('admin.store.approve', $store->id) }}" 
                                  style="display: inline;">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-approve"
                                        onclick="return confirm('Yakin ingin menyetujui toko ini?')">
                                    ✓ Setujui
                                </button>
                            </form>
                            
                            <form method="POST" 
                                  action="{{ route('admin.store.reject', $store->id) }}" 
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-reject"
                                        onclick="return confirm('Yakin ingin menolak toko ini? Data akan dihapus!')">
                                    ✗ Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $pendingStores->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">✅</div>
            <h3>Tidak Ada Pengajuan Toko</h3>
            <p>Semua pengajuan toko telah diproses atau belum ada pengajuan baru</p>
        </div>
    @endif
</div>
@endsection