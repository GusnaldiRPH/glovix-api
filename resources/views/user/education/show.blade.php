@extends('layouts.user')

@section('title', $video->title)

@push('styles')
<style>
    .video-detail-card {
        border: 2px solid #D4CFA0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        background: #FDFBF0;
    }
    
    .video-header {
        background: linear-gradient(135deg, #105666, #0A3323);
        padding: 2rem;
        border-bottom: 4px solid #0A3323;
    }
    
    .video-title {
        color: white;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .level-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.4rem 1rem;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        display: inline-block;
    }
    
    .video-player-wrapper {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }
    
    .video-info-box {
        background: linear-gradient(135deg, #EEF2E3, #F7F4D5);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid rgba(16,86,102,.2);
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 1rem;
        background: #FDFBF0;
        border-radius: 10px;
        border: 1px solid #D4CFA0;
    }
    
    .info-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #105666, #0A3323);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .completed-alert {
        background: linear-gradient(135deg, #EEF2E3, #F7F4D5);
        border-left: 4px solid #105666;
        border-radius: 12px;
        padding: 1.5rem;
        color: #0A3323;
    }
    
    .complete-button {
        background: linear-gradient(135deg, #105666, #0A3323);
        border: none;
        border-radius: 12px;
        padding: 1.2rem;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16,86,102,.3);
    }
    
    .complete-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16,86,102,.4);
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
                <li class="breadcrumb-item"><a href="{{ route('education.index') }}" style="color: #105666;">Edukasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($video->title, 50) }}</li>
            </ol>
        </nav>

        <div class="card video-detail-card">
            <!-- Video Header -->
            <div class="video-header">
                <h2 class="video-title">{{ $video->title }}</h2>
                <span class="level-badge">
                    <i class="fas fa-layer-group me-2"></i>Level: {{ $video->level->name }}
                </span>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <!-- Video Player -->
                <div class="video-player-wrapper mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="{{ str_replace(['watch?v=', 'youtu.be/'], ['embed/', 'www.youtube.com/embed/'], $video->embed_url) }}" 
                                allowfullscreen 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                        </iframe>
                    </div>
                </div>
                
                <!-- Video Description -->
                <div class="mb-4">
                    <h4 class="fw-bold mb-3" style="color: #0A3323;">
                        <i class="fas fa-align-left me-2" style="color: #105666;"></i>Deskripsi
                    </h4>
                    <p class="text-muted" style="font-size: 1.05rem; line-height: 1.8;">
                        {{ $video->description }}
                    </p>
                </div>
                
                <!-- Video Info -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Durasi Video</small>
                                <strong style="color: #0A3323;">{{ $video->duration ?? 0 }} menit</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <div class="info-icon" style="background: linear-gradient(135deg, #D3968C, #B8705E);">
                                <i class="fas fa-star fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Reward EXP</small>
                                <strong style="color: #0A3323;">+{{ $video->exp_reward }} EXP</strong>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Completion Status -->
                @if($userProgress && $userProgress->is_completed)
                <div class="completed-alert">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: #105666; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle fa-2x text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Video Selesai!</h5>
                            <p class="mb-0">Anda sudah menyelesaikan video ini pada {{ $userProgress->completed_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
                @else
                <form action="{{ route('education.complete', $video->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn complete-button w-100 text-white">
                        <i class="fas fa-check-circle me-2"></i>Tandai Selesai & Dapatkan +{{ $video->exp_reward }} EXP
                    </button>
                </form>
                @endif
            </div>
            
            <div class="card-footer">
                <a href="{{ route('education.index') }}" class="btn back-button">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Video
                </a>
            </div>
        </div>
    </div>
</div>
@endsection