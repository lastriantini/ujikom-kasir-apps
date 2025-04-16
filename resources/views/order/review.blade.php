@extends('main')
@section('title', 'Member Page')
@section('breadcrumb', 'Member')
@section('page-title', 'Member')

@section('content')
    <div class="container mt-4">
        <div class="card p-4">
            <div class="row">
                <div class="col-md-6 ">
                    <h4 class="fw-semibold">Produk yang dipilih</h4>
                    <ul class="list-unstyled">
                        @php $jsonOrders = []; @endphp
                        @foreach ($products as $product)
                            @php
                                $subtotal = $cartData[$product->id] * $product->price;
                                $jsonOrders[] = [
                                    'id' => $product->id,
                                    'quantity' => $cartData[$product->id],
                                    'subtotal' => $subtotal,
                                ];
                            @endphp
                            <li class="d-flex justify-content-between mt-2">
                                <div>
                                    <span class="fw-semibold">{{ $product->name }}</span><br>
                                    <small class="text-muted">Rp. {{ number_format($product->price, 0, ',', '.') }} x
                                        {{ $cartData[$product->id] }}</small>
                                </div>
                                <span class="fw-semibold">Rp. {{ $cartData[$product->id] * $product->price }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>Rp. {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <div class="col-md-6">
                    <form id="orderForm" method="POST" action="{{ route('order.store') }}">
                        @csrf

                        <input type="hidden" name="orders" value='@json($jsonOrders)'>
                        <input type="hidden" name="grand_total" value={{$total}}>

                        <div class="mb-3">
                            <label for="memberStatus" class="form-label">Member Status</label>
                            <select class="form-select" id="memberStatus" name="member">
                                {{-- <option selected disabled>Pilih Tipe</option> --}}
                                <option value="non-member" selected>Bukan Member</option>
                                <option value="member">Member</option>
                            </select>
                        </div>

                        <div class="mb-3 d-none" id="phoneInput">
                            <label for="phoneNumber" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phone"
                                placeholder="Masukkan nomor telepon">
                        </div>

                        <div class="mb-3">
                            <label for="totalBayar" class="form-label">Total Bayar</label>
                            <input type="number" class="form-control" id="totalBayar" name="total_payment"
                                min={{ $total }}>
                        </div>

                        <input type="hidden" name="cart_data" id="cartDataInput">

                        <button class="btn btn-primary w-100" type="submit">Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const memberStatus = document.getElementById('memberStatus');
            const phoneInput = document.getElementById('phoneInput');
            const form = document.getElementById('orderForm');
            const cartDataInput = document.getElementById('cartDataInput');
    
            function updateCartDataInput() {
                let data = [];
    
                @foreach ($products as $product)
                    data.push({
                        id: {{ $product->id }},
                        name: "{{ $product->name }}",
                        price: {{ $product->price }},
                        quantity: {{ $cartData[$product->id] }},
                        subtotal: {{ $cartData[$product->id] * $product->price }}
                    });
                @endforeach
    
                cartDataInput.value = JSON.stringify(data);
            }
    
            memberStatus.addEventListener('change', function () {
                const selected = this.value;
    
                if (selected === 'member') {
                    phoneInput.classList.remove('d-none');
                    form.action = "{{ route('order.checkMember') }}";
                    form.method = "GET";
                } else if (selected === 'non-member') {
                    phoneInput.classList.add('d-none');
                    document.getElementById('phoneNumber').value = '';
                    form.action = "{{ route('order.store') }}";
                    form.method = "POST";
                }
    
                updateCartDataInput();
            });
    
            updateCartDataInput(); // Initial update
        });
    </script>    
@endsection
