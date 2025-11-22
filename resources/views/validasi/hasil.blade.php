@extends('layouts.app')

@section('title', 'Hasil Validasi')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="h2">📊 Hasil Validasi</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('validasi.index') }}">Validasi</a></li>
                    <li class="breadcrumb-item active">Hasil</li>
                </ol>
            </nav>
        </div>

        @php
            $totalData = count($results);
            $valid = collect($results)->where('keterangan', 'Valid')->count();
            $perluDicek = collect($results)->where('keterangan', 'Perlu Dicek')->count();
            $tidakValid = $totalData - $valid - $perluDicek;
        @endphp

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h6 class="card-title">Total Data</h6>
                        <h2 class="display-4">{{ $totalData }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h6 class="card-title">Valid</h6>
                        <h2 class="display-4">{{ $valid }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h6 class="card-title">Perlu Dicek</h6>
                        <h2 class="display-4">{{ $perluDicek }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h6 class="card-title">Tidak Valid</h6>
                        <h2 class="display-4">{{ $tidakValid }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Hasil Validasi</h5>
                <div>
                    <button onclick="window.print()" class="btn btn-sm btn-secondary">
                        🖨️ Print
                    </button>
                    <a href="{{ route('validasi.index') }}" class="btn btn-sm btn-primary">
                        📄 Validasi Lagi
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">Kode</th>
                                <th width="30%">Nama di PDF</th>
                                <th width="30%">Nama di Database</th>
                                <th width="13%">Status Kode</th>
                                <th width="13%">Status Nama</th>
                                <th width="12%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $index => $result)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $result['kode'] }}</strong></td>
                                    <td>{{ $result['nama_pdf'] }}</td>
                                    <td>
                                        @if ($result['nama_db'])
                                            {{ $result['nama_db'] }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($result['status_kode'] == 'Ditemukan')
                                            <span class="badge bg-success">Ditemukan</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Ditemukan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($result['status_nama'] == 'Sesuai')
                                            <span class="badge bg-success">Sesuai</span>
                                        @elseif(str_contains($result['status_nama'], 'Mirip'))
                                            <span class="badge bg-warning text-dark">{{ $result['status_nama'] }}</span>
                                        @elseif($result['status_nama'] == 'Tidak Sesuai')
                                            <span class="badge bg-danger">Tidak Sesuai</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($result['keterangan'] == 'Valid')
                                            <span class="badge bg-success">✓ Valid</span>
                                        @elseif($result['keterangan'] == 'Perlu Dicek')
                                            <span class="badge bg-warning text-dark">⚠ Perlu Dicek</span>
                                        @else
                                            <span class="badge bg-danger">✗ {{ $result['keterangan'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Tidak ada data yang ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (count($results) > 0)
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <strong>📝 Catatan:</strong>
                            <ul class="mb-0">
                                <li><strong>Valid:</strong> Kode dan nama akun sesuai dengan database</li>
                                <li><strong>Perlu Dicek:</strong> Kode ditemukan tetapi nama mirip (tidak sama persis)</li>
                                <li><strong>Tidak Valid:</strong> Kode tidak terdaftar atau nama tidak sesuai</li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('validasi.index') }}" class="btn btn-primary">
                📄 Validasi PDF Lain
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

    <style>
        @media print {

            .sidebar,
            .navbar,
            .btn,
            .breadcrumb {
                display: none !important;
            }
        }
    </style>
@endsection
