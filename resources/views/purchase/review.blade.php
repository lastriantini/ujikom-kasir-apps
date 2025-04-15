@extends('main')
@section('title', 'Member Page')
@section('breadcrumb', 'Member')
@section('page-title', 'Member')

@section('content')
<div class="container mt-4">
    <div class="card p-4">
        <div class="row">
            <!-- Bagian kiri: Produk yang dipilih -->
            <div class="col-md-6 ">
                <h4 class="fw-semibold">Produk yang dipilih</h4>
                <ul class="list-unstyled">
                    <!-- Contoh item keranjang -->
                    <li class="d-flex justify-content-between mt-2">
                        <div>
                            <span class="fw-semibold">Contoh Produk 1</span><br>
                            <small class="text-muted">Rp. 10.000 x 2</small>
                        </div>
                        <span class="fw-semibold">Rp. 20.000</span>
                    </li>
                    <li class="d-flex justify-content-between mt-2">
                        <div>
                            <span class="fw-semibold">Contoh Produk 2</span><br>
                            <small class="text-muted">Rp. 15.000 x 1</small>
                        </div>
                        <span class="fw-semibold">Rp. 15.000</span>
                    </li>
                </ul>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>Rp. 35.000</strong>
                </div>
            </div>

            <!-- Bagian kanan: Form untuk member status dan total bayar -->
            <div class="col-md-6">
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="memberStatus" class="form-label">Member Status</label>
                        <select class="form-select" id="memberStatus" name="member">
                            <option selected disabled>Pilih Tipe</option>
                            <option value="non-member">Bukan Member</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="phoneInput">
                        <label for="phoneNumber" class="form-label">Number Phone</label>
                        <input type="number" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Masukkan nomor telepon">
                    </div>
                    <div class="mb-3">
                        <label for="totalBayar" class="form-label">Total Bayar</label>
                        <input type="text" class="form-control" id="totalBayar" name="total_bayar" placeholder="Masukkan jumlah pembayaran">
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Pesan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('memberStatus').addEventListener('change', function() {
        let phoneInput = document.getElementById('phoneInput')
        if (this.value === 'member') {
            phoneInput.classList.remove('d-none')
        } else {
            phoneInput.classList.add('d-none')
            document.getElementById('phoneNumber').value = ''
        }
    });
</script>
@endsection
