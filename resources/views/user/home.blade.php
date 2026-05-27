@extends('layouts.user')

@section('title', 'Glovix.Co - Beranda')

@push('styles')
<style>
    @media (max-width: 767px) {
        .hero-section { padding:2rem 1.5rem; border-radius:14px; }
        .hero-section h1 { font-size:1.6rem !important; margin-bottom:.75rem !important; }
        .hero-section .lead { font-size:.88rem !important; margin-bottom:.5rem !important; }
        .hero-section hr { margin:.85rem 0 !important; }
        .hero-section p.mb-4 { font-size:.82rem !important; margin-bottom:1rem !important; }
        .btn-hero { padding:.55rem 1.3rem; font-size:.84rem; }
        .btn-hero-outline { padding:.55rem 1.1rem; font-size:.84rem; }
        .hero-stats { gap:1.25rem; margin-top:1.5rem; padding-top:1.25rem; }
        .hero-stat-num { font-size:1.2rem; }

        .feature-col {
            width:50% !important; flex:0 0 50% !important; max-width:50% !important;
            padding-left:5px !important; padding-right:5px !important; margin-bottom:10px !important;
        }
        .feature-row { margin-left:-5px !important; margin-right:-5px !important; }
        .feature-card { border-radius:12px; }
        .feature-card-header { padding:1rem .9rem .85rem !important; gap:.6rem !important; }
        .feature-card-header .feat-icon { width:42px !important; height:42px !important; border-radius:10px !important; }
        .feature-card-header .feat-icon i { font-size:1rem !important; }
        .feature-card-header .feat-title { font-size:.88rem !important; }
        .feature-card-body { padding:.75rem .9rem 1rem !important; }
        .feature-card-body p {
            font-size:.78rem !important; line-height:1.5 !important; margin-bottom:.65rem !important;
            display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;
        }
        .feature-card-body .btn { font-size:.74rem !important; padding:.35rem .85rem !important; border-radius:20px !important; }

        .info-card .card-body { padding:1.25rem !important; }
        .info-card .card-title { font-size:1.1rem !important; margin-bottom:.85rem !important; }
        .info-card .card-text { font-size:.82rem !important; line-height:1.65 !important; margin-bottom:.65rem !important; }
        .info-card .list-unstyled li { font-size:.82rem !important; margin-bottom:.4rem !important; }
        .info-card .list-unstyled { margin-left:.5rem !important; }

        .step-card { padding:1.2rem; }
    }
    /* ── Hero ──────────────────────────────── */
    .hero-section {
            background: linear-gradient(135deg, #0A3323 0%, #105666 55%, #0A3323 100%);
            border-radius: 20px; padding: 3.5rem;
            position: relative; overflow: hidden;
            box-shadow: 0 8px 40px rgba(10,51,35,.25);
        }
        .hero-section::before {
            content:''; position:absolute; top:-60px; right:-60px;
            width:320px; height:320px; background:rgba(255,255,255,.07); border-radius:50%;
        }
        .hero-section::after {
            content:''; position:absolute; bottom:-40px; left:-40px;
            width:220px; height:220px; background:rgba(255,255,255,.04); border-radius:50%;
        }
        .btn-hero {
            background:#fff; color:#0A3323 !important; font-weight:700;
            border-radius:10px; padding:.7rem 1.8rem; border:none;
            transition:all .25s; font-family:'Plus Jakarta Sans',sans-serif;
            display:inline-flex; align-items:center; gap:.5rem;
        }
        .btn-hero:hover { background:#EEF2E3; box-shadow:0 6px 20px rgba(0,0,0,.15); transform:translateY(-1px); }
        .btn-hero-outline {
            background: transparent; color: rgba(255,255,255,.85) !important;
            font-weight: 600; border-radius: 10px; padding: .7rem 1.6rem;
            border: 1.5px solid rgba(255,255,255,.35); transition: all .25s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display:inline-flex; align-items:center; gap:.5rem;
        }
        .btn-hero-outline:hover { background:rgba(255,255,255,.1); color:#fff !important; border-color:rgba(255,255,255,.6); }
    /* ── Section title ──────────────────────── */
    .section-title { font-family:'DM Serif Display',serif !important; color:#0A3323 !important; }
    .section-title .accent { color:#105666 !important; }

    /* ── Feature cards (desktop) ─────────────── */
    .feature-card {
        background: var(--bg-white);
        border: 1px solid var(--border-soft);
        border-radius: 16px;
        overflow: hidden;
        transition: all .3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .feature-card:hover {
        border-color: var(--border);
        box-shadow: 0 8px 32px rgba(16,86,102,.12);
        transform: translateY(-4px);
    }

    /* Colored icon header */
    .feature-card-header {
        padding: 1.25rem 1.25rem .9rem;
        display: flex;
        align-items: center;
        gap: .75rem;
        border-radius: 0;
    }
    .feature-card-header .feat-icon {
        width: 44px; height: 44px;
        border-radius: 10px;
        background: rgba(255,255,255,.22);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .feature-card-header .feat-icon i { color: #fff !important; font-size: 1.1rem; }
    .feature-card-header .feat-title { color: #fff !important; font-weight: 700; font-size: .95rem; line-height: 1.2; }

    /* Color variants */
    .feat-color-1 { background: linear-gradient(135deg, #0A3323, #105666); }
    .feat-color-2 { background: linear-gradient(135deg, #105666, #2a7d4f); }
    .feat-color-3 { background: linear-gradient(135deg, #2a7d4f, #839958); }
    .feat-color-4 { background: linear-gradient(135deg, #839958, #B8705E); }

    /* Card body */
    .feature-card-body {
        padding: .9rem 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .feature-card-body p {
        color: var(--text-secondary) !important;
        font-size: .85rem;
        line-height: 1.55;
        flex: 1;
        margin-bottom: .75rem;
    }
    .feature-card-body .btn {
        align-self: flex-start;
    }


    /* ── Progress card ──────────────────────── */
    .progress-card {
        background:#fff;
        border:1px solid #D4CFA0;
        border-radius:16px;
        box-shadow:0 2px 12px rgba(0,0,0,.06);
    }
    .progress-card .card-header {
        background:linear-gradient(135deg,#0A3323,#0A3323) !important;
        border-radius:15px 15px 0 0 !important;
        color:#fff !important;
    }
    .progress-card .card-header h5 { color:#fff !important; font-family:'Plus Jakarta Sans',sans-serif !important; font-weight:600 !important; }
    .progress-bar { background:linear-gradient(90deg, #105666, #839958) !important; }

    /* ── Info card ──────────────────────────── */
    .info-card {
        background:#fff; border:1px solid #D4CFA0;
        border-radius:16px; transition:all .3s ease;
    }
    .info-card:hover { box-shadow:0 8px 24px rgba(0,0,0,.08); }

    /* ── Badges ─────────────────────────────── */
    .badge-level {
        background:linear-gradient(135deg,#EEF2E3,#DDE5C8);
        color:#0A3323; padding:.4rem 1rem;
        border-radius:8px; font-weight:700;
        border:1px solid #DDE5C8;
    }
    .wallet-amount { color:#0A3323 !important; font-family:'DM Serif Display',serif !important; }

    /* ── Check icons ────────────────────────── */
    .check-icon { color:#105666 !important; }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Hero Section -->
        <div class="hero-section text-white mb-4">
            <div style="position: relative; z-index: 1;">
                <h1 class="display-4 fw-bold mb-3" style="font-family:'DM Serif Display',serif;color:#fff!important;">Selamat Datang di LMS Edukasi Saham</h1>
                <p class="lead mb-3" style="color:rgba(255,255,255,.8)!important;">Platform pembelajaran investasi saham, cryptocurrency, dan logam mulia terlengkap di Indonesia</p>
                <hr class="my-4 bg-white opacity-25">
                <p class="mb-4" style="color:rgba(255,255,255,.7)!important;">Mulai perjalanan investasi Anda dengan edukasi yang tepat!</p>
                <a class="btn btn-hero btn-lg px-4" href="{{ route('education.index') }}" role="button">
                    <i class="fas fa-play me-2"></i>Mulai Belajar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Fitur-fitur -->
<div class="row mb-5">
    <div class="col-12 mb-3">
        <h2 class="fw-bold" style="color: #0A3323;">
            <span style="color:#105666;">Fitur</span> Unggulan
        </h2>
    </div>

    <div class="col-12">
        <div class="row feature-row g-0">

            <!-- Berita -->
            <div class="col-md-3 col-6 feature-col mb-3 px-2">
                <div class="feature-card">
                    <div class="feature-card-header feat-color-1">
                        <div class="feat-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <span class="feat-title">Berita Terkini</span>
                    </div>
                    <div class="feature-card-body">
                        <p>Update berita pasar saham setiap hari dari berbagai sumber terpercaya</p>
                        <a href="{{ route('news.index') }}" class="btn btn-outline-success btn-sm">Lihat Berita</a>
                    </div>
                </div>
            </div>

            <!-- Grafik -->
            <div class="col-md-3 col-6 feature-col mb-3 px-2">
                <div class="feature-card">
                    <div class="feature-card-header feat-color-2">
                        <div class="feat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="feat-title">Grafik Real-Time</span>
                    </div>
                    <div class="feature-card-body">
                        <p>Pantau pergerakan harga saham dan crypto secara real-time</p>
                        <a href="{{ route('charts.index') }}" class="btn btn-outline-success btn-sm">Lihat Grafik</a>
                    </div>
                </div>
            </div>

            <!-- Edukasi -->
            <div class="col-md-3 col-6 feature-col mb-3 px-2">
                <div class="feature-card">
                    <div class="feature-card-header feat-color-3">
                        <div class="feat-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <span class="feat-title">Video Edukasi</span>
                    </div>
                    <div class="feature-card-body">
                        <p>Pelajari investasi dari pemula hingga profesional dengan sistem level</p>
                        <a href="{{ route('education.index') }}" class="btn btn-outline-success btn-sm">Mulai Belajar</a>
                    </div>
                </div>
            </div>

            <!-- Trading -->
            <div class="col-md-3 col-6 feature-col mb-3 px-2">
                <div class="feature-card">
                    <div class="feature-card-header feat-color-4">
                        <div class="feat-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <span class="feat-title">Trading</span>
                    </div>
                    <div class="feature-card-body">
                        <p>Beli dan jual saham, crypto, dan logam mulia dengan mudah</p>
                        <a href="{{ route('purchase.index') }}" class="btn btn-outline-success btn-sm">Mulai Trading</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Progress User -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card progress-card">
            <div class="card-header text-white py-3">
                <h5 class="mb-0 fw-bold" style="color:#fff!important;font-family:'Plus Jakarta Sans',sans-serif!important;"><i class="fas fa-trophy me-2"></i>Progress Belajar Anda</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h6 class="text-muted mb-2">Level Saat Ini:</h6>
                        <h4 class="mb-3">
                            <span class="badge badge-level">{{ Auth::user()->level->name ?? 'Pemula' }}</span>
                        </h4>
                        <p class="text-muted mb-3">Total EXP: <strong>{{ Auth::user()->total_exp }}</strong></p>
                        
                        @if(Auth::user()->level)
                            @php
                                $progress = ((Auth::user()->total_exp - Auth::user()->level->min_exp) / (Auth::user()->level->max_exp - Auth::user()->level->min_exp)) * 100;
                            @endphp
                            <div class="progress" style="height: 30px; border-radius: 10px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: {{ $progress }}%; font-weight: 600;">
                                    {{ number_format($progress, 1) }}%
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-star text-warning me-1"></i>
                                {{ Auth::user()->level->max_exp - Auth::user()->total_exp }} EXP lagi untuk naik level
                            </small>
                        @endif
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Saldo Wallet:</h6>
                        <h3 class="fw-bold mb-3 wallet-amount">
                            Rp {{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}
                        </h3>
                        <a href="{{ route('purchase.index') }}" class="btn btn-success rounded-pill px-4">
                            <i class="fas fa-plus me-2"></i>Top Up Saldo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tujuan Platform -->
<div class="row">
    <div class="col-12">
        <div class="card info-card">
            <div class="card-body p-4">
                <h3 class="card-title fw-bold mb-4" style="color: #0A3323;">
                    <i class="fas fa-bullseye me-2" class="check-icon"></i>
                    Tujuan Platform
                </h3>
                <p class="card-text text-muted mb-3" style="line-height: 1.8;">
                    LMS Edukasi Saham adalah platform pembelajaran investasi yang dirancang untuk membantu investor pemula hingga profesional 
                    memahami dunia investasi saham, cryptocurrency, dan logam mulia. Dengan sistem pembelajaran bertingkat, Anda akan:
                </p>
                <ul class="list-unstyled ms-3">
                    <li class="mb-2">
                        <i class="fas fa-check-circle me-2" class="check-icon"></i>
                        <span class="text-muted">Memahami dasar investasi dengan benar</span>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle me-2" class="check-icon"></i>
                        <span class="text-muted">Belajar analisis teknikal dan fundamental</span>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle me-2" class="check-icon"></i>
                        <span class="text-muted">Mengelola risiko investasi dengan bijak</span>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle me-2" class="check-icon"></i>
                        <span class="text-muted">Praktik trading dengan sistem yang aman</span>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle me-2" class="check-icon"></i>
                        <span class="text-muted">Mendapatkan update berita pasar terkini</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection