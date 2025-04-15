@extends('main')
@section('title', 'User - My Website')
@section('breadcrumb', 'User')
@section('page-title', 'User')

@section('content')
<div class="container">
    <div class="d-flex justify-content-end align-items-center mb-4">
        <a class="btn btn-primary" href="{{ route('user.create') }}">Tambah User</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Email</th>
                <th class="text-center">Role</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($users as $user)
            <tr>
                <th class="text-center">{{ $no++ }}</th>
                <td class="text-center">{{ $user->name }}</td>
                <td class="text-center">{{ $user->email }}</td>
                <td class="text-center">{{ $user->role }}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="
                        {{ route('user.edit', $user->id) }}
                            " class="btn btn-warning">Edit</a>
                        <form action="
                        {{ route('user.destroy', $user->id) }}"
                          method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 flex justify-center ">
        {{ $users->links() }}
    </div>
</div>
@endsection
