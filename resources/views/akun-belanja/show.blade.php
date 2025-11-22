@extends('layouts.app')

@section('title', 'Detail Akun Belanja')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="h2">Detail Akun Belanja</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('akun-belanja.index') }}">Akun Belanja</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi Akun Belanja</h5>
                        <div>
                            <a href="{{ route('akun-belanja.edit', $akunBelanja) }}" class="btn btn-sm btn-warning">
                                ✏️ Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Kode Akun:</strong>
                            </div>
                            <div class="col-md-9">
                                <span class="badge bg-primary fs-6">{{ $akunBelanja->kode }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Nama Akun:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $akunBelanja->nama }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Deskripsi:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $akunBelanja->deskripsi ?? '-' }}
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Dibuat pada:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $akunBelanja->created_at->format('d M Y H:i:s') }}
                                <small class="text-muted">({{ $akunBelanja->created_at->diffForHumans() }})</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Terakhir diubah:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $akunBelanja->updated_at->format('d M Y H:i:s') }}
                                <small class="text-muted">({{ $akunBelanja->updated_at->diffForHumans() }})</small>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('akun-belanja.index') }}" class="btn btn-secondary">
                                ← Kembali ke Daftar
                            </a>
                            <a href="{{ route('akun-belanja.edit', $akunBelanja) }}" class="btn btn-warning">
                                ✏️ Edit Data
                            </a>
                            <form action="{{ route('akun-belanja.destroy', $akunBelanja) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
