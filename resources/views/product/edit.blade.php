@extends('main')
@section('title', 'Edit Produk')
@section('breadcrumb', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
    <div class="container">
        <div class="card shadow-sm p-4 rounded-4">
            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="image" class="form-label">Gambar Produk (Opsional)</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        <div class="mt-2">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}') }}" alt='{{ $product->name }}' 
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <p>Tidak ada gambar yang diunggah</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mt-3 w-25 rounded-5">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
