@extends('main')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    @if (auth()->check() && auth()->user()->role === 'admin')
        <div class="container mt-5">
            <h1 class="text-center mb-4">Selamat Datang, Administrator!</h1>

            <div class="row">
                <!-- Bar Chart -->
                {{-- <div class="col-md-8">
                    <div class="card p-4 shadow-sm">
                        <h5 class="text-center">Jumlah Penjualan</h5>
                        <canvas id="bar"></canvas>
                    </div>
                </div> --}}

                <!-- Pie Chart + Legend -->
                <div class="col-md-5">
                    <div class="card p-4 shadow-sm">
                        <h5 class="text-center">Persentase Penjualan Produk</h5>
                        <canvas id="pieChart"></canvas>
                        <div id="legend" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const penjualanLabels = @json($penjualanPerProduk->pluck('name'));
            const penjualanData = @json($penjualanPerProduk->pluck('total'));
            


            const ctxBar = document.getElementById('bar')?.getContext('2d');
            if (ctxBar) {
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: penjualanLabels,
                        datasets: [{
                            label: 'Jumlah Penjualan',
                            data: penjualanData,
                            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#ff6384', '#36a2eb', '#ffce56']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            const ctxPie = document.getElementById('pieChart')?.getContext('2d');
            if (ctxPie) {
                new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: penjualanLabels,
                        datasets: [{
                            data: penjualanData,
                            backgroundColor: ['#f6c23e', '#e74a3b', '#36b9cc', '#4e73df', '#1cc88a', '#ff9f40']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        </script>
    @endif

    @if (auth()->check() && auth()->user()->role === 'staff')
        <div class="container mt-5">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4 class="mb-3">Selamat Datang, Petugas!</h4>
                    <div class="card bg-light p-4">
                        <h6 class="text-muted">Total Penjualan Hari Ini</h6>
                        <h2 class="fw-bold">{{ $totalOrdersToday }}</h2>
                        <p class="text-muted">Jumlah total penjualan yang terjadi hari ini.</p>
                        <p class="text-muted small">
                            Tidak ada transaksi hari ini
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif





@endsection
