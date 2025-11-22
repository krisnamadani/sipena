@extends('layouts.app')

@section('title', 'Data Akun Belanja')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2">Data Akun Belanja</h1>
            <div>
                @if (auth()->user()->isSuperAdmin())
                    <a href="{{ route('akun-belanja.import.form') }}" class="btn btn-success">
                        📥 Import Excel
                    </a>
                    <a href="{{ route('akun-belanja.create') }}" class="btn btn-primary">
                        + Tambah Akun Belanja
                    </a>
                @endif
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($akunBelanjas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Kode</th>
                                    <th width="40%">Nama</th>
                                    <th width="20%">Tanggal Input</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($akunBelanjas as $index => $akun)
                                    <tr>
                                        <td>{{ $akunBelanjas->firstItem() + $index }}</td>
                                        <td><strong>{{ $akun->kode }}</strong></td>
                                        <td>{{ $akun->nama }}</td>
                                        <td>{{ $akun->created_at->format('d M Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @if (auth()->user()->isSuperAdmin())
                                                    <a href="{{ route('akun-belanja.show', $akun) }}"
                                                        class="btn btn-sm btn-info" title="Lihat">
                                                        👁️
                                                    </a>
                                                    <a href="{{ route('akun-belanja.edit', $akun) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        ✏️
                                                    </a>
                                                    <form action="{{ route('akun-belanja.destroy', $akun) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                            🗑️
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $akunBelanjas->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted mb-3">Belum ada data akun belanja.</p>
                        <a href="{{ route('akun-belanja.create') }}" class="btn btn-primary">
                            Tambah Data Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
