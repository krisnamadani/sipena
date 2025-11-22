@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="h2">Detail User</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen User</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi User</h5>
                        <div>
                            @if ($user->id !== 1)
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                    ✏️ Edit
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>ID:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $user->id }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Nama:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $user->name }}
                                @if ($user->id === auth()->id())
                                    <span class="badge bg-info">You</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Email:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Role:</strong>
                            </div>
                            <div class="col-md-9">
                                @if ($user->isSuperAdmin())
                                    <span class="badge bg-danger">Superadmin</span>
                                    <small class="text-muted d-block mt-1">Akses penuh ke semua fitur termasuk manajemen
                                        user</small>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                    <small class="text-muted d-block mt-1">Akses ke fitur akun belanja dan validasi</small>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Terdaftar pada:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $user->created_at->format('d M Y H:i:s') }}
                                <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Terakhir diubah:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $user->updated_at->format('d M Y H:i:s') }}
                                <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                ← Kembali ke Daftar
                            </a>
                            @if ($user->id !== 1)
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                                    ✏️ Edit Data
                                </a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                @if ($user->isSuperAdmin())
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h6 class="card-title">🔒 Akun Superadmin</h6>
                            <p class="small mb-0">
                                Akun ini adalah Superadmin dan tidak dapat diedit atau dihapus dari halaman ini untuk
                                keamanan sistem.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
