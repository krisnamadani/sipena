@extends('layouts.app')

@section('title', 'Tambah Akun Belanja')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="h2">Tambah Akun Belanja</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('akun-belanja.index') }}">Akun Belanja</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Tambah Akun Belanja</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('akun-belanja.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode Akun <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" name="kode" value="{{ old('kode') }}" placeholder="Contoh: 511111"
                                    required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Maksimal 20 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Akun <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}"
                                    placeholder="Contoh: Belanja Gaji Pokok" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                                    placeholder="Deskripsi tambahan (opsional)">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    💾 Simpan
                                </button>
                                <a href="{{ route('akun-belanja.index') }}" class="btn btn-secondary">
                                    ← Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">📌 Panduan</h6>
                        <ul class="small mb-0">
                            <li>Kode akun harus unik</li>
                            <li>Gunakan format kode yang konsisten</li>
                            <li>Nama akun harus jelas dan deskriptif</li>
                            <li>Field bertanda (*) wajib diisi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
