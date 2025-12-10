<nav class="bg-white border-b border-gray-200 mb-6 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-3">
            <div class="flex items-center gap-2">
                <a
                    href="{{ route('seller.dashboard') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            @php
                $links = [
                    ['label' => 'Dashboard', 'route' => 'seller.dashboard'],
                    ['label' => 'Produk', 'route' => 'seller.products.index'],
                    ['label' => 'Kategori', 'route' => 'seller.categories.index'],
                    ['label' => 'Pesanan', 'route' => 'seller.orders.index'],
                    ['label' => 'Saldo', 'route' => 'seller.balance.index'],
                    ['label' => 'Penarikan', 'route' => 'seller.withdrawals.index'],
                    ['label' => 'Profil Toko', 'route' => 'seller.profile.edit'],
                ];
            @endphp

            <div class="flex flex-wrap gap-2">
                @foreach ($links as $link)
                    @php
                        $isActive = request()->routeIs($link['route']) || request()->routeIs($link['route'].'*');
                    @endphp
                    <a
                        href="{{ route($link['route']) }}"
                        @class([
                            'px-4 py-2 text-sm font-semibold rounded-lg border transition-colors duration-150',
                            'bg-indigo-600 text-white border-indigo-600 shadow-sm' => $isActive,
                            'text-gray-700 bg-white border-gray-200 hover:bg-gray-50' => ! $isActive,
                        ])
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</nav>