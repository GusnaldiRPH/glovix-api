<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - {{ config('app.name', 'LMS Edukasi Saham') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style id="glovix-theme">
      /* ── Google Fonts ──────────────────────────── */
      @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

      /* ── Design Tokens ─────────────────────────── */
      :root {
        /* Backgrounds */
        --bg-page:    #F7F4D5;
        --bg-white:   #FDFBF0;
        --bg-soft:    #EDE9BF;
        --bg-muted:   #EAEAE3;

        /* Text */
        --text-primary:   #0A3323;
        --text-secondary: #3D5243;
        --text-muted:     #7A8C6E;
        --text-invert:    #FFFFFF;

        /* Green accent — used sparingly */
        --green-700:  #0A3323;
        --green-500:  #105666;
        --green-400:  #839958;
        --green-100:  #EEF2E3;
        --green-50:   #F7F4D5;

        /* Slate — for secondary elements */
        --slate-700:  #374151;
        --slate-500:  #6B7280;
        --slate-200:  #E5E7EB;
        --slate-100:  #F3F4F6;

        /* Amber — warm accent for variety */
        --amber-600:  #B8705E;
        --amber-400:  #F59E0B;
        --amber-100:  #F5DDD9;
        --amber-50:   #FFFBEB;

        /* Rose — subtle 4th color */
        --rose-500:   #F43F5E;
        --rose-100:   #FFE4E6;

        /* Border & Shadow */
        --border:     #D4CFA0;
        --border-soft:#E5E0BC;
        --shadow-xs:  0 1px 3px rgba(0,0,0,.06);
        --shadow-sm:  0 2px 8px rgba(0,0,0,.08);
        --shadow-md:  0 4px 20px rgba(0,0,0,.10);
        --shadow-lg:  0 8px 40px rgba(0,0,0,.12);

        /* Radius */
        --r-sm: 8px;
        --r-md: 12px;
        --r-lg: 16px;
        --r-xl: 24px;
      }

      /* ── Global Reset ───────────────────────────── */
      *, *::before, *::after { box-sizing: border-box; }

      body {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        background: var(--bg-page) !important;
        color: var(--text-primary) !important;
        font-size: 0.925rem;
        line-height: 1.65;
        -webkit-font-smoothing: antialiased;
      }

      h1,h2,h3,h4,h5,h6 {
        font-family: 'DM Serif Display', Georgia, serif !important;
        color: var(--text-primary) !important;
        font-weight: 400 !important;
        letter-spacing: -0.01em;
      }

      p, li, span, td, th, label, small, strong, em, b { color: var(--text-primary) !important; }
      .text-muted, small.text-muted, p.text-muted, span.text-muted, h6.text-muted { color: var(--text-muted) !important; }
      .text-secondary { color: var(--text-secondary) !important; }
      .text-dark, .text-black { color: var(--text-primary) !important; }
      .lead { color: var(--text-secondary) !important; font-size:1.05rem; }

      a { color: var(--green-500); text-decoration:none; transition:.2s; }
      a:hover { color: var(--green-700); }

      /* ── Cards ──────────────────────────────────── */
      .card {
        background: var(--bg-white) !important;
        border: 1px solid var(--border-soft) !important;
        border-radius: var(--r-lg) !important;
        box-shadow: var(--shadow-xs) !important;
        transition: all .25s ease !important;
        color: var(--text-primary) !important;
      }
      .card:hover {
        box-shadow: var(--shadow-md) !important;
        transform: translateY(-2px) !important;
        border-color: var(--border) !important;
      }
      .card-body { background: transparent !important; color: var(--text-primary) !important; }
      .card-title { color: var(--text-primary) !important; font-family:'DM Serif Display',serif !important; }
      .card-text { color: var(--text-secondary) !important; }
      .card-header {
        background: var(--bg-soft) !important;
        border-bottom: 1px solid var(--border) !important;
        color: var(--text-primary) !important;
        border-radius: var(--r-lg) var(--r-lg) 0 0 !important;
        font-weight: 600 !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
      }
      .card-footer { background: var(--bg-soft) !important; border-top:1px solid var(--border-soft) !important; }

      /* ── Buttons ─────────────────────────────────── */
      .btn { border-radius: var(--r-sm) !important; font-weight:600 !important; transition:all .2s !important; font-family:'Plus Jakarta Sans',sans-serif !important; }

      .btn-primary, .btn-success {
        background: var(--green-500) !important; border:none !important;
        color: #fff !important; box-shadow: 0 2px 8px rgba(45,145,89,.25) !important;
      }
      .btn-primary:hover, .btn-success:hover {
        background: var(--green-700) !important; color:#fff !important;
        box-shadow: 0 4px 16px rgba(16,86,102,.35) !important; transform:translateY(-1px) !important;
      }
      .btn-outline-primary, .btn-outline-success {
        border: 2px solid var(--green-500) !important; color: var(--green-500) !important;
        background: transparent !important;
      }
      .btn-outline-primary:hover, .btn-outline-success:hover {
        background: var(--green-500) !important; color:#fff !important;
      }
      .btn-secondary {
        background: var(--slate-100) !important; border: 1px solid var(--slate-200) !important;
        color: var(--slate-700) !important;
      }
      .btn-secondary:hover { background: var(--slate-200) !important; }
      .btn-warning {
        background: var(--amber-400) !important; border:none !important; color: var(--text-primary) !important;
      }
      .btn-danger {
        background: #F5DDD9 !important; border:1px solid #EBBBAF !important; color:#DC2626 !important;
      }
      .btn-light {
        background: var(--bg-soft) !important; border:1px solid var(--border) !important; color:var(--text-primary) !important;
      }

      /* ── Forms ───────────────────────────────────── */
      .form-control, .form-select, textarea, input:not([type=checkbox]):not([type=radio]) {
        background: var(--bg-white) !important;
        border: 1.5px solid var(--border) !important;
        border-radius: var(--r-sm) !important;
        color: var(--text-primary) !important;
        font-family: 'Plus Jakarta Sans',sans-serif !important;
        transition: border-color .2s, box-shadow .2s !important;
      }
      .form-control:focus, .form-select:focus {
        border-color: var(--green-400) !important;
        box-shadow: 0 0 0 3px rgba(61,170,106,.15) !important;
        background: var(--bg-white) !important;
        color: var(--text-primary) !important;
      }
      .form-control::placeholder { color: var(--text-muted) !important; }
      .form-label, .col-form-label { color: var(--text-secondary) !important; font-weight:500 !important; }
      .form-text { color: var(--text-muted) !important; }
      .input-group-text {
        background: var(--bg-soft) !important; border-color:var(--border) !important;
        color: var(--text-secondary) !important;
      }

      /* ── Tables ──────────────────────────────────── */
      .table { color: var(--text-primary) !important; }
      .table > :not(caption) > * > * { background:transparent !important; color:var(--text-primary) !important; border-color:var(--border-soft) !important; }
      .table thead th {
        background: var(--bg-soft) !important; color:var(--text-secondary) !important;
        border-color: var(--border) !important; font-weight:600 !important;
        font-size:.8rem; text-transform:uppercase; letter-spacing:.05em;
      }
      .table-hover > tbody > tr:hover > * { background: var(--green-50) !important; }

      /* ── Badges ──────────────────────────────────── */
      .badge { font-weight:600 !important; border-radius:6px !important; }
      .badge.bg-success, .bg-success { background: var(--green-100) !important; color: var(--green-700) !important; }
      .badge.bg-primary { background: var(--green-100) !important; color: var(--green-700) !important; }
      .badge.bg-warning { background: var(--amber-100) !important; color: var(--amber-600) !important; }
      .badge.bg-danger { background: var(--rose-100) !important; color: var(--rose-500) !important; }
      .badge.bg-secondary { background: var(--slate-100) !important; color: var(--slate-700) !important; }
      .badge.bg-info { background: #DBEAFE !important; color: #1D4ED8 !important; }

      /* ── Alerts ──────────────────────────────────── */
      .alert-success { background:var(--green-50) !important; border:1px solid #DDE5C8 !important; border-left:4px solid var(--green-400) !important; color:var(--green-700) !important; border-radius:var(--r-md) !important; }
      .alert-danger { background:#FFF1F2 !important; border:1px solid #FECDD3 !important; border-left:4px solid #F43F5E !important; color:#BE123C !important; border-radius:var(--r-md) !important; }
      .alert-warning { background:var(--amber-50) !important; border:1px solid #EBBBAF !important; border-left:4px solid var(--amber-400) !important; color:var(--amber-600) !important; border-radius:var(--r-md) !important; }
      .alert-info { background:#EFF6FF !important; border:1px solid #BFDBFE !important; border-left:4px solid #3B82F6 !important; color:#1D4ED8 !important; border-radius:var(--r-md) !important; }
      .btn-close { filter:none !important; }

      /* ── Misc Bootstrap fixes ────────────────────── */
      .bg-white { background: var(--bg-white) !important; }
      .bg-light { background: var(--bg-soft) !important; }
      .border { border-color: var(--border) !important; }
      .border-bottom { border-color: var(--border-soft) !important; }
      hr { border-color: var(--border-soft) !important; opacity:.8 !important; }
      .shadow-sm { box-shadow: var(--shadow-sm) !important; }
      .progress { background: var(--bg-muted) !important; border-radius:99px !important; }
      .progress-bar { background: var(--green-500) !important; }

      /* ── Pagination ──────────────────────────────── */
      .page-link { background:var(--bg-white) !important; border-color:var(--border) !important; color:var(--text-secondary) !important; }
      .page-item.active .page-link { background:var(--green-500) !important; border-color:var(--green-500) !important; color:#fff !important; }

      /* ── List group ──────────────────────────────── */
      .list-group-item { background:var(--bg-white) !important; border-color:var(--border-soft) !important; color:var(--text-primary) !important; }
      .list-group-item.active { background:var(--green-100) !important; border-color:var(--green-400) !important; color:var(--green-700) !important; }

      /* ── Dropdown ────────────────────────────────── */
      .dropdown-menu { background:var(--bg-white) !important; border:1px solid var(--border) !important; box-shadow:var(--shadow-lg) !important; border-radius:var(--r-md) !important; }
      .dropdown-item { color:var(--text-secondary) !important; }
      .dropdown-item:hover { background:var(--green-50) !important; color:var(--green-700) !important; }
      .dropdown-divider { border-color:var(--border-soft) !important; }

      /* ── Modal ───────────────────────────────────── */
      .modal-content { background:var(--bg-white) !important; border-radius:var(--r-xl) !important; border:1px solid var(--border) !important; box-shadow:var(--shadow-lg) !important; }
      .modal-header { background:var(--bg-soft) !important; border-bottom:1px solid var(--border) !important; border-radius:var(--r-xl) var(--r-xl) 0 0 !important; }
      .modal-footer { border-top:1px solid var(--border-soft) !important; }

      /* ── Breadcrumb ──────────────────────────────── */
      .breadcrumb-item a { color:var(--green-500) !important; }
      .breadcrumb-item.active { color:var(--text-muted) !important; }
      .breadcrumb-item + .breadcrumb-item::before { color:var(--text-muted) !important; }

      /* ── Scrollbar ───────────────────────────────── */
      ::-webkit-scrollbar { width:6px; height:6px; }
      ::-webkit-scrollbar-track { background:var(--bg-soft); }
      ::-webkit-scrollbar-thumb { background:var(--border); border-radius:99px; }
      ::-webkit-scrollbar-thumb:hover { background:var(--green-400); }

      /* ── Utility ─────────────────────────────────── */
      .text-success { color:var(--green-500) !important; }
      .text-primary { color:var(--green-700) !important; }
      .text-warning { color:var(--amber-600) !important; }
      .text-danger { color:var(--rose-500) !important; }
      select option { background:var(--bg-white); color:var(--text-primary); }
    </style>

    <style>
      body { overflow-x:hidden; }

      /* ── Sidebar ───────────────────── */
      #sidebar {
        min-height:100vh; width:260px;
        background: var(--bg-white);
        border-right: 1px solid var(--border-soft);
        box-shadow: var(--shadow-sm);
      }
      .sidebar-brand {
        font-family:'DM Serif Display',serif !important;
        font-size:1.3rem; color:var(--text-primary) !important;
        letter-spacing:-.02em;
      }
      .sidebar-brand .dot { color:var(--green-500); }
      .sidebar-icon {
        width:44px; height:44px;
        background:var(--green-100);
        border-radius:var(--r-md);
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 10px;
      }
      .sidebar-icon i { color:var(--green-700); }

      .nav-link {
        color:var(--text-secondary) !important;
        padding:.75rem 1rem !important;
        margin:.15rem 0 !important;
        border-radius:var(--r-sm) !important;
        font-weight:500 !important;
        font-size:.9rem !important;
        transition:all .2s !important;
      }
      .nav-link:hover { background:var(--green-50) !important; color:var(--green-700) !important; padding-left:1.3rem !important; }
      .nav-link.active { background:var(--green-100) !important; color:var(--green-700) !important; font-weight:600 !important; }
      .nav-link i { width:20px; color:var(--green-400); }

      /* ── Top Navbar ────────────────── */
      .top-navbar {
        background:var(--bg-white) !important;
        border-bottom:1px solid var(--border-soft) !important;
        box-shadow:var(--shadow-xs) !important;
        padding:1rem 0 !important;
      }
      .page-title { font-family:'DM Serif Display',serif !important; font-size:1.5rem !important; color:var(--text-primary) !important; font-weight:400 !important; margin:0 !important; }
      .date-badge {
        background:var(--bg-soft); color:var(--text-secondary);
        padding:.4rem .9rem; border-radius:var(--r-sm);
        font-size:.85rem; font-weight:500;
        border:1px solid var(--border);
      }

      main { background:var(--bg-page); }

      .user-info {
        background:var(--green-50);
        padding:.85rem 1rem;
        border-radius:var(--r-md);
        border:1px solid #DDE5C8;
        margin-top:auto;
      }
      .user-info small { color:var(--green-700) !important; font-weight:600; }

      hr { border-color:var(--border-soft) !important; }
    </style>
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <div id="sidebar" class="p-3">
        <div class="text-center mb-4 pb-3" style="border-bottom:1px solid var(--border-soft);">
            <div class="sidebar-icon"><i class="fas fa-cog fa-lg"></i></div>
            <h5 class="sidebar-brand mb-0">Admin<span class="dot">.</span>Panel</h5>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                <i class="fas fa-newspaper"></i> Kelola Berita
            </a>
            <a class="nav-link {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}" href="{{ route('admin.videos.index') }}">
                <i class="fas fa-video"></i> Kelola Video
            </a>
            <a class="nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}" href="{{ route('admin.sales.index') }}">
                <i class="fas fa-chart-line"></i> Laporan Penjualan
            </a>
            <hr>
            <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Kembali ke Website</a>
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form-admin').submit();">
                <i class="fas fa-sign-out-alt" style="color:#D3968C"></i> Logout
            </a>
            <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </nav>
        <div class="user-info mt-4">
            <small><i class="fas fa-user me-1"></i>{{ Auth::user()->name }}</small>
        </div>
    </div>

    <div id="content" class="flex-grow-1">
        <nav class="navbar navbar-expand-lg top-navbar">
            <div class="container-fluid px-4">
                <h4 class="page-title">@yield('page-title')</h4>
                <span class="date-badge"><i class="fas fa-calendar me-2" style="color:var(--green-400)"></i>{{ now()->format('d M Y') }}</span>
            </div>
        </nav>
        <main class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stack('scripts')
</body>
</html>