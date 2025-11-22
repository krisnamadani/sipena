@extends('layouts.app')

@section('title', 'Validasi Data PDF')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="h2">Validasi Data PDF</h1>
            <p class="text-muted">Upload file PDF untuk memvalidasi data akun belanja</p>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">📄 Upload File PDF</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('validasi.proses') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="pdf_file" class="form-label">Pilih File PDF <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('pdf_file') is-invalid @enderror"
                                    id="pdf_file" name="pdf_file" accept=".pdf" required>
                                @error('pdf_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Format: PDF | Ukuran maksimal: 10MB
                                </small>
                            </div>

                            <div class="alert alert-info">
                                <strong>ℹ️ Informasi:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Sistem akan mengekstrak data dari tabel pada halaman terakhir PDF</li>
                                    <li>Data yang diambil: Kode Akun dan Nama Akun</li>
                                    <li>Hasil validasi akan membandingkan dengan data di database</li>
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                ✅ Proses Validasi
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                ← Kembali
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">📌 Panduan Validasi</h6>
                        <ol class="small mb-0">
                            <li>Pastikan PDF berisi tabel data akun belanja</li>
                            <li>Tabel harus berada di halaman terakhir PDF</li>
                            <li>Format: Kode (6 digit) dan Nama Akun</li>
                            <li>Sistem akan otomatis mencocokkan dengan database</li>
                        </ol>

                        <hr>

                        <h6 class="card-title">📊 Status Validasi</h6>
                        <div class="small">
                            <span class="badge bg-success">Valid</span> = Kode & Nama sesuai<br>
                            <span class="badge bg-warning text-dark">Perlu Dicek</span> = Nama mirip<br>
                            <span class="badge bg-danger">Tidak Valid</span> = Data tidak sesuai
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title">🔗 Lihat Data</h6>
                        <a href="{{ route('akun-belanja.index') }}" class="btn btn-sm btn-outline-primary d-block">
                            📋 Data Akun Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
