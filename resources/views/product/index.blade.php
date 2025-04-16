@extends('main')
@section('title', 'All Product')
@section('breadcrumb', 'Product')
@section('page-title', 'Product')

@section('content')
    <div class="container m-4 mr-">
        @if (auth()->check() && auth()->user()->role === 'admin')
            <div class="d-flex justify-content-between align-items-center mb-">
                <div>
                    <a class="btn btn-primary" href="{{ route('product.create') }}">Tambah Product</a>
                </div>
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">foto Produk</th>
                    <th scope="col" class="text-center">Nama Product</th>
                    <th scope="col" class="text-center">Harga</th>
                    <th scope="col" class="text-center">Stok</th>
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <th scope="col" class="text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <@php
                    $no = 1;
                @endphp @foreach ($products as $product)
                    <tr>
                        <th scope="row" class="text-center">{{ $no++ }}</th>
                        <td class="text-center w-25">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid w-50">
                        </td>
                        <td class="text-center">{{ $product->name }}</td>
                        <td class="text-center">Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $product->stock }}</td>
                        @if (auth()->check() && auth()->user()->role === 'admin')
                            <td class="text-center">
                                <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                                    <a
                                        href="
                        {{ route('product.edit', $product->id) }}
                        "><button
                                            type="button" class="btn btn-warning">Edit</button></a>
                                    <button class="btn btn-primary btn-update-stock" data-bs-toggle="modal"
                                        data-bs-target="#updateStockModal" data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" data-stock="{{ $product->stock }}">
                                        Update Stok
                                    </button>

                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                Menampilkan {{ $products->firstItem() }} hingga {{ $products->lastItem() }} dari {{ $products->total() }}
                entri
            </div>
            <div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        {{-- <div class="mt-4 flex justify-center "> --}}
                        {{ $products->links() }}
                        {{-- </div> --}}
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Update Stok -->
    <div class="modal fade" id="updateStockModal" tabindex="-1" aria-labelledby="updateStockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStockModalLabel">Update Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateStockForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="product_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok Baru</label>
                            <input type="number" class="form-control" name="stock" id="stock" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("updateStockModal");
            const form = document.getElementById("updateStockForm");

            const modalInstance = new bootstrap.Modal(modal);

            document.querySelectorAll(".btn-update-stock").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const stock = this.dataset.stock;

                    document.getElementById("product_id").value = id;
                    document.getElementById("product_name").value = name;
                    document.getElementById("stock").value = stock;

                    form.action = `/product/${id}/edit-stock`;

                    modalInstance.show();
                });
            });
        });
    </script>

@endsection
