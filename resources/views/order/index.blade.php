@extends('main')
@section('title', 'Penjualan')
@section('breadcrumb', 'Penjualan')
@section('page-title', 'Penjualan')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (auth()->check() && auth()->user()->role === 'admin')
                <div>
                    <button class="btn btn-primary">
                        <a href="{{ route('order.export.excel') }}" class="text-white">Export Penjualan (.xlsx)</a>
                    </button>
                </div>
            @endif
            @if (auth()->check() && auth()->user()->role === 'staff')
                <div class="ml-auto">
                    <a class="btn btn-success" href="{{ route('product.addProduct') }}">Tambah
                        Penjualan</a>
                </div>
            @endif
        </div>

        {{-- <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="dropdown me-2">
                Tampilkan
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    10
                </button>
                Entri
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">10</a></li>
                    <li><a class="dropdown-item" href="#">15</a></li>
                    <li><a class="dropdown-item" href="#">20</a></li>
                </ul>
            </div> --}}
            <div>
                <form action="{{ route('order.index') }}" method="GET" >
                    <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('query') }}">
                </form>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Nama Pelanggan</th>
                    <th scope="col" class="text-center">Tanggal Penjualan</th>
                    <th scope="col" class="text-center">Total Harga</th>
                    <th scope="col" class="text-center">Dibuat Oleh</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row" class="text-center">{{ $no++ }}</th>
                        @if ($order->member)
                            <td class="text-center">{{ $order->member->name }}</td>
                        @else
                            <td class="text-center"> Bukan Member </td>
                        @endif
                        <td class="text-center">{{ $order->created_at }}</td>
                        <td class="text-center">{{ $order->total_price }}</td>
                        <td class="text-center">{{ $order->user->name ?? '' }}</td>

                        <td class="text-center">
                            <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                                <a href="{{ route('order.invoice', $order->id) }}" class="btn btn-warning">
                                    Lihat
                                </a>
                                <a href="{{ route('order.pdf', $order->id) }}" class="btn btn-primary">
                                    Unduh Bukti
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                Menampilkan {{ $orders->firstItem() }} hingga {{ $orders->lastItem() }} dari {{ $orders->total() }} entri
            </div>
            <div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        {{-- <div class="mt-4 flex justify-center "> --}}
                            {{ $orders->links() }}
                        {{-- </div> --}}
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Detail Penjualan -->
    <div class="modal fade" id="modalDetail1" tabindex="-1" aria-labelledby="modalDetailLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel1">Detail Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Member Status : <strong>Member</strong></p>
                        <p>No. HP : 081234567890</p>
                        <p>Poin Member : 10</p>
                        <p>Bergabung Sejak : 01 Januari 2025</p>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Produk A</td>
                                <td>2</td>
                                <td>50000</td>
                                <td>100000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td><strong>100000</strong></td>
                            </tr>
                        </tfoot>
                    </table>

                    <p class="mt-3 text-muted"><small>Dibuat pada : 2025-04-14 10:00:00<br>Oleh : Admin</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
