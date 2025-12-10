@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.stores.verify') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Toko
        </a>
    </div>

    <!-- Store Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Logo -->
            <div class="w-32 h-32 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                @if($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $store->name }}</h1>
                        <p class="text-gray-600 mt-1">Terdaftar {{ $store->created_at->diffForHumans() }}</p>
                    </div>

                    <!-- Status Badge -->
                    @if($store->isPending())
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">
                        Pending Verifikasi
                    </span>
                    @elseif($store->isVerified())
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        Terverifikasi
                    </span>
                    @elseif($store->isRejected())
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                        Ditolak
                    </span>
                    @endif
                </div>

                <!-- About -->
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Tentang Toko</h3>
                    <p class="text-gray-600">{{ $store->about }}</p>
                </div>

                <!-- Quick Actions -->
                @if($store->isPending())
                <div class="flex gap-3">
                    <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Yakin ingin menyetujui toko ini?')"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Setujui Toko
                        </button>
                    </form>
                    <button onclick="openRejectModal({{ $store->id }}, '{{ $store->name }}')"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tolak Toko
                    </button>
                </div>
                @elseif($store->isVerified() || $store->isRejected())
                <form action="{{ route('admin.stores.reset', $store->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('Reset status toko ke pending?')"
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Status
                    </button>
                </form>
                @endif
            </div>
        </div>

        <!-- Rejection Reason (if rejected) -->
        @if($store->isRejected())
        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <h4 class="font-semibold text-red-900 mb-1">Alasan Penolakan</h4>
                    <p class="text-red-800">{{ $store->rejection_reason }}</p>
                    @if($store->verifier)
                    <p class="text-sm text-red-700 mt-2">Ditolak oleh: {{ $store->verifier->name }} pada {{ $store->verified_at->format('d M Y H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Verification Info (if verified) -->
        @if($store->isVerified() && $store->verifier)
        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <h4 class="font-semibold text-green-900 mb-1">Informasi Verifikasi</h4>
                    <p class="text-green-800">Diverifikasi oleh: {{ $store->verifier->name }}</p>
                    <p class="text-sm text-green-700 mt-1">Pada: {{ $store->verified_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Store Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Kontak</h2>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Telepon</p>
                        <p class="font-semibold text-gray-800">{{ $store->phone }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Kota</p>
                        <p class="font-semibold text-gray-800">{{ $store->city }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Alamat Lengkap</p>
                        <p class="font-semibold text-gray-800">{{ $store->address }}</p>
                        <p class="text-sm text-gray-600 mt-1">Kode Pos: {{ $store->postal_code }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Owner Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Pemilik</h2>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                    <span class="text-xl font-bold text-gray-600">{{ substr($store->user->name, 0, 2) }}</span>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-lg">{{ $store->user->name }}</p>
                    <p class="text-gray-600">{{ $store->user->email }}</p>
                    <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold mt-1 inline-block capitalize">
                        {{ $store->user->role }}
                    </span>
                </div>
            </div>
            <div class="pt-4 border-t">
                <p class="text-sm text-gray-600">Terdaftar sejak: {{ $store->user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Products -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Produk Toko ({{ $store->products->count() }})</h2>

        @if($store->products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($store->products->take(8) as $product)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 rounded-lg mb-3 overflow-hidden">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    @endif
                </div>
                <h3 class="font-semibold text-gray-800 text-sm mb-1 truncate">{{ $product->name }}</h3>
                <p class="text-blue-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>

        @if($store->products->count() > 8)
        <p class="text-center text-gray-500 mt-4">Dan {{ $store->products->count() - 8 }} produk lainnya</p>
        @endif
        @else
        <p class="text-center text-gray-500 py-8">Belum ada produk terdaftar</p>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tolak Toko</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <p class="text-sm text-gray-600 mb-4">
                Anda akan menolak toko: <strong id="rejectStoreName" class="text-gray-900"></strong>
            </p>

            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="rejection_reason"
                        name="rejection_reason"
                        rows="4"
                        required
                        minlength="10"
                        maxlength="500"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        placeholder="Jelaskan alasan penolakan toko ini (min. 10 karakter)"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Minimal 10 karakter, maksimal 500 karakter</p>
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button"
                        onclick="closeRejectModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                        Tolak Toko
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openRejectModal(storeId, storeName) {
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectStoreName').textContent = storeName;
        document.getElementById('rejectForm').action = `/admin/stores/${storeId}/reject`;
        document.getElementById('rejection_reason').value = '';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });
</script>
@endpush