@extends('layouts.app')

@section('title', 'Import Akun Belanja')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="h2">Import Akun Belanja dari Excel</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('akun-belanja.index') }}">Akun Belanja</a></li>
                    <li class="breadcrumb-item active">Import</li>
                </ol>
            </nav>
        </div>

        @if (session('error_detail'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>⚠️ Detail Error:</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <div class="mt-2">
                    {!! session('error_detail') !!}
                </div>
                @if (session('failures') && session('failures')->count() > 5)
                    <small class="d-block mt-2">
                        ... dan {{ session('failures')->count() - 5 }} error lainnya
                    </small>
                @endif
            </div>
        @endif

        @if (session('failures') && !session('error_detail'))
            <div class="alert alert-warning alert-dismissible fade show">
                <strong>⚠️ Terdapat Error pada Baris Berikut:</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="mt-2 mb-0">
                    @foreach (session('failures')->take(10) as $failure)
                        <li>
                            Baris {{ $failure->row() }}:
                            @foreach ($failure->errors() as $error)
                                {{ $error }}
                            @endforeach
                        </li>
                    @endforeach
                    @if (session('failures')->count() > 10)
                        <li>... dan {{ session('failures')->count() - 10 }} error lainnya</li>
                    @endif
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">📥 Upload File Excel</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('akun-belanja.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="alert alert-info">
                                <strong>ℹ️ Format File Excel:</strong>
                                <ul class="mb-0 mt-2">
                                    <li><strong>Header baris pertama:</strong> kode, nama, deskripsi (huruf kecil)</li>
                                    <li><strong>Kolom kode:</strong> Kode akun belanja (wajib, maksimal 20 karakter)</li>
                                    <li><strong>Kolom nama:</strong> Nama akun belanja (wajib)</li>
                                    <li><strong>Kolom deskripsi:</strong> Deskripsi (opsional, boleh kosong)</li>
                                    <li>Data duplikat (kode yang sudah ada) akan dilewati</li>
                                    <li>Baris kosong akan dilewati otomatis</li>
                                </ul>
                            </div>

                            <div class="mb-4">
                                <label for="file" class="form-label">Pilih File Excel <span
                                        class="text-danger">*</span></label>
                                <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv"
                                    style="position: relative; z-index: 999999;" />
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Format: XLSX, XLS, atau CSV | Ukuran maksimal: 2MB
                                </small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    📥 Import Data
                                </button>
                                <a href="{{ route('akun-belanja.index') }}" class="btn btn-secondary">
                                    ← Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">📋 Contoh Format Excel yang Benar</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>kode</th>
                                        <th>nama</th>
                                        <th>deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>511111</td>
                                        <td>Belanja Gaji Pokok</td>
                                        <td>Belanja gaji pokok pegawai</td>
                                    </tr>
                                    <tr>
                                        <td>511121</td>
                                        <td>Belanja Tunjangan Keluarga</td>
                                        <td>Tunjangan keluarga pegawai</td>
                                    </tr>
                                    <tr>
                                        <td>521111</td>
                                        <td>Belanja Keperluan Perkantoran</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="alert alert-warning mt-3 mb-0">
                            <strong>⚠️ PENTING:</strong>
                            <ul class="mb-0 mt-1">
                                <li>Header harus <strong>huruf kecil semua</strong>: kode, nama, deskripsi</li>
                                <li>Header harus di <strong>baris pertama</strong></li>
                                <li>Jangan ada spasi di nama header</li>
                                <li>Kolom kode dan nama <strong>tidak boleh kosong</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">📌 Panduan Import</h6>
                        <ol class="small mb-0">
                            <li>Download template Excel terlebih dahulu</li>
                            <li>Isi data sesuai format yang ditentukan</li>
                            <li><strong>Pastikan header: kode, nama, deskripsi (huruf kecil)</strong></li>
                            <li>Simpan file dalam format .xlsx atau .xls</li>
                            <li>Upload file yang sudah diisi</li>
                            <li>Sistem akan melewati data duplikat dan baris kosong</li>
                        </ol>
                    </div>
                </div>

                <div class="card mt-3 border-danger">
                    <div class="card-body">
                        <h6 class="card-title text-danger">🚨 Kesalahan Umum</h6>
                        <ul class="small mb-0">
                            <li>Header menggunakan huruf kapital (KODE, NAMA)</li>
                            <li>Ada spasi di header (kode , nama)</li>
                            <li>Kolom kode atau nama kosong</li>
                            <li>Format file bukan Excel/CSV</li>
                            <li>Data duplikat (kode sudah ada di database)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
