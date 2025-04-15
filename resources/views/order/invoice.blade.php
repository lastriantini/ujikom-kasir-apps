@extends('main')
@section('title', 'Result Member Page')
@section('breadcrumb', 'Member')
@section('page-title', 'Member')

@section('content')
<div class="container">
    <div class="mb-4">
        <button class="btn btn-primary">Unduh</button>
        <button class="btn btn-secondary">
            <a href="#" class="text-white text-decoration-none">Kembali</a>
        </button>
    </div>

    <div class="card p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold">Invoice - #INV0001</h5>
            <span class="text-muted">14 Apr 2025</span>
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
                <tr>
                    <td>Contoh Produk A</td>
                    <td>Rp. 10.000</td>
                    <td>2</td>
                    <td>Rp. 20.000</td>
                </tr>
                <tr>
                    <td>Contoh Produk B</td>
                    <td>Rp. 15.000</td>
                    <td>1</td>
                    <td>Rp. 15.000</td>
                </tr>
            </tbody>
        </table>

        <div class="row mt-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td>Poin Digunakan</td>
                        <td class="text-end">0</td>
                    </tr>
                    <tr>
                        <td>Kasir</td>
                        <td class="text-end fw-bold">Admin Toko</td>
                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td class="text-end text-success fw-bold">Rp. 5.000</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <div class="bg-dark text-white p-3 text-center rounded">
                    <h5 class="m-0 text-white">TOTAL PRICE</h5>
                    <h3 class="fw-bold text-white" id="total_prices">Rp. 35.000</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
