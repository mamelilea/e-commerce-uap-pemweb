@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

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

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff6b9d, #ff8fb3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-details h4 {
        color: #333;
        margin-bottom: 3px;
        font-size: 15px;
    }

    .user-details p {
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

    .badge-no-store {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
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
    <h2 style="color: #ff6b9d; margin-bottom: 10px;">👥 Manajemen Pengguna</h2>
    <p style="color: #666; margin-bottom: 20px;">Kelola semua pengguna yang terdaftar di platform</p>

    <div class="stats-mini">
        <div class="stat-mini">
            <div class="stat-mini-value">{{ $users->total() }}</div>
            <div class="stat-mini-label">Total Pengguna</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-value">{{ $users->where('store', '!=', null)->count() }}</div>
            <div class="stat-mini-label">Punya Toko</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-value">{{ $users->where('store', null)->count() }}</div>
            <div class="stat-mini-label">Tanpa Toko</div>
        </div>
    </div>

    @if($users->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Status Toko</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="user-details">
                                    <h4>{{ $user->name }}</h4>
                                    <p>ID: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->store)
                                <span class="badge badge-verified">
                                    🏪 {{ $user->store->name }}
                                    @if($user->store->is_verified)
                                        <br><small style="color: #155724;">✓ Terverifikasi</small>
                                    @else
                                        <br><small style="color: #856404;">⏳ Pending</small>
                                    @endif
                                </span>
                            @else
                                <span class="badge badge-no-store">Tidak Ada Toko</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <form method="POST" 
                                  action="{{ route('admin.users.delete', $user->id) }}" 
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn-delete"
                                        onclick="return confirm('Yakin ingin menghapus pengguna ini? Data akan dihapus permanen!')">
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
            {{ $users->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">👥</div>
            <h3>Belum Ada Pengguna</h3>
            <p>Belum ada pengguna yang terdaftar di platform</p>
        </div>
    @endif
</div>
@endsection