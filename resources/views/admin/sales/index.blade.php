@extends('layouts.admin')

@section('page-title', 'Laporan Penjualan')

@push('styles')
<style>
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }
    .stat-card h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .stat-card h5 {
        opacity: 0.85;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>
@endpush

@section('content')

{{-- Total Penjualan --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card stat-card">
            <div class="card-body text-center py-4">
                <h5>Total Penjualan {{ now()->year }}</h5>
                <h1>Rp {{ number_format($totalSales, 0, ',', '.') }}</h1>
            </div>
        </div>
    </div>
</div>

{{-- Grafik Penjualan Bulanan --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Grafik Penjualan Bulanan {{ now()->year }}</h5>
            </div>
            <div class="card-body">
                @if($salesByMonth->isEmpty())
                    <p class="text-center text-muted py-4">Belum ada data penjualan tahun ini.</p>
                @else
                    <canvas id="salesChart" height="80"></canvas>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Tabel Transaksi Terbaru --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Transaksi Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Jumlah</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $trans)
                            <tr>
                                <td>{{ $trans->id }}</td>
                                <td>{{ $trans->user->name ?? '-' }}</td>
                                <td>Rp {{ number_format($trans->amount, 0, ',', '.') }}</td>
                                <td>{{ $trans->description ?? '-' }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($trans->status) {
                                            'completed' => 'success',
                                            'pending'   => 'warning',
                                            'failed'    => 'danger',
                                            default     => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">
                                        {{ ucfirst($trans->status) }}
                                    </span>
                                </td>
                                <td>{{ $trans->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $recentTransactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesData = @json($salesByMonth);

    if (salesData.length > 0) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const data = new Array(12).fill(0);

        salesData.forEach(item => {
            data[item.month - 1] = parseFloat(item.total);
        });

        const ctx = document.getElementById('salesChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: data,
                    backgroundColor: 'rgba(102, 126, 234, 0.6)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endpush