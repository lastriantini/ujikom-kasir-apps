@extends('main')
@section('title', 'Result Member Page')
@section('breadcrumb', 'Member')
@section('page-title', 'Member')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('order.pdf', $order->id) }}" class="btn btn-primary">
            Unduh Bukti
        </a>
        <button class="btn btn-secondary">
            <a href="{{ route('order.index') }}" class="text-white text-decoration-none">Kembali</a>
        </button>
    </div>

    <div class="card p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold">Invoice - #{{$order->id}}</h5>
            <span class="text-muted">{{$order->created_at }}</span>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody> 
                @foreach ($detailOrders as $detailOrder)
                <tr>
                    <td>{{ $detailOrder->product->name }}</td>
                    <td>Rp. {{ number_format($detailOrder->product->price, 0, ',', '.') }}</td>
                    <td>{{ $detailOrder->quantity }}</td>
                    <td>Rp. {{ number_format($detailOrder->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row mt-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td>Poin Digunakan</td>
                        <td class="text-end">{{ $order->poin ?? '0' }}</td>
                    </tr>
                    <tr>
                        <td>Kasir</td>
                        <td class="text-end fw-bold">{{ $order->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td class="text-end text-success fw-bold">Rp. {{ number_format($order->total_return, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <div class="bg-dark text-white p-3 text-center rounded">
                    <h5 class="m-0 text-white">TOTAL PRICE</h5>
                    <h3 class="fw-bold text-white" id="total_prices">Rp. Rp. {{ number_format($order->total_price, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
