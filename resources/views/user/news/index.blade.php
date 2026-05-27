@extends('layouts.user')

@section('title', 'Glovix.Co - Berita Pasar Saham')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #105666 0%, #0A3323 100%);
        border-radius: 16px;
        padding: 2rem 2.5rem;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(10,51,35,.2);
    }
    
    .news-card {
        border: 2px solid #D4CFA0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: #FDFBF0;
    }
    
    .news-card:hover {
        border-color: #105666;
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(16,86,102,.2);
    }
    
    .news-card .card-img-top {
        border-radius: 0;
        transition: transform 0.3s ease;
    }
    
    .news-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .news-card .card-title {
        color: #0A3323;
        font-weight: 700;
        line-height: 1.4;
    }
    
    .news-card .card-text {
        color: #7A8C6E;
        line-height: 1.6;
    }
    
    .date-badge {
        background: linear-gradient(135deg, #EEF2E3, #DDE5C8);
        color: #0A3323;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-read-more {
        background: linear-gradient(135deg, #105666, #0A3323);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.3s ease;
    }
    
    .btn-read-more:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16,86,102,.4);
    }
    
    .no-image-placeholder {
        background: linear-gradient(135deg, #EEF2E3, #DDE5C8);
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    
    .no-image-placeholder i {
        color: #105666;
        opacity: 0.4;
    }
    
    .empty-state {
        background: #FDFBF0;
        border: 2px dashed #105666;
        border-radius: 16px;
        padding: 3rem;
        text-align: center;
    }
    
    .empty-state i {
        color: #105666;
        opacity: 0.5;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header text-white">
    <div class="d-flex align-items-center">
        <div class="me-3">
            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-newspaper fa-2x"></i>
            </div>
        </div>
        <div>
            <h2 class="mb-1 fw-bold" style="color: #ffffff !important;">Berita Terkini Pasar Saham</h2>
            <p class="mb-0 opacity-75" style="color: #ffffff !important;">Update berita investasi dan ekonomi terbaru</p>
        </div>
    </div>
</div>

<!-- News Grid -->
<div class="row">
    @forelse($news as $item)
    <div class="col-md-6 mb-4">
        <div class="card news-card h-100">
            @if($item->image)
            <div style="overflow: hidden; height: 200px;">
                <img src="{{ Storage::url($item->image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover; width: 100%;">
            </div>
            @else
            <div class="no-image-placeholder">
                <i class="fas fa-image fa-4x"></i>
            </div>
            @endif
            <div class="card-body p-4">
                <h5 class="card-title mb-3">{{ $item->title }}</h5>
                <p class="card-text mb-4">{{ Str::limit(strip_tags($item->content), 150) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="date-badge">
                        <i class="fas fa-calendar me-1"></i>{{ $item->created_at->format('d M Y') }}
                    </span>
                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-read-more btn-sm text-white">
                        Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="fas fa-newspaper fa-4x mb-3 d-block"></i>
            <h4 class="fw-bold mb-2" style="color: #0A3323;">Belum Ada Berita</h4>
            <p class="text-muted mb-0">Berita terkini akan muncul di sini</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($news->hasPages())
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endif
@endsection