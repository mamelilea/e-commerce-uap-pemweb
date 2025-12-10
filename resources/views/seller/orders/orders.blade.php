@extends('layouts.seller.seller')

@section('title', 'Manajemen Pesanan')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/seller/orders.css') }}">
@endsection

@section('content')
<div class="orders-wrapper">

    {{-- HEADER + FILTER SEDERHANA --}}
    <div class="orders-header">
        <div>
            <h2 class="page-title">Manajemen Pesanan</h2>
            <p class="page-subtitle">Lihat dan kelola pesanan yang masuk ke tokomu.</p>
        </div>

        <form action="{{ route('seller.orders.index') }}" method="GET" class="orders-filter-form">
            <input
                type="text"
                name="search"
                placeholder="Cari kode / nama pembeli..."
                value="{{ request('search') }}"
            >
            <select name="payment_status">
                <option value="">Semua Status</option>
                <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- JIKA TIDAK ADA PESANAN --}}
    @if ($orders->isEmpty())
        <div class="empty-state">
            <img src="{{ asset('img/element-web/empty-orders.svg') }}" alt="Belum ada pesanan">
            <h3>Belum ada pesanan</h3>
            <p>Jika ada pelanggan yang checkout di tokomu, pesanan akan muncul di sini.</p>
        </div>
    @else
        {{-- LIST PESANAN --}}
        <div class="orders-list">
            @foreach ($orders as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        <div>
                            <div class="order-code">#{{ $order->code }}</div>
                            <div class="order-date">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <div class="order-badges">
                            <span class="badge badge-status {{ $order->payment_status === 'paid' ? 'badge-paid' : 'badge-unpaid' }}">
                                {{ $order->payment_status === 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                            </span>

                            @if ($order->tracking_number)
                                <span class="badge badge-tracking">
                                    Resi: {{ $order->tracking_number }}
                                </span>
                            @else
                                <span class="badge badge-no-tracking">
                                    Belum ada nomor resi
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="order-card-body">
                        {{-- KIRI: informasi pembeli & pengiriman --}}
                        <div class="order-info">
                            <div class="info-block">
                                <h4>Pembeli</h4>
                                <p class="info-main">
                                    {{ optional($order->buyer->user)->name ?? '—' }}
                                </p>
                                <p class="info-sub">
                                    {{ $order->buyer->phone_number ?? 'No. HP belum ada' }}
                                </p>
                            </div>

                            <div class="info-block">
                                <h4>Pengiriman</h4>
                                <p class="info-main">
                                    {{ $order->shipping }} - {{ $order->shipping_type }}
                                </p>
                                <p class="info-sub">
                                    {{ $order->city }} ({{ $order->postal_code }})
                                </p>
                            </div>

                            <div class="info-block">
                                <h4>Alamat Lengkap</h4>
                                <p class="info-sub">
                                    {{ $order->address }}
                                </p>
                            </div>
                        </div>

                        {{-- KANAN: daftar produk --}}
                        <div class="order-items">
                            <h4>Detail Produk</h4>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->transactionDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->product->name ?? '-' }}</td>
                                            <td>{{ $detail->qty }}</td>
                                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="order-totals">
                                <div>
                                    <span>Ongkir</span>
                                    <strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                                </div>
                                <div>
                                    <span>Pajak</span>
                                    <strong>Rp {{ number_format($order->tax, 0, ',', '.') }}</strong>
                                </div>
                                <div class="grand-total">
                                    <span>Grand Total</span>
                                    <strong>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FORM UPDATE RESI + STATUS --}}
                    <div class="order-card-footer">
                        <form
                            action="{{ route('seller.orders.update', $order->id) }}"
                            method="POST"
                            class="order-update-form"
                        >
                            @csrf
                            @method('PUT')

                            <div class="form-inline-group">
                                <div class="field">
                                    <label>No. Resi Pengiriman</label>
                                    <input
                                        type="text"
                                        name="tracking_number"
                                        value="{{ old('tracking_number', $order->tracking_number) }}"
                                        placeholder="Masukkan nomor resi (contoh: JNE123456789)"
                                    >
                                </div>

                                <div class="field">
                                    <label>Status Pembayaran</label>
                                    <select name="payment_status">
                                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>
                                            Belum Dibayar
                                        </option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>
                                            Sudah Dibayar
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn-update-order">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="orders-pagination">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
