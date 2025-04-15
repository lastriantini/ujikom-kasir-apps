@extends('main')
@section('title', 'Pembelian')
@section('breadcrumb', 'Tambah Transaksi')
@section('page-title', 'Tambah Transaksi')

@section('content')
    <div class="container mt-4">
        <div class="row g-4">
            <!-- Contoh produk statis -->
            @foreach ($products as $product)
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card h-100 text-center p-2">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top mx-auto"
                            style="width: 12vw; height: 25vwpx; " alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 1.5vw">{{ $product->name }}</h5>
                            <p class="text-muted">Stok: <span id="stock-1">{{ $product->stock }}</span></p>
                            <h6 class="fw-bold">Rp. {{ number_format($product->price, 0, ',', '.') }}</h6>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-decrease"
                                    data-id="{{ $product->id }}">-</button>
                                <span class="mx-3 qty" id="qty-{{ $product->id }}">0</span>
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-increase"
                                    data-id="{{ $product->id }}" data-stock="{{ $product->stock }}"
                                    data-price="{{ $product->price }}">+</button>
                            </div>
                            <p class="mt-3">Sub Total: <span class="fw-bold subtotal"
                                    id="subtotal-{{ $product->id }}">Rp. 0</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- Tambahkan produk lainnya sesuai kebutuhan -->
        </div>

        <div class="text-center mt-4">
            <form action="
        {{ route('order.review') }}
         " method="POST" id="cartForm">
                @csrf
                <input type="hidden" name="cart_data" id="cartData">
                <button type="submit" class="btn btn-primary">Selanjutnya</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-increase, .btn-decrease').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    const productId = this.getAttribute('data-id');
                    const qtyElement = document.getElementById(`qty-${productId}`);
                    const subtotalElement = document.getElementById(`subtotal-${productId}`);
                    const currentQty = parseInt(qtyElement.innerText);
                    const price = parseInt(this.getAttribute('data-price'));
                    const stock = parseInt(this.getAttribute('data-stock'));

                    let newQty;
                    if (this.classList.contains('btn-increase')) {
                        newQty = Math.min(currentQty + 1, stock);
                    } else {
                        newQty = Math.max(currentQty - 1, 0);
                    }

                    qtyElement.innerText = newQty;
                    subtotalElement.innerText = `Rp. ${(newQty * price).toLocaleString('id-ID')}`;
                });
            });

            document.getElementById('cartForm').addEventListener('submit', function (event) {
                const cartData = {};

                document.querySelectorAll('.qty').forEach(qtyElement => {
                    const productId = qtyElement.id.split('-')[1];
                    const quantity = parseInt(qtyElement.innerText);

                    if (quantity > 0) {
                        cartData[productId] = quantity;
                    }
                });

                document.getElementById('cartData').value = JSON.stringify(cartData);
            });
        });
    </script>
@endsection
