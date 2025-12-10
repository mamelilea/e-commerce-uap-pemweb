@extends('layouts.seller')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <!-- Back Button -->
    <a href="{{ route('seller.balance.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-6">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Saldo
    </a>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tarik Saldo</h1>
        <p class="text-gray-600 mt-2">Ajukan penarikan saldo ke rekening bank Anda</p>
    </div>

    <!-- Current Balance Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-blue-600 mb-1">Saldo Tersedia</p>
                <p class="text-3xl font-bold text-blue-700">{{ $storeBalance->formatted_balance }}</p>
            </div>
            <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Withdrawal Form -->
    <div class="bg-white rounded-lg shadow-sm p-8">
        <form method="POST" action="{{ route('seller.balance.withdrawal.process') }}">
            @csrf

            <!-- Amount -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Penarikan</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                    <input type="number"
                        name="amount"
                        value="{{ old('amount') }}"
                        placeholder="0"
                        min="10000"
                        max="{{ $storeBalance->balance }}"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg font-semibold"
                        required>
                </div>
                <p class="text-sm text-gray-500 mt-2">Minimum penarikan: Rp 10.000</p>
                @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quick Amount Buttons -->
            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-700 mb-3">Pilih Cepat:</p>
                <div class="grid grid-cols-4 gap-2">
                    @php
                    $quickAmounts = [50000, 100000, 500000, $storeBalance->balance];
                    @endphp
                    @foreach($quickAmounts as $quickAmount)
                    <button type="button"
                        onclick="document.querySelector('input[name=amount]').value = '{{ $quickAmount }}'"
                        class="px-4 py-2 bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg text-sm font-semibold transition">
                        {{ $quickAmount == $storeBalance->balance ? 'Semua' : 'Rp ' . number_format($quickAmount / 1000, 0) . 'K' }}
                    </button>
                    @endforeach
                </div>
            </div>

            <hr class="my-6">

            <!-- Bank Information -->
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Rekening Bank</h3>

            <!-- Bank Name -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bank</label>
                <select name="bank_name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                    <option value="">Pilih Bank</option>
                    <option value="BCA" {{ old('bank_name') == 'BCA' ? 'selected' : '' }}>BCA</option>
                    <option value="BNI" {{ old('bank_name') == 'BNI' ? 'selected' : '' }}>BNI</option>
                    <option value="BRI" {{ old('bank_name') == 'BRI' ? 'selected' : '' }}>BRI</option>
                    <option value="Mandiri" {{ old('bank_name') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                    <option value="CIMB Niaga" {{ old('bank_name') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                    <option value="Permata" {{ old('bank_name') == 'Permata' ? 'selected' : '' }}>Permata</option>
                    <option value="BTN" {{ old('bank_name') == 'BTN' ? 'selected' : '' }}>BTN</option>
                    <option value="Danamon" {{ old('bank_name') == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                    <option value="Other" {{ old('bank_name') == 'Other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('bank_name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Account Number -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Rekening</label>
                <input type="text"
                    name="account_number"
                    value="{{ old('account_number') }}"
                    placeholder="1234567890"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                @error('account_number')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Account Holder Name -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemilik Rekening</label>
                <input type="text"
                    name="account_holder"
                    value="{{ old('account_holder', auth()->user()->name) }}"
                    placeholder="Sesuai rekening bank"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                @error('account_holder')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Box -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-yellow-800">
                        <p class="font-semibold mb-1">Perhatian:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Proses penarikan membutuhkan waktu 1-3 hari kerja</li>
                            <li>Pastikan informasi rekening bank sudah benar</li>
                            <li>Nama pemilik rekening harus sesuai dengan identitas Anda</li>
                            <li>Penarikan tidak dapat dibatalkan setelah diajukan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                    Ajukan Penarikan
                </button>
                <a href="{{ route('seller.balance.index') }}"
                    class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection