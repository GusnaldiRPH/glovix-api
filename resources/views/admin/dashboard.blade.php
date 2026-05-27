@extends('layouts.admin')

@section('page-title', 'Dashboard')

@push('styles')
<style>
    .stats-card {
        border-radius: 16px;
        border: none;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }
    
    .stats-card.green { background: linear-gradient(135deg, #105666, #0A3323); }
    
    .stats-card.emerald { background: linear-gradient(135deg, #0A3323, #105666); }
    
    .stats-card.teal { background: linear-gradient(135deg, #D3968C, #B8705E); }
    
    .stats-card.lime { background: linear-gradient(135deg, #7C3AED, #6D28D9); }
    
    .data-card {
        border-radius: 16px;
        border: 1px solid #D4CFA0;
        transition: all 0.3s ease;
    }
    
    .data-card:hover {
        border-color: #105666;
        box-shadow: 0 8px 20px rgba(45, 145, 89, 0.15);
    }
    
    .data-card .card-header {
        background: linear-gradient(135deg, #105666, #0A3323);
        border-radius: 14px 14px 0 0 !important;
        border: none;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(45,145,89,.04);
    }
    
    .badge-published {
        background: #EEF2E3; color:#0A3323;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight:600;
    }
    
    .badge-draft {
        background: #D4CFA0;
        color: #7A8C6E;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
    }
    
    .badge-level {
        background: #F5DDD9; color:#B8705E;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight:600;
    }
</style>
@endpush

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card green text-white">
            <div class="card-body" style="position: relative; z-index: 1;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 opacity-75">Total Berita</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalNews }}</h2>
                    </div>
                    <i class="fas fa-newspaper fa-3x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stats-card emerald text-white">
            <div class="card-body" style="position: relative; z-index: 1;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 opacity-75">Total Video</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalVideos }}</h2>
                    </div>
                    <i class="fas fa-video fa-3x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stats-card teal text-white">
            <div class="card-body" style="position: relative; z-index: 1;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 opacity-75">Total User</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalUsers }}</h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stats-card lime text-white">
            <div class="card-body" style="position: relative; z-index: 1;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 opacity-75">Total Penjualan</h6>
                        <h5 class="mb-0 fw-bold">Rp {{ number_format($totalSales, 0, ',', '.') }}</h5>
                    </div>
                    <i class="fas fa-dollar-sign fa-3x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent News & Videos -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card data-card h-100">
            <div class="card-header text-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-newspaper me-2"></i>Berita Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr style="border-bottom: 2px solid #D4CFA0;">
                                <th class="fw-semibold">Judul</th>
                                <th class="fw-semibold">Tanggal</th>
                                <th class="fw-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentNews as $news)
                            <tr>
                                <td>{{ Str::limit($news->title, 40) }}</td>
                                <td class="text-muted">{{ $news->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $news->is_published ? 'badge-published' : 'badge-draft' }}">
                                        {{ $news->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block opacity-25"></i>
                                    Belum ada berita
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.news.index') }}" class="btn btn-success rounded-pill px-4 mt-2">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card data-card h-100">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #839958, #105666) !important;">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-video me-2"></i>Video Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr style="border-bottom: 2px solid #D4CFA0;">
                                <th class="fw-semibold">Judul</th>
                                <th class="fw-semibold">Level</th>
                                <th class="fw-semibold">EXP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVideos as $video)
                            <tr>
                                <td>{{ Str::limit($video->title, 40) }}</td>
                                <td>
                                    <span class="badge badge-level">{{ $video->level->name }}</span>
                                </td>
                                <td class="fw-bold" style="color: #105666;">+{{ $video->exp_reward }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block opacity-25"></i>
                                    Belum ada video
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.videos.index') }}" class="btn btn-success rounded-pill px-4 mt-2">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection