@extends('layouts.user')

@section('title', 'Glovix.Co - Video Edukasi')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    /* ═══ HERO ═══ */
    .edu-hero {
        background: linear-gradient(135deg, #105666 0%, #0A3323 100%);
        border-radius: 16px; padding: 2rem 2.25rem;
        margin-bottom: 1.25rem; position: relative; overflow: hidden;
        box-shadow: 0 4px 20px rgba(10,51,35,.2);
    }
    .edu-hero::before {
        content: ''; position: absolute; right: -40px; top: -40px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,.06); border-radius: 50%;
    }
    .edu-hero::after {
        content: ''; position: absolute; right: 80px; bottom: -60px;
        width: 140px; height: 140px;
        background: rgba(255,255,255,.04); border-radius: 50%;
    }
    .edu-hero-inner { position: relative; z-index: 1; }
    .edu-hero h2 {
        font-family: 'DM Serif Display', serif;
        font-size: 1.7rem; color: #fff !important; /* tambah !important */
        margin: 0 0 .3rem; font-weight: 400;
    }
    .edu-hero p { 
        color: rgba(255,255,255,.7) !important; /* tambah !important */
        margin: 0; font-size: .875rem; 
    }

    /* ═══ TOP BAR ═══ */
    .top-bar {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1.1rem;
    }
    @media (max-width: 600px) {
        .top-bar { grid-template-columns: 1fr; }
    }

    /* Search */
    .search-wrap { position: relative; }
    .search-wrap input {
        width: 100%; padding: .7rem 1.1rem .7rem 2.6rem;
        border: 1.5px solid #D4CFA0; border-radius: 12px;
        font-size: .9rem; background: #fff;
        color: #0A3323; outline: none; transition: .2s;
        font-family: 'Plus Jakarta Sans', sans-serif;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }
    .search-wrap input:focus {
        border-color: #105666;
        box-shadow: 0 0 0 3px rgba(16,86,102,.12);
    }
    .search-wrap input::placeholder { color: #9AAB8A; }
    .search-icon {
        position: absolute; left: .9rem; top: 50%;
        transform: translateY(-50%); color: #9AAB8A; font-size: .85rem;
    }
    .result-label { font-size: .85rem; color: #7A8C6E; white-space: nowrap; }
    .result-label strong { color: #0A3323; font-weight: 700; }

    /* ═══ PROGRESS CARD ═══ */
    .progress-card {
        background: #fff; border: 1px solid #E5E0BC;
        border-radius: 14px; padding: 1.1rem 1.25rem;
        margin-bottom: 1.1rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }
    .progress-card-inner {
        display: flex; align-items: center; gap: 1.25rem;
        flex-wrap: wrap;
    }
    .user-info-block { display: flex; align-items: center; gap: .7rem; flex-shrink: 0; }
    .user-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: #EEF2E3; display: flex;
        align-items: center; justify-content: center; flex-shrink: 0;
    }
    .user-avatar i { color: #0A3323; font-size: .9rem; }
    .user-name  { font-size: .88rem; font-weight: 700; color: #0A3323; }
    .user-level { font-size: .74rem; color: #7A8C6E; }
    .prog-divider { width: 1px; height: 36px; background: #E5E0BC; flex-shrink: 0; }
    @media (max-width: 600px) { .prog-divider { display: none; } }
    .prog-bar-section { flex: 1; min-width: 180px; }
    .prog-bar-label {
        display: flex; justify-content: space-between;
        font-size: .74rem; color: #7A8C6E; margin-bottom: .35rem;
    }
    .prog-bar-label span:last-child { font-weight: 700; color: #105666; }
    .prog-bar-track { height: 8px; border-radius: 99px; background: #EDE9BF; overflow: hidden; }
    .prog-bar-fill  { height: 100%; background: linear-gradient(90deg, #105666, #839958); border-radius: 99px; transition: width .6s ease; }
    .prog-hint { font-size: .72rem; color: #7A8C6E; margin-top: .35rem; }
    .prog-hint i { color: #F59E0B; }
    .stat-pills { display: flex; gap: .5rem; flex-shrink: 0; }
    .stat-pill {
        background: #F7F4D5; border: 1px solid #E5E0BC;
        border-radius: 10px; padding: .45rem .75rem;
        text-align: center; min-width: 58px;
    }
    .stat-pill .snum { font-size: .95rem; font-weight: 700; color: #0A3323; display: block; }
    .stat-pill .slbl { font-size: .65rem; color: #7A8C6E; }

    /* ═══ FILTER CHIPS ═══ */
    .filter-row {
        display: flex; gap: .5rem;
        overflow-x: auto; padding-bottom: .3rem;
        margin-bottom: 1.25rem;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .filter-row::-webkit-scrollbar { display: none; }
    .fchip {
        flex-shrink: 0;
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .42rem 1rem; border-radius: 99px;
        font-size: .82rem; font-weight: 600; cursor: pointer;
        border: 1.5px solid #D4CFA0; background: #fff; color: #3D5243;
        white-space: nowrap; transition: .18s; text-decoration: none;
    }
    .fchip:hover { background: #F7F4D5; border-color: #DDE5C8; color: #0A3323; }
    .fchip.active { background: #EEF2E3; border-color: #105666; color: #0A3323; }
    .fchip-dot { width: 7px; height: 7px; border-radius: 50%; }
    .fchip-count {
        font-size: .7rem; background: rgba(0,0,0,.06);
        padding: .05rem .4rem; border-radius: 99px; color: inherit;
    }
    .fchip.active .fchip-count { background: rgba(16,86,102,.15); }

    /* ═══ LEVEL SECTION ═══ */
    .level-section { margin-bottom: 2.25rem; }
    .level-sec-head {
        display: flex; align-items: center; gap: .65rem;
        margin-bottom: 1rem; padding-bottom: .7rem;
        border-bottom: 1.5px solid #E5E0BC; flex-wrap: wrap;
    }
    .lchip {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .32rem .9rem; border-radius: 99px;
        font-size: .78rem; font-weight: 700;
    }
    .lchip-0 { background: #EEF2E3; color: #0A3323; }
    .lchip-1 { background: #F5DDD9; color: #B8705E; }
    .lchip-2 { background: #EDE9FE; color: #5B21B6; }
    .lchip-3 { background: #FFE4E6; color: #9F1239; }
    .lchip-desc { font-size: .8rem; color: #7A8C6E; margin-left: auto; }

    /* ═══ COURSE GRID ═══ */
    .course-grid {
        display: grid; gap: 1rem;
        grid-template-columns: repeat(2, 1fr);
    }
    @media (min-width: 640px)  { .course-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 900px)  { .course-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (min-width: 1200px) { .course-grid { grid-template-columns: repeat(5, 1fr); } }

    /* ═══ COURSE CARD ═══ */
    .course-card {
        background: #fff; border: 1px solid #E5E0BC;
        border-radius: 12px; overflow: hidden;
        display: flex; flex-direction: column;
        transition: all .22s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }
    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 28px rgba(0,0,0,.1);
        border-color: #DDE5C8;
    }
    .course-thumb {
        height: 115px; position: relative; overflow: hidden;
        flex-shrink: 0; display: flex;
        align-items: center; justify-content: center;
    }
    .course-thumb > i { font-size: 2.4rem; opacity: .28; }
    .thumb-0 { background: linear-gradient(135deg, #EEF2E3, #DDE5C8); }
    .thumb-0 > i { color: #0A3323; }
    .thumb-1 { background: linear-gradient(135deg, #F5DDD9, #EBBBAF); }
    .thumb-1 > i { color: #B8705E; }
    .thumb-2 { background: linear-gradient(135deg, #EDE9FE, #DDD6FE); }
    .thumb-2 > i { color: #7C3AED; }
    .thumb-3 { background: linear-gradient(135deg, #FFE4E6, #FECDD3); }
    .thumb-3 > i { color: #BE123C; }
    .play-overlay {
        position: absolute; inset: 0;
        background: rgba(31,107,64,.1);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: .22s;
    }
    .course-card:hover .play-overlay { opacity: 1; }
    .play-circle {
        width: 40px; height: 40px; border-radius: 50%;
        background: #105666;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 14px rgba(16,86,102,.45);
    }
    .play-circle i { color: #fff; font-size: .85rem; margin-left: 2px; }
    .done-badge {
        position: absolute; top: 8px; right: 8px;
        background: #105666; color: #fff;
        font-size: .62rem; font-weight: 700;
        padding: .22rem .6rem; border-radius: 99px;
        display: flex; align-items: center; gap: .25rem;
        box-shadow: 0 2px 6px rgba(16,86,102,.35);
    }
    .course-body {
        padding: .8rem; flex: 1;
        display: flex; flex-direction: column;
    }
    .c-title {
        font-size: .82rem; font-weight: 700; color: #0A3323;
        line-height: 1.35; margin-bottom: .3rem;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .c-desc {
        font-size: .73rem; color: #7A8C6E; line-height: 1.45;
        margin-bottom: .55rem; flex: 1;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .c-meta { display: flex; flex-wrap: wrap; gap: .3rem; margin-bottom: .65rem; }
    .c-tag {
        font-size: .65rem; font-weight: 600;
        padding: .2rem .5rem; border-radius: 5px;
        display: inline-flex; align-items: center; gap: .2rem;
    }
    .tag-dur { background: #F3F4F6; color: #6B7280; }
    .tag-exp { background: #F5DDD9; color: #B8705E; }
    .btn-cta {
        width: 100%; padding: .52rem;
        border: none; border-radius: 8px;
        font-size: .76rem; font-weight: 700; cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
        display: flex; align-items: center;
        justify-content: center; gap: .35rem;
        text-decoration: none; transition: .2s;
    }
    .btn-cta.go {
        background: linear-gradient(135deg, #105666, #0A3323);
        color: #fff; box-shadow: 0 2px 8px rgba(16,86,102,.22);
    }
    .btn-cta.go:hover { box-shadow: 0 4px 14px rgba(16,86,102,.38); color: #fff; }
    .btn-cta.replay {
        background: #F7F4D5; color: #105666;
        border: 1.5px solid #DDE5C8;
    }
    .btn-cta.replay:hover { background: #EEF2E3; color: #0A3323; }
    .empty-box {
        grid-column: 1 / -1; text-align: center;
        padding: 2rem; background: #F7F4D5;
        border-radius: 10px; font-size: .85rem; color: #9AAB8A;
    }
    .empty-box i { font-size: 1.75rem; display: block; margin-bottom: .6rem; opacity: .4; }
</style>
@endpush

@section('content')
@php
    $dotColors = ['#0A3323','#B8705E','#7C3AED','#BE123C'];
    $totalVideos = $levels->sum(fn($l) => $l->videos->count());
    $completedCount = 0;
    foreach($levels as $l)
        foreach($l->videos as $v)
            if(Auth::user()->progress()->where('video_id',$v->id)->where('is_completed',true)->exists())
                $completedCount++;
    $progressPct = $totalVideos > 0 ? round(($completedCount / $totalVideos) * 100) : 0;
@endphp

<div class="edu-hero">
    <div class="edu-hero-inner">
        <h2><i class="fas fa-graduation-cap me-2" style="font-size:1.3rem;"></i>Video Edukasi</h2>
        <p>{{ $totalVideos }} video tersedia &nbsp;·&nbsp; Tingkatkan pengetahuan investasi Anda</p>
    </div>
</div>

<div class="progress-card">
    <div class="progress-card-inner">
        <div class="user-info-block">
            <div class="user-avatar"><i class="fas fa-user"></i></div>
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-level">{{ $userLevel->name ?? 'Pemula' }}</div>
            </div>
        </div>
        <div class="prog-divider"></div>
        <div class="prog-bar-section">
            <div class="prog-bar-label">
                <span>{{ $completedCount }}/{{ $totalVideos }} video selesai</span>
                <span>{{ $progressPct }}%</span>
            </div>
            <div class="prog-bar-track">
                <div class="prog-bar-fill" style="width:{{ $progressPct }}%"></div>
            </div>
            @if($userLevel)
            <div class="prog-hint">
                <i class="fas fa-star"></i>
                {{ $userLevel->max_exp - Auth::user()->total_exp }} EXP lagi untuk naik level
            </div>
            @endif
        </div>
        <div class="prog-divider"></div>
        <div class="stat-pills">
            <div class="stat-pill">
                <span class="snum">{{ Auth::user()->total_exp }}</span>
                <span class="slbl">EXP</span>
            </div>
            <div class="stat-pill">
                <span class="snum">{{ $completedCount }}</span>
                <span class="slbl">Selesai</span>
            </div>
            <div class="stat-pill">
                <span class="snum">{{ $totalVideos - $completedCount }}</span>
                <span class="slbl">Tersisa</span>
            </div>
        </div>
    </div>
</div>

<div class="top-bar">
    <div class="search-wrap">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" placeholder="Cari video, topik...">
    </div>
    <div class="result-label">
        <strong id="visibleCount">{{ $totalVideos }}</strong> video ditemukan
    </div>
</div>

<div class="filter-row">
    <a href="#" class="fchip active" data-level="all">
        <span class="fchip-dot" style="background:#105666;"></span>
        Semua Level
        <span class="fchip-count">{{ $totalVideos }}</span>
    </a>
    @foreach($levels as $i => $level)
    <a href="#sec-{{ $level->id }}" class="fchip" data-level="sec-{{ $level->id }}">
        <span class="fchip-dot" style="background:{{ $dotColors[$i % 4] }};"></span>
        {{ $level->name }}
        <span class="fchip-count">{{ $level->videos->count() }}</span>
    </a>
    @endforeach
</div>

@foreach($levels as $i => $level)
<div class="level-section" id="sec-{{ $level->id }}" data-section="sec-{{ $level->id }}">
    <div class="level-sec-head">
        <span class="lchip lchip-{{ $i % 4 }}">
            <i class="fas fa-layer-group" style="font-size:.65rem;"></i>
            {{ $level->name }}
        </span>
        <span class="lchip-desc">{{ $level->description }}</span>
    </div>
    <div class="course-grid">
        @forelse($level->videos as $video)
        @php
            $done = Auth::user()->progress()->where('video_id',$video->id)->where('is_completed',true)->exists();
        @endphp
        <div class="course-card"
             data-title="{{ strtolower($video->title) }}"
             data-desc="{{ strtolower($video->description ?? '') }}">
            <div class="course-thumb thumb-{{ $i % 4 }}">
                <i class="fas fa-play-circle"></i>
                <div class="play-overlay">
                    <div class="play-circle"><i class="fas fa-play"></i></div>
                </div>
                @if($done)
                <div class="done-badge">
                    <i class="fas fa-check-circle"></i> Selesai
                </div>
                @endif
            </div>
            <div class="course-body">
                <div class="c-title">{{ $video->title }}</div>
                <div class="c-desc">{{ Str::limit($video->description ?? '', 80) }}</div>
                <div class="c-meta">
                    <span class="c-tag tag-dur">
                        <i class="fas fa-clock"></i> {{ $video->duration ?? 0 }} mnt
                    </span>
                    <span class="c-tag tag-exp">
                        <i class="fas fa-star"></i> +{{ $video->exp_reward }} EXP
                    </span>
                </div>
                <a href="{{ route('education.show', $video->id) }}"
                   class="btn-cta {{ $done ? 'replay' : 'go' }}">
                    @if($done)
                        <i class="fas fa-redo"></i> Tonton Lagi
                    @else
                        <i class="fas fa-play"></i> Mulai Belajar
                    @endif
                </a>
            </div>
        </div>
        @empty
        <div class="empty-box">
            <i class="fas fa-video-slash"></i>
            Belum ada video untuk level ini
        </div>
        @endforelse
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
(function () {
    const cards   = () => document.querySelectorAll('.course-card');
    const countEl = document.getElementById('visibleCount');

    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let n = 0;
        cards().forEach(c => {
            const match = !q || c.dataset.title.includes(q) || c.dataset.desc.includes(q);
            c.style.display = match ? '' : 'none';
            if (match) n++;
        });
        countEl.textContent = n;
        document.querySelectorAll('.level-section').forEach(s => {
            const vis = [...s.querySelectorAll('.course-card')].some(c => c.style.display !== 'none');
            s.style.display = vis ? '' : 'none';
        });
    });

    document.querySelectorAll('.fchip').forEach(chip => {
        chip.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelectorAll('.fchip').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const target = this.dataset.level;
            document.querySelectorAll('.level-section').forEach(s => {
                s.style.display = (target === 'all' || s.dataset.section === target) ? '' : 'none';
            });
            if (target !== 'all') {
                const el = document.getElementById(target);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
})();
</script>
@endpush