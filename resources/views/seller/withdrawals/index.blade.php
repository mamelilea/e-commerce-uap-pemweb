<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Penarikan Dana
            </h2>
        </div>
    </x-slot>
    <x-seller.navbar />

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded">
                    <div class="font-semibold mb-1">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-800 text-sm">
                                Saldo Toko
                            </h3>
                        </div>
                        <div class="px-6 py-5">
                            <div class="text-3xl font-bold text-gray-900">Rp {{ number_format($balance->balance, 0, ',', '.') }}</div>
                            <p class="text-sm text-gray-600 mt-2">Saldo yang tersedia dapat diajukan untuk penarikan.</p>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg mt-6">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-800 text-sm">
                                Ajukan Penarikan
                            </h3>
                        </div>
                        <div class="px-6 py-5">
                            <form action="{{ route('seller.withdrawals.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Jumlah Penarikan (Rp)
                                    </label>
                                    <input type="number" name="amount" min="1" step="0.01"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                           value="{{ old('amount') }}" placeholder="Masukkan jumlah penarikan">
                                </div>

                                <div>
                                      <div class="flex items-center justify-between mb-1">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Pilih Rekening Bank
                                        </label>
                                        <a href="{{ route('seller.profile.edit') }}" class="text-xs text-indigo-600 hover:underline">Kelola rekening</a>
                                    </div>
                                    @if($bankAccounts->isEmpty())
                                        <div class="rounded-md bg-amber-50 border border-amber-200 text-amber-800 p-3 text-xs">
                                            Belum ada rekening bank terdaftar. Tambahkan rekening terlebih dahulu pada halaman profil toko.
                                        </div>
                                    @else
                                        <select name="bank_account_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                            <option value="" disabled {{ old('bank_account_id') ? '' : 'selected' }}>Pilih rekening tujuan</option>
                                            @foreach($bankAccounts as $account)
                                                <option value="{{ $account->id }}" {{ old('bank_account_id') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->bank_name }} - {{ $account->bank_account_number }} ({{ $account->bank_account_name }})
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                        Ajukan Penarikan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-semibold text-gray-800 text-sm">Riwayat Penarikan</h3>
                        </div>
                        <div class="px-4 py-5">
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200 bg-gray-50 text-gray-600 text-xs uppercase tracking-wide">
                                            <th class="px-3 py-2 text-left">Tanggal</th>
                                            <th class="px-3 py-2 text-left">Jumlah</th>
                                            <th class="px-3 py-2 text-left">Rekening</th>
                                            <th class="px-3 py-2 text-left">Bank</th>
                                            <th class="px-3 py-2 text-left">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($withdrawals as $wd)
                                            <tr>
                                                <td class="px-3 py-2 text-gray-700">{{ $wd->created_at->format('d M Y H:i') }}</td>
                                                <td class="px-3 py-2 font-semibold text-gray-900">Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                                                <td class="px-3 py-2 text-gray-700">{{ $wd->bank_account_number }} ({{ $wd->bank_account_name }})</td>
                                                <td class="px-3 py-2 text-gray-700">{{ $wd->bank_name }}</td>
                                                <td class="px-3 py-2">
                                                    <span class="inline-flex px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700 capitalize">
                                                        {{ $wd->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-3 py-4 text-center text-xs text-gray-500">
                                                    Belum ada pengajuan penarikan dana.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>