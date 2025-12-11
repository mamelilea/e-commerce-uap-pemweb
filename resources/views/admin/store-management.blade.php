@extends('admin.layouts.app')

@section('title', 'Manajemen Toko')
@section('page-title', 'Manajemen Toko')

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

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-verified {
        background: #d4edda;
        color: #155724;
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-right: 5px;
    }

    .btn-toggle {
        background: #ffc107;
        color: white;
    }

    .btn-toggle:hover {
        background: #e0a800;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .stats-mini {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-mini {
        background: linear-gradient(135deg, #fff5f8, #fce4ec);
        padding: 15px;
        border-radius: 10px;
        text-align: center;
    }

    .stat-mini-value {
        font-size: 28px;
        font-weight: 700;
        color: #ff6b9d;
    }

    .stat-mini-label {
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
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
</style>

<div class="content-card">
    <h2 style="color: #ff6b9d; margin-bottom: 10px;">🏪 Manajemen Toko</h2>
    <p style="color: #666; margin-bottom: 20px;">Kelola semua toko yang terdaftar di platform</p>

    <div class="stats-mini">
        <div class="stat-mini">
            <div class="stat-mini-value">{{ $stores->total() }}</div>
            <div class="stat-mini-label">Total Toko</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-value">{{ $stores->where('is_verified', true)->count() }}</div>
            <div class="stat-mini-label">Terverifikasi</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-value">{{ $stores->where('is_verified', false)->count() }}</div>
            <div class="stat-mini-label">Pending</div>
        </div>
    </div>

    @if($stores->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Toko</th>
                        <th>Pemilik</th>
                        <th>Kota</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stores as $store)
                    <tr>
                        <td>
                            <div class="store-info">
                                <img src="{{ asset('storage/' . $store->logo) }}" 
                                     alt="{{ $store->name }}" 
                                     class="store-logo">
                                <div class="store-details">
                                    <h4>{{ $store->name }}</h4>
                                    <p>{{ Str::limit($store->about, 40) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $store->user->name }}</strong><br>
                            <small style="color: #666;">{{ $store->user->email }}</small>
                        </td>
                        <td>{{ $store->city }}</td>
                        <td>
                            @if($store->is_verified)
                                <span class="badge badge-verified">✓ Terverifikasi</span>
                            @else
                                <span class="badge badge-pending">⏳ Pending</span>
                            @endif
                        </td>
                        <td>{{ $store->created_at->format('d M Y') }}</td>
                        <td>
                            <form method="POST" 
                                  action="{{ route('admin.stores.toggle', $store->id) }}" 
                                  style="display: inline;">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-toggle"
                                        onclick="return confirm('Yakin ingin mengubah status verifikasi toko ini?')">
                                    @if($store->is_verified)
                                        🔒 Tangguhkan
                                    @else
                                        ✓ Verifikasi
                                    @endif
                                </button>
                            </form>
                            
                            <form method="POST" 
                                  action="{{ route('admin.stores.delete', $store->id) }}" 
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-delete"
                                        onclick="return confirm('Yakin ingin menghapus toko ini? Data akan dihapus permanen!')">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $stores->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🏪</div>
            <h3>Belum Ada Toko</h3>
            <p>Belum ada toko yang terdaftar di platform</p>
        </div>
    @endif
</div>
@endsection