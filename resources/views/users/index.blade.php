@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2">Manajemen User</h1>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                + Tambah User
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Nama</th>
                                    <th width="30%">Email</th>
                                    <th width="15%">Role</th>
                                    <th width="15%">Terdaftar</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->isSuperAdmin())
                                                <span class="badge bg-danger">Superadmin</span>
                                            @else
                                                <span class="badge bg-secondary">User</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            @if ($user->id === 1)
                                            @else
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info"
                                                        title="Lihat">
                                                        👁️
                                                    </a>
                                                    <a href="{{ route('users.edit', $user) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        ✏️
                                                    </a>
                                                    @if ($user->id !== auth()->id())
                                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                title="Hapus">
                                                                🗑️
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted mb-3">Belum ada user lain.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
