@extends('main')
@section('title', 'Result Member Page')
@section('breadcrumb', 'Member')
@section('page-title', 'Member')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Bagian Produk -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $jsonOrders = []; @endphp
                            @foreach ($orders as $order)
                                @php
                                    $subtotal = $order['quantity'] * $order['product']->price;
                                    $jsonOrders[] = [
                                        'id' => $order['product']->id,
                                        'quantity' => $order['quantity'],
                                        'subtotal' => $subtotal
                                    ];
                                @endphp
                                <tr>
                                    <td>{{ $order['product']->name }}</td>
                                    <td>{{ $order['quantity'] }}</td>
                                    <td>Rp. {{ number_format($order['product']->price, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h5 class="fw-bold">Total Harga: <span class="float-end">Rp. {{ number_format($subTotal, 0, ',', '.') }}</span></h5>
                    <h5 class="fw-bold">Total Bayar: <span class="float-end">Rp. {{ number_format($totalPayment, 0, ',', '.') }}</span></h5>
                </div>
            </div>
        </div>

        <!-- Bagian Member -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="orders" value='@json($jsonOrders)'>
                        <input type="hidden" name="phone" value="{{ $phone }}">
                        <input type="hidden" name="member" value="{{ $member_status }}">
                        <input type="hidden" name="grand_total" value="{{ $grandTotal }}">
                        <input type="hidden" name="total_payment" value="{{ $totalPayment }}">
                        <input type="hidden" name="usePoint" id="usePoint" value="false">

                        <div class="mb-3">
                            <label class="form-label">Nama Member (identitas)</label>
                            <input type="text" class="form-control" value="{{ $member?->name }}" name="member_name" placeholder="Masukkan nama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Poin</label>
                            <input type="text" class="form-control" value="{{ $member?->poin ?? 0 }}" name="poinMember" readonly>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="gunakanPoin">
                            <label class="form-check-label" for="gunakanPoin">Gunakan poin</label>
                        </div>

                        <button class="btn btn-primary">Selanjutnya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('gunakanPoin').addEventListener('change', function() {
        document.getElementById('usePoint').value = this.checked ? 'true' : 'false';
    });
</script>

@endsection
