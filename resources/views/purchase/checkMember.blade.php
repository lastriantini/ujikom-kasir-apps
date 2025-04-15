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
                            <!-- Contoh data produk -->
                            <tr>
                                <td>Contoh Produk A</td>
                                <td>2</td>
                                <td>Rp. 10.000</td>
                                <td>Rp. 20.000</td>
                            </tr>
                            <tr>
                                <td>Contoh Produk B</td>
                                <td>1</td>
                                <td>Rp. 15.000</td>
                                <td>Rp. 15.000</td>
                            </tr>
                        </tbody>
                    </table>
                    <h5 class="fw-bold">Total Harga: <span class="float-end">Rp. 35.000</span></h5>
                    <h5 class="fw-bold">Total Bayar: <span class="float-end">Rp. 35.000</span></h5>
                </div>
            </div>
        </div>

        <!-- Bagian Member -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nama Member (identitas)</label>
                            <input type="text" class="form-control" value="John Doe" name="name" placeholder="Masukkan nama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Poin</label>
                            <input type="text" class="form-control" value="100" name="poinMember" readonly>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="gunakanPoin" name="checkPoin">
                            <label class="form-check-label" for="gunakanPoin">Gunakan poin</label>
                        </div>
                        <input type="hidden" name="phone_number" value="08123456789">
                        <input type="hidden" name="total_bayar" value="35000">
                        <button class="btn btn-primary">Selanjutnya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
