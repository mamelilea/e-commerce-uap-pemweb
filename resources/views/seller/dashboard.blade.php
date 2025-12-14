<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- 1. Stats Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Penjualan -->
                <div class="bg-[#161616] rounded-2xl p-6 shadow-sm border border-white/10 relative overflow-hidden group hover:shadow-[0_0_30px_rgba(34,197,94,0.15)] hover:border-green-500/30 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-green-500/10 rounded-full blur-3xl group-hover:bg-green-500/20 transition-all duration-500"></div>
                    
                    <div class="flex justify-between items-start z-10 relative">
                        <div>
                            <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Total Pendapatan</p>
                            <h3 class="text-3xl font-black text-[#EDEDEC] tracking-tight">
                                Rp {{ number_format($totalSales, 0, ',', '.') }}
                            </h3>
                            <div class="mt-2 flex items-center text-sm">
                                <span class="text-green-400 bg-green-500/10 px-2 py-0.5 rounded-full font-bold flex items-center border border-green-500/20 animate-pulse">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    +12.5%
                                </span>
                                <span class="text-gray-400 ml-2">vs bulan lalu</span>
                            </div>
                        </div>
                        <div class="p-3 bg-green-500/10 rounded-xl text-green-400 group-hover:bg-green-500 group-hover:text-white transition-all duration-500 group-hover:scale-110 group-hover:rotate-12 shadow-[0_0_15px_rgba(34,197,94,0)] group-hover:shadow-[0_0_20px_rgba(34,197,94,0.4)]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Total Pesanan -->
                <div class="bg-[#161616] rounded-2xl p-6 shadow-sm border border-white/10 relative overflow-hidden group hover:shadow-[0_0_30px_rgba(249,115,22,0.15)] hover:border-orange-500/30 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl group-hover:bg-orange-500/20 transition-all duration-500"></div>

                    <div class="flex justify-between items-start z-10 relative">
                        <div>
                            <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Total Pesanan</p>
                            <h3 class="text-3xl font-black text-[#EDEDEC] tracking-tight">
                                {{ $totalOrders }}
                            </h3>
                            <div class="mt-2 text-sm text-gray-500">
                                <a href="{{ route('seller.orders.index') }}" class="text-gray-400 hover:text-white font-semibold inline-flex items-center transition-colors group/link">
                                    <span class="group-hover/link:underline">Lihat Semua Pesanan</span>
                                    <svg class="w-3 h-3 ml-1 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                        <div class="p-3 bg-orange-500/10 rounded-xl text-orange-400 group-hover:bg-orange-500 group-hover:text-white transition-all duration-500 group-hover:scale-110 group-hover:rotate-12 shadow-[0_0_15px_rgba(249,115,22,0)] group-hover:shadow-[0_0_20px_rgba(249,115,22,0.4)]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Total Produk -->
                <div class="bg-[#161616] rounded-2xl p-6 shadow-sm border border-white/10 relative overflow-hidden group hover:shadow-[0_0_30px_rgba(99,102,241,0.15)] hover:border-indigo-500/30 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all duration-500"></div>

                    <div class="flex justify-between items-start z-10 relative">
                        <div>
                            <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Produk Aktif</p>
                            <h3 class="text-3xl font-black text-[#EDEDEC] tracking-tight">
                                {{ $totalProducts }}
                            </h3>
                             <div class="mt-2 text-sm text-gray-500">
                                <a href="{{ route('seller.products.index') }}" class="text-gray-400 hover:text-white font-semibold inline-flex items-center transition-colors group/link">
                                    <span class="group-hover/link:underline">Kelola Produk</span>
                                    <svg class="w-3 h-3 ml-1 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                        <div class="p-3 bg-indigo-500/10 rounded-xl text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-500 group-hover:scale-110 group-hover:rotate-12 shadow-[0_0_15px_rgba(99,102,241,0)] group-hover:shadow-[0_0_20px_rgba(99,102,241,0.4)]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Chart & Command Center Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Chart Section (Spans 2 columns) -->
                <div class="lg:col-span-2 bg-[#161616] p-6 rounded-2xl shadow-sm border border-white/10">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-[#EDEDEC]">Analitik Penjualan</h3>
                        <div class="flex gap-2">
                             <span class="text-xs font-medium px-3 py-1 bg-gray-100 rounded-full text-gray-600">Tahun Ini</span>
                        </div>
                    </div>
                    <div class="relative h-72 w-full">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Command Center (Side Widget) -->
                <div class="bg-[#161616] p-6 rounded-2xl shadow-sm border border-white/10 flex flex-col h-full">
                    <h3 class="text-lg font-bold text-[#EDEDEC] mb-6">Aksi Cepat</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('seller.products.create') }}" class="relative overflow-hidden flex flex-col items-center justify-center p-4 bg-[#0a0a0a] border border-white/10 rounded-xl hover:border-indigo-500/50 hover:bg-white/5 transition-all duration-300 group shadow-lg hover:shadow-indigo-500/10">
                            <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                            <div class="w-12 h-12 bg-[#161616] rounded-full flex items-center justify-center text-indigo-400 shadow-inner border border-white/5 mb-2 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-300 group-hover:text-white transition-colors">Tambah Produk</span>
                        </a>

                        <a href="{{ route('seller.orders.index') }}" class="relative overflow-hidden flex flex-col items-center justify-center p-4 bg-[#0a0a0a] border border-white/10 rounded-xl hover:border-orange-500/50 hover:bg-white/5 transition-all duration-300 group shadow-lg hover:shadow-orange-500/10">
                            <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-orange-500 to-red-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                             <div class="w-12 h-12 bg-[#161616] rounded-full flex items-center justify-center text-orange-400 shadow-inner border border-white/5 mb-2 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-300 group-hover:text-white transition-colors">Cek Pesanan</span>
                        </a>

                        <a href="{{ route('seller.store.manage') }}" class="relative overflow-hidden flex flex-col items-center justify-center p-4 bg-[#0a0a0a] border border-white/10 rounded-xl hover:border-gray-500/50 hover:bg-white/5 transition-all duration-300 group shadow-lg hover:shadow-white/5 col-span-2">
                             <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-gray-500 to-white transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                             <div class="w-12 h-12 bg-[#161616] rounded-full flex items-center justify-center text-gray-400 shadow-inner border border-white/5 mb-2 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-300 group-hover:text-white transition-colors">Pengaturan Toko</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3. Recent Orders Table -->
            <div class="bg-[#161616] rounded-2xl shadow-sm border border-white/10 overflow-hidden">
                <div class="p-6 border-b border-white/10 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-[#EDEDEC]">Pesanan Terbaru</h3>
                    <a href="{{ route('seller.orders.index') }}" class="text-sm text-indigo-400 font-semibold hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0a0a0a]">
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">No. Pesanan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-[#EDEDEC]">#{{ $order->code ?? $order->id }}</span>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500 mr-3">
                                                {{ substr($order->buyer?->user?->name ?? 'User', 0, 1) }}
                                            </div>
                                            <div class="text-sm font-bold text-[#EDEDEC]">{{ $order->buyer?->user?->name ?? 'Guest User' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500 line-clamp-1 max-w-[200px]">
                                            @foreach($order->transactionDetails as $detail)
                                                {{ $detail->product->name }} (x{{ $detail->qty }})@if(!$loop->last), @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[#EDEDEC]">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($order->payment_status === 'paid')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                Lunas
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                        Belum ada pesanan masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Gradient Data
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)'); // Indigo
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: gradient,
                        borderColor: '#4f46e5',
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4f46e5',
                        pointHoverBackgroundColor: '#4f46e5',
                        pointHoverBorderColor: '#ffffff',
                        fill: true,
                        tension: 0.4 // Curves the line
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            titleFont: { size: 13 },
                            bodyFont: { size: 12 },
                            cornerRadius: 8,
                            displayColors: false,
                             callbacks: {
                                label: function(context) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [4, 4],
                                color: '#f3f4f6'
                            },
                             ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value/1000000) + 'jt';
                                },
                                font: { size: 11 }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        });
    </script>
</x-seller-layout>
