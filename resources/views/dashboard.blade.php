@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <h1 class="h2 mb-4">Dashboard</h1>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Akun Belanja</h5>
                        <h2 class="display-4">{{ $totalAkunBelanja }}</h2>
                        <p class="card-text">Akun terdaftar</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <h2 class="display-4">{{ $totalUsers }}</h2>
                        <p class="card-text">Pengguna sistem</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Quick Actions</h5>
                        @if (auth()->user()->isSuperAdmin())
                            <a href="{{ route('akun-belanja.create') }}" class="btn btn-light btn-sm mb-2 d-block">
                                + Tambah Akun Belanja
                            </a>
                        @endif
                        <a href="{{ route('validasi.index') }}" class="btn btn-light btn-sm d-block">
                            📄 Validasi PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Akun Belanja Terbaru</h5>
            </div>
            <div class="card-body">
                @if ($recentAkunBelanja->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Ditambahkan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentAkunBelanja as $akun)
                                    <tr>
                                        <td><strong>{{ $akun->kode }}</strong></td>
                                        <td>{{ $akun->nama }}</td>
                                        <td>{{ $akun->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('akun-belanja.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua Akun Belanja
                    </a>
                @else
                    <p class="text-muted">Belum ada data akun belanja.</p>
                    <a href="{{ route('akun-belanja.create') }}" class="btn btn-primary btn-sm">
                        Tambah Akun Belanja Pertama
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
