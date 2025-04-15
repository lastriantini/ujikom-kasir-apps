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
            <tr>
                <th class="text-center">1</th>
                <td class="text-center">Budi Santoso</td>
                <td class="text-center">budi@example.com</td>
                <td class="text-center">Admin</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('user.edit')  }}" class="btn btn-warning">Edit</a>
                        <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
