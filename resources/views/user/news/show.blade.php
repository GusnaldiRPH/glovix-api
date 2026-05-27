@extends('layouts.user')

@section('title', $newsItem->title)

@push('styles')
<style>
    .news-detail-card {
        border: 2px solid #D4CFA0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        background: #FDFBF0;
    }
    
    .news-detail-card .card-img-top {
        max-height: 400px;
        object-fit: cover;
        width: 100%;
    }
    
    .news-header {
        border-bottom: 3px solid #105666;
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .news-title {
        color: #0A3323;
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 1rem;
    }
    
    .news-meta {
        background: linear-gradient(135deg, #EEF2E3, #F7F4D5);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        display: inline-flex;
        gap: 1.5rem;
        border: 1px solid rgba(16,86,102,.2);
    }
    
    .news-meta-item {
        color: #0A3323;
        font-weight: 600;
    }
    
    .news-meta-item i {
        color: #105666;
        margin-right: 0.5rem;
    }
    
    .news-content {
        color: #3D5243;
        font-size: 1.1rem;
        line-height: 1.8;
    }
    
    .news-content p {
        margin-bottom: 1.5rem;
    }
    
    .back-button {
        background: #FDFBF0;
        border: 2px solid #105666;
        color: #105666;
        border-radius: 10px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .back-button:hover {
        background: linear-gradient(135deg, #105666, #0A3323);
        color: white;
        border-color: #105666;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16,86,102,.3);
    }
    
    .card-footer {
        background: #F7F4D5;
        border-top: 2px solid #D4CFA0;
        padding: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color:#105666;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news.index') }}" style="color: #105666;">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($newsItem->title, 50) }}</li>
            </ol>
        </nav>

        <div class="card news-detail-card">
            @if($newsItem->image)
            <img src="{{ Storage::url($newsItem->image) }}" class="card-img-top" alt="{{ $newsItem->title }}">
            @endif
            
            <div class="card-body p-4 p-md-5">
                <div class="news-header">
                    <h1 class="news-title">{{ $newsItem->title }}</h1>
                    
                    <div class="news-meta">
                        <span class="news-meta-item">
                            <i class="fas fa-user"></i>{{ $newsItem->author->name }}
                        </span>
                        <span class="news-meta-item">
                            <i class="fas fa-calendar"></i>{{ $newsItem->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
                
                <div class="news-content">
                    {!! nl2br(e($newsItem->content)) !!}
                </div>
            </div>
            
            <div class="card-footer">
                <a href="{{ route('news.index') }}" class="btn back-button">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Berita
                </a>
            </div>
        </div>
    </div>
</div>
@endsection