@extends('store.layouts.app')

@section('title', 'Edit Toko')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(255, 107, 157, 0.15);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .form-header h1 {
        color: #ff6b9d;
        font-size: 32px;
        margin-bottom: 10px;
    }

    .form-header p {
        color: #666;
        font-size: 16px;
    }

    .current-logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .current-logo img {
        width: 120px;
        height: 120px;
        border-radius: 15px;
        object-fit: cover;
        border: 3px solid #fce4ec;
        margin-bottom: 10px;
    }

    .current-logo p {
        color: #666;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        color: #333;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-label .required {
        color: #ff6b9d;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #fce4ec;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #ff6b9d;
        box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .file-upload {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-upload input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border: 2px dashed #ff6b9d;
        border-radius: 10px;
        background: #fff5f8;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-label:hover {
        background: #fce4ec;
        border-color: #ff5089;
    }

    .file-name {
        margin-top: 8px;
        font-size: 13px;
        color: #666;
    }

    .error-message {
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
        display: block;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .button-group {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn {
        flex: 1;
        padding: 15px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ff6b9d, #ff8fb3);
        color: white;
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 157, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #666;
        border: 2px solid #ddd;
    }

    .btn-secondary:hover {
        background: #f8f9fa;
        border-color: #bbb;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 25px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-header h1 {
            font-size: 24px;
        }

        .button-group {
            flex-direction: column;
        }
    }
</style>

<div class="form-card">
    <div class="form-header">
        <h1>⚙️ Edit Informasi Toko</h1>
        <p>Perbarui informasi toko Anda</p>
    </div>

    <div class="current-logo">
        <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}">
        <p>Logo Toko Saat Ini</p>
    </div>

    <form action="{{ route('store.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nama Toko -->
        <div class="form-group">
            <label class="form-label">
                Nama Toko <span class="required">*</span>
            </label>
            <input type="text" 
                   name="name" 
                   class="form-control" 
                   placeholder="Contoh: Toko Elektronik Jaya"
                   value="{{ old('name', $store->name) }}"
                   required>
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Logo Toko -->
        <div class="form-group">
            <label class="form-label">
                Ganti Logo Toko (Opsional)
            </label>
            <div class="file-upload">
                <input type="file" 
                       name="logo" 
                       id="logo" 
                       accept="image/*"
                       onchange="updateFileName(this)">
                <label for="logo" class="file-upload-label">
                    <span style="font-size: 24px;">📸</span>
                    <div>
                        <div style="font-weight: 600; color: #ff6b9d;">Upload Logo Baru</div>
                        <div style="font-size: 12px; color: #666;">Format: JPG, PNG (Max: 2MB)</div>
                    </div>
                </label>
            </div>
            <span class="file-name" id="fileName"></span>
            @error('logo')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Deskripsi Toko -->
        <div class="form-group">
            <label class="form-label">
                Deskripsi Toko <span class="required">*</span>
            </label>
            <textarea name="about" 
                      class="form-control" 
                      placeholder="Ceritakan tentang toko Anda"
                      required>{{ old('about', $store->about) }}</textarea>
            @error('about')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Nomor Telepon & ID Alamat -->
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">
                    Nomor Telepon <span class="required">*</span>
                </label>
                <input type="text" 
                       name="phone" 
                       class="form-control" 
                       placeholder="08123456789"
                       value="{{ old('phone', $store->phone) }}"
                       required>
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    ID Alamat <span class="required">*</span>
                </label>
                <input type="text" 
                       name="address_id" 
                       class="form-control" 
                       placeholder="ADDR001"
                       value="{{ old('address_id', $store->address_id) }}"
                       required>
                @error('address_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Kota & Kode Pos -->
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">
                    Kota <span class="required">*</span>
                </label>
                <input type="text" 
                       name="city" 
                       class="form-control" 
                       placeholder="Contoh: Jakarta"
                       value="{{ old('city', $store->city) }}"
                       required>
                @error('city')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    Kode Pos <span class="required">*</span>
                </label>
                <input type="text" 
                       name="postal_code" 
                       class="form-control" 
                       placeholder="12345"
                       value="{{ old('postal_code', $store->postal_code) }}"
                       required>
                @error('postal_code')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Alamat Lengkap -->
        <div class="form-group">
            <label class="form-label">
                Alamat Lengkap <span class="required">*</span>
            </label>
            <textarea name="address" 
                      class="form-control" 
                      placeholder="Jl. Contoh No. 123"
                      required>{{ old('address', $store->address) }}</textarea>
            @error('address')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Button Group -->
        <div class="button-group">
            <a href="{{ route('store.dashboard') }}" class="btn btn-secondary">
                ✗ Batal
            </a>
            <button type="submit" class="btn btn-primary">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function updateFileName(input) {
        const fileName = document.getElementById('fileName');
        if (input.files && input.files[0]) {
            fileName.textContent = '📁 File dipilih: ' + input.files[0].name;
            fileName.style.color = '#28a745';
        }
    }
</script>
@endsection