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
                        @foreach ($products as $product)
                            <!-- Contoh item keranjang -->
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

                <!-- Bagian kanan: Form untuk member status dan total bayar -->
                <div class="col-md-6">
                    <form id='orderForm' method="POST">
                        @csrf
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
                            <input type="number" class="form-control" id="phoneNumber" name="phoneNumber"
                                placeholder="Masukkan nomor telepon">
                        </div>
                        <div class="mb-3">
                            <label for="totalBayar" class="form-label">Total Bayar</label>
                            <input type="text" class="form-control" id="totalBayar" name="total_bayar"
                                placeholder="Masukkan jumlah pembayaran">
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const memberStatus = document.getElementById('memberStatus');
        const orderForm = document.getElementById('orderForm');
        const phoneInput = document.getElementById('phoneInput');
    
        memberStatus.addEventListener('change', function () {
            console.log(this.value);
            if (this.value === 'member') {
                phoneInput.classList.remove('d-none');
                orderForm.action = "{{ route('order.checkMember') }}";
                orderForm.method = "GET";
                orderForm.removeAttribute("onsubmit");
            } else if (this.value === 'non-member') {
                phoneInput.classList.add('d-none');
                document.getElementById('phoneNumber').value = '';
                orderForm.action = "{{ route('order.store') }}";
                orderForm.method = "POST";
    
                // Tambahkan CSRF token jika method-nya POST (karena GET tidak butuh)
                if (!document.querySelector('#orderForm input[name="_token"]')) {
                    const csrfInput = document.createElement("input");
                    csrfInput.type = "hidden";
                    csrfInput.name = "_token";
                    csrfInput.value = "{{ csrf_token() }}";
                    orderForm.appendChild(csrfInput);
                }
            }
        });
    </script>
    
@endsection
