@extends('main')
@section('title', 'Update User')
@section('breadcrumb', 'Update User')
@section('page-title', 'Update User')

@section('content')
<div class="container">
    <div class="card shadow-sm p-4 rounded-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" value="{{ $user->email }}" class="form-control" id="email" name="email" placeholder="Masukkan Email" autocomplete="off">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" value="{{ $user->name }}" class="form-control" id="name" name="name" placeholder="Masukkan Nama">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                    <select value="{{ $user->role }}" class="form-select form-control" id="role" name="role">
                        <option selected disabled>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" autocomplete="off">
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-3 w-25 rounded-5">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    const roleSelect = document.getElementById('role');

    // Log saat halaman dimuat (default value)
    console.log("Default role:", roleSelect.value);

    // Log setiap kali user ganti nilai
    roleSelect.addEventListener('change', function() {
        console.log("Selected role:", this.value);
    });
</script>
@endsection
