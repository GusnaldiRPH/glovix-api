<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style id="glovix-theme">
      @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

      :root {
        --bg-page:    #F7F4D5;
        --bg-white:   #FDFBF0;
        --bg-soft:    #EDE9BF;
        --bg-muted:   #EAEAE3;
        --text-primary:   #0A3323;
        --text-secondary: #3D5243;
        --text-muted:     #7A8C6E;
        --text-invert:    #FFFFFF;
        --green-700:  #0A3323;
        --green-500:  #105666;
        --green-400:  #839958;
        --green-100:  #EEF2E3;
        --green-50:   #F7F4D5;
        --slate-700:  #374151;
        --slate-500:  #6B7280;
        --slate-200:  #E5E7EB;
        --slate-100:  #F3F4F6;
        --amber-600:  #B8705E;
        --amber-400:  #F59E0B;
        --amber-100:  #F5DDD9;
        --amber-50:   #FFFBEB;
        --rose-500:   #F43F5E;
        --rose-100:   #FFE4E6;
        --border:     #D4CFA0;
        --border-soft:#E5E0BC;
        --shadow-xs:  0 1px 3px rgba(0,0,0,.06);
        --shadow-sm:  0 2px 8px rgba(0,0,0,.08);
        --shadow-md:  0 4px 20px rgba(0,0,0,.10);
        --shadow-lg:  0 8px 40px rgba(0,0,0,.12);
        --r-sm: 8px; --r-md: 12px; --r-lg: 16px; --r-xl: 24px;
      }

      *, *::before, *::after { box-sizing: border-box; }

      body {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        background: var(--bg-page) !important;
        color: var(--text-primary) !important;
        font-size: 0.925rem; line-height: 1.65;
        -webkit-font-smoothing: antialiased;
      }

      h1,h2,h3,h4,h5,h6 {
        font-family: 'DM Serif Display', Georgia, serif !important;
        color: var(--text-primary) !important;
        font-weight: 400 !important; letter-spacing: -0.01em;
      }

      p, li, span, td, th, label, small, strong, em, b { color: var(--text-primary) !important; }
      .text-muted, small.text-muted, p.text-muted, span.text-muted, h6.text-muted { color: var(--text-muted) !important; }
      .text-secondary { color: var(--text-secondary) !important; }
      .text-dark, .text-black { color: var(--text-primary) !important; }
      .lead { color: var(--text-secondary) !important; font-size:1.05rem; }
      a { color: var(--green-500); text-decoration:none; transition:.2s; }
      a:hover { color: var(--green-700); }

      .card { background: var(--bg-white) !important; border: 1px solid var(--border-soft) !important; border-radius: var(--r-lg) !important; box-shadow: var(--shadow-xs) !important; transition: all .25s ease !important; color: var(--text-primary) !important; }
      .card:hover { box-shadow: var(--shadow-md) !important; transform: translateY(-2px) !important; border-color: var(--border) !important; }
      .card-body { background: transparent !important; color: var(--text-primary) !important; }
      .card-title { color: var(--text-primary) !important; font-family:'DM Serif Display',serif !important; }
      .card-text { color: var(--text-secondary) !important; }
      .card-header { background: var(--bg-soft) !important; border-bottom: 1px solid var(--border) !important; color: var(--text-primary) !important; border-radius: var(--r-lg) var(--r-lg) 0 0 !important; font-weight: 600 !important; font-family: 'Plus Jakarta Sans', sans-serif !important; }
      .card-footer { background: var(--bg-soft) !important; border-top:1px solid var(--border-soft) !important; }

      .btn { border-radius: var(--r-sm) !important; font-weight:600 !important; transition:all .2s !important; font-family:'Plus Jakarta Sans',sans-serif !important; }
      .btn-primary, .btn-success { background: var(--green-500) !important; border:none !important; color: #fff !important; box-shadow: 0 2px 8px rgba(45,145,89,.25) !important; }
      .btn-primary:hover, .btn-success:hover { background: var(--green-700) !important; color:#fff !important; box-shadow: 0 4px 16px rgba(16,86,102,.35) !important; transform:translateY(-1px) !important; }
      .btn-outline-primary, .btn-outline-success { border: 2px solid var(--green-500) !important; color: var(--green-500) !important; background: transparent !important; }
      .btn-outline-primary:hover, .btn-outline-success:hover { background: var(--green-500) !important; color:#fff !important; }
      .btn-secondary { background: var(--slate-100) !important; border: 1px solid var(--slate-200) !important; color: var(--slate-700) !important; }
      .btn-secondary:hover { background: var(--slate-200) !important; }
      .btn-warning { background: var(--amber-400) !important; border:none !important; color: var(--text-primary) !important; }
      .btn-danger { background: #F5DDD9 !important; border:1px solid #EBBBAF !important; color:#DC2626 !important; }
      .btn-light { background: var(--bg-soft) !important; border:1px solid var(--border) !important; color:var(--text-primary) !important; }

      .form-control, .form-select, textarea, input:not([type=checkbox]):not([type=radio]) { background: var(--bg-white) !important; border: 1.5px solid var(--border) !important; border-radius: var(--r-sm) !important; color: var(--text-primary) !important; font-family: 'Plus Jakarta Sans',sans-serif !important; transition: border-color .2s, box-shadow .2s !important; }
      .form-control:focus, .form-select:focus { border-color: var(--green-400) !important; box-shadow: 0 0 0 3px rgba(61,170,106,.15) !important; background: var(--bg-white) !important; color: var(--text-primary) !important; }
      .form-control::placeholder { color: var(--text-muted) !important; }
      .form-label, .col-form-label { color: var(--text-secondary) !important; font-weight:500 !important; }
      .form-text { color: var(--text-muted) !important; }
      .input-group-text { background: var(--bg-soft) !important; border-color:var(--border) !important; color: var(--text-secondary) !important; }

      .table { color: var(--text-primary) !important; }
      .table > :not(caption) > * > * { background:transparent !important; color:var(--text-primary) !important; border-color:var(--border-soft) !important; }
      .table thead th { background: var(--bg-soft) !important; color:var(--text-secondary) !important; border-color: var(--border) !important; font-weight:600 !important; font-size:.8rem; text-transform:uppercase; letter-spacing:.05em; }
      .table-hover > tbody > tr:hover > * { background: var(--green-50) !important; }

      .badge { font-weight:600 !important; border-radius:6px !important; }
      .badge.bg-success, .bg-success { background: var(--green-100) !important; color: var(--green-700) !important; }
      .badge.bg-primary { background: var(--green-100) !important; color: var(--green-700) !important; }
      .badge.bg-warning { background: var(--amber-100) !important; color: var(--amber-600) !important; }
      .badge.bg-danger { background: var(--rose-100) !important; color: var(--rose-500) !important; }
      .badge.bg-secondary { background: var(--slate-100) !important; color: var(--slate-700) !important; }
      .badge.bg-info { background: #DBEAFE !important; color: #1D4ED8 !important; }

      .alert-success { background:var(--green-50) !important; border:1px solid #DDE5C8 !important; border-left:4px solid var(--green-400) !important; color:var(--green-700) !important; border-radius:var(--r-md) !important; }
      .alert-danger { background:#FFF1F2 !important; border:1px solid #FECDD3 !important; border-left:4px solid #F43F5E !important; color:#BE123C !important; border-radius:var(--r-md) !important; }
      .alert-warning { background:var(--amber-50) !important; border:1px solid #EBBBAF !important; border-left:4px solid var(--amber-400) !important; color:var(--amber-600) !important; border-radius:var(--r-md) !important; }
      .alert-info { background:#EFF6FF !important; border:1px solid #BFDBFE !important; border-left:4px solid #3B82F6 !important; color:#1D4ED8 !important; border-radius:var(--r-md) !important; }
      .btn-close { filter:none !important; }

      .bg-white { background: var(--bg-white) !important; }
      .bg-light { background: var(--bg-soft) !important; }
      .border { border-color: var(--border) !important; }
      .border-bottom { border-color: var(--border-soft) !important; }
      hr { border-color: var(--border-soft) !important; opacity:.8 !important; }
      .shadow-sm { box-shadow: var(--shadow-sm) !important; }
      .progress { background: var(--bg-muted) !important; border-radius:99px !important; }
      .progress-bar { background: var(--green-500) !important; }
      .page-link { background:var(--bg-white) !important; border-color:var(--border) !important; color:var(--text-secondary) !important; }
      .page-item.active .page-link { background:var(--green-500) !important; border-color:var(--green-500) !important; color:#fff !important; }
      .list-group-item { background:var(--bg-white) !important; border-color:var(--border-soft) !important; color:var(--text-primary) !important; }
      .list-group-item.active { background:var(--green-100) !important; border-color:var(--green-400) !important; color:var(--green-700) !important; }
      .dropdown-menu { background:var(--bg-white) !important; border:1px solid var(--border) !important; box-shadow:var(--shadow-lg) !important; border-radius:var(--r-md) !important; }
      .dropdown-item { color:var(--text-secondary) !important; }
      .dropdown-item:hover { background:var(--green-50) !important; color:var(--green-700) !important; }
      .dropdown-divider { border-color:var(--border-soft) !important; }
      .modal-content { background:var(--bg-white) !important; border-radius:var(--r-xl) !important; border:1px solid var(--border) !important; box-shadow:var(--shadow-lg) !important; }
      .modal-header { background:var(--bg-soft) !important; border-bottom:1px solid var(--border) !important; border-radius:var(--r-xl) var(--r-xl) 0 0 !important; }
      .modal-footer { border-top:1px solid var(--border-soft) !important; }
      .breadcrumb-item a { color:var(--green-500) !important; }
      .breadcrumb-item.active { color:var(--text-muted) !important; }
      .breadcrumb-item + .breadcrumb-item::before { color:var(--text-muted) !important; }

      ::-webkit-scrollbar { width:6px; height:6px; }
      ::-webkit-scrollbar-track { background:var(--bg-soft); }
      ::-webkit-scrollbar-thumb { background:var(--border); border-radius:99px; }
      ::-webkit-scrollbar-thumb:hover { background:var(--green-400); }

      .text-success { color:var(--green-500) !important; }
      .text-primary { color:var(--green-700) !important; }
      .text-warning { color:var(--amber-600) !important; }
      .text-danger { color:var(--rose-500) !important; }
      select option { background:var(--bg-white); color:var(--text-primary); }
    </style>

    <style>
      /* ── Navbar ── */
      .navbar { background: var(--bg-white) !important; border-bottom: 1px solid var(--border-soft); box-shadow: var(--shadow-xs); padding: .9rem 0; }
      .navbar-brand { font-family: 'DM Serif Display', serif !important; font-size: 1.5rem !important; color: var(--text-primary) !important; letter-spacing: -.02em; }
      .navbar-brand .brand-dot { color: var(--green-500); }
      .navbar-brand i { color: var(--green-500); margin-right:.3rem; }
      .nav-link { color: var(--text-secondary) !important; font-weight: 500 !important; padding: .5rem .9rem !important; border-radius: var(--r-sm) !important; margin: 0 .1rem; transition: all .2s !important; font-size: .9rem !important; }
      .nav-link:hover { background: var(--green-50) !important; color: var(--green-700) !important; }
      .nav-link.active { background: var(--green-100) !important; color: var(--green-700) !important; font-weight: 600 !important; }
      .nav-link i { color: var(--green-400); margin-right:.25rem; font-size:.85em; }

      /* ── Notification Bell ── */
      .notif-bell-btn {
        width: 36px; height: 36px;
        background: var(--bg-soft);
        border: 1px solid var(--border);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        transition: .2s; cursor: pointer; position: relative;
      }
      .notif-bell-btn:hover { background: var(--green-100); border-color: var(--green-400); }
      .notif-bell-btn i { color: var(--green-500) !important; font-size: .85rem; }
      .notif-badge {
        position: absolute; top: -4px; right: -4px;
        background: #F43F5E; color: #fff !important;
        font-size: .55rem; font-weight: 700;
        width: 17px; height: 17px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid var(--bg-white);
        line-height: 1;
      }

      /* Notif dropdown */
      .notif-dropdown {
        width: 340px;
        max-height: 480px;
        overflow: hidden;
        padding: 0 !important;
        border-radius: var(--r-lg) !important;
        border: 1px solid var(--border) !important;
        box-shadow: var(--shadow-lg) !important;
      }
      .notif-dropdown-header {
        padding: .85rem 1rem;
        border-bottom: 1px solid var(--border-soft);
        display: flex; justify-content: space-between; align-items: center;
        background: var(--bg-soft);
        border-radius: var(--r-lg) var(--r-lg) 0 0;
        flex-shrink: 0;
      }
      .notif-dropdown-header span { font-weight: 700; font-size: .9rem; color: var(--text-primary) !important; }
      .notif-mark-all {
        background: none; border: none; padding: 0; cursor: pointer;
        font-size: .75rem; color: var(--green-500) !important;
        font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
        transition: .2s;
      }
      .notif-mark-all:hover { color: var(--green-700) !important; }
      .notif-list { overflow-y: auto; max-height: 400px; }

      .notif-item {
        display: flex; gap: .75rem;
        padding: .85rem 1rem;
        border-bottom: 1px solid var(--border-soft);
        cursor: pointer; transition: background .15s;
      }
      .notif-item:last-child { border-bottom: none; }
      .notif-item:hover { background: var(--green-50) !important; }
      .notif-item.unread { background: rgba(16,86,102,.04); }
      .notif-icon-wrap {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
      }
      .notif-icon-wrap i { font-size: .8rem; }
      .notif-icon-green { background: var(--green-100); }
      .notif-icon-green i { color: var(--green-700) !important; }
      .notif-icon-blue { background: #DBEAFE; }
      .notif-icon-blue i { color: #1D4ED8 !important; }
      .notif-icon-amber { background: var(--amber-100); }
      .notif-icon-amber i { color: var(--amber-600) !important; }
      .notif-title {
        font-size: .82rem; color: var(--text-primary) !important;
        margin-bottom: .15rem; line-height: 1.35;
      }
      .notif-title.unread { font-weight: 700; }
      .notif-title.read { font-weight: 500; }
      .notif-unread-dot {
        width: 6px; height: 6px; background: #F43F5E;
        border-radius: 50%; display: inline-block;
        margin-left: .3rem; vertical-align: middle;
      }
      .notif-msg { font-size: .75rem; color: var(--text-muted) !important; line-height: 1.4; white-space: normal; }
      .notif-time { font-size: .68rem; color: var(--text-muted) !important; margin-top: .25rem; }
      .notif-empty { text-align: center; padding: 2.5rem 1rem; color: var(--text-muted); }
      .notif-empty i { font-size: 1.5rem; opacity: .3; display: block; margin-bottom: .5rem; color: var(--text-muted) !important; }
      .notif-empty span { font-size: .82rem; color: var(--text-muted) !important; }

      /* ── Mobile Sidebar ── */
      .mobile-sidebar { position: fixed; top: 0; right: 0; width: 300px; height: 100dvh; background: var(--bg-white); border-left: 1px solid var(--border); box-shadow: var(--shadow-lg); z-index: 1055; display: flex; flex-direction: column; transform: translateX(100%); transition: transform .32s cubic-bezier(.4,0,.2,1); overflow-y: auto; }
      .mobile-sidebar.open { transform: translateX(0); }
      .sidebar-overlay { position: fixed; inset: 0; background: rgba(10,51,35,.4); backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px); z-index: 1054; opacity: 0; pointer-events: none; transition: opacity .32s ease; }
      .sidebar-overlay.open { opacity: 1; pointer-events: all; }
      .sidebar-header { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; flex-shrink: 0; }
      .btn-close-sidebar { background: var(--bg-soft); border: 1px solid var(--border); border-radius: 50%; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; color: var(--text-secondary) !important; cursor: pointer; transition: all .2s; padding: 0; font-size: .85rem; }
      .btn-close-sidebar:hover { background: var(--amber-100); color: var(--amber-600) !important; border-color: #EBBBAF; }
      .btn-close-sidebar i { color: inherit !important; }
      .sidebar-user-info { display: flex; align-items: center; gap: .75rem; padding: .75rem 1rem; background: var(--bg-soft); margin: 0 1rem .25rem; border-radius: var(--r-md); flex-shrink: 0; }
      .sidebar-avatar { width: 40px; height: 40px; background: var(--green-100); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
      .sidebar-avatar i { color: var(--green-700) !important; font-size: .85rem; }
      .sidebar-user-name { font-weight: 600; font-size: .92rem; color: var(--text-primary) !important; }
      .sidebar-user-meta { font-size: .78rem; color: var(--text-muted) !important; }
      .sidebar-divider { border: none; border-top: 1px solid var(--border-soft); margin: .5rem 1.25rem; flex-shrink: 0; }
      .sidebar-nav { display: flex; flex-direction: column; padding: .25rem 1rem; gap: .2rem; flex: 1; }
      .sidebar-link { display: flex; align-items: center; gap: .75rem; padding: .7rem 1rem; border-radius: var(--r-sm); color: var(--text-secondary) !important; font-weight: 500; font-size: .9rem; transition: all .2s; text-decoration: none !important; }
      .sidebar-link i { color: var(--green-400) !important; width: 18px; text-align: center; font-size: .9rem; flex-shrink: 0; }
      .sidebar-link:hover { background: var(--green-50); color: var(--green-700) !important; }
      .sidebar-link:hover i { color: var(--green-500) !important; }
      .sidebar-link.active { background: var(--green-100); color: var(--green-700) !important; font-weight: 600; }
      .sidebar-link.active i { color: var(--green-700) !important; }
      .sidebar-footer { padding: .75rem 1rem 1.25rem; flex-shrink: 0; border-top: 1px solid var(--border-soft); margin-top: .5rem; }
      .sidebar-logout { color: #DC2626 !important; }
      .sidebar-logout i { color: #D3968C !important; }
      .sidebar-logout:hover { background: var(--rose-100) !important; color: #BE123C !important; }
      .sidebar-logout:hover i { color: #BE123C !important; }

      /* Notif di sidebar mobile */
      .sidebar-notif-section { padding: .5rem 1rem .25rem; flex-shrink: 0; }
      .sidebar-notif-title { font-size: .72rem; font-weight: 700; color: var(--text-muted) !important; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .5rem; }
      .sidebar-notif-item { display: flex; gap: .6rem; padding: .6rem .75rem; border-radius: var(--r-sm); cursor: pointer; transition: .15s; margin-bottom: .25rem; }
      .sidebar-notif-item:hover { background: var(--green-50); }
      .sidebar-notif-item.unread { background: rgba(16,86,102,.05); }
      .sidebar-notif-icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
      .sidebar-notif-icon i { font-size: .72rem; }
      .sidebar-notif-text { font-size: .76rem; color: var(--text-primary) !important; line-height: 1.4; font-weight: 500; }
      .sidebar-notif-time { font-size: .65rem; color: var(--text-muted) !important; margin-top: .1rem; }

      /* ── Footer ── */
      footer { background: var(--text-primary); color: #9CA3AF; margin-top: 5rem; padding: 2.5rem 0; }
      footer p, footer span { color: #9CA3AF !important; }
      footer .brand-name { color: #fff !important; font-family:'DM Serif Display',serif; font-size:1.3rem; }
      footer i { color: var(--green-400); }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-chart-line"></i>Glovix<span class="brand-dot">.</span>Co
            </a>

            {{-- Hamburger mobile --}}
            <button class="navbar-toggler border-0 d-lg-none" type="button" id="sidebarToggle" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Desktop nav --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
                            <i class="fas fa-newspaper"></i>Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('charts.*') ? 'active' : '' }}" href="{{ route('charts.index') }}">
                            <i class="fas fa-chart-bar"></i>Grafik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('education.*') ? 'active' : '' }}" href="{{ route('education.index') }}">
                            <i class="fas fa-graduation-cap"></i>Edukasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('purchase.*') ? 'active' : '' }}" href="{{ route('purchase.index') }}">
                            <i class="fas fa-shopping-cart"></i>Pembelian
                        </a>
                    </li>

                    {{-- ── Bell Notifikasi (desktop) ── --}}
                    @php
                        $notifications    = Auth::user()->notifications()->latest()->take(15)->get();
                        $unreadCount      = Auth::user()->unreadNotifications->count();
                        $colorMap = [
                            'green' => 'notif-icon-green',
                            'blue'  => 'notif-icon-blue',
                            'amber' => 'notif-icon-amber',
                        ];
                    @endphp
                    <li class="nav-item dropdown me-1">
                        <a class="nav-link p-1" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <div class="notif-bell-btn">
                                <i class="fas fa-bell"></i>
                                @if($unreadCount > 0)
                                <span class="notif-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                @endif
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end notif-dropdown" id="notifMenu">
                            {{-- Header --}}
                            <div class="notif-dropdown-header">
                                <span><i class="fas fa-bell me-1" style="color:var(--green-500);"></i> Notifikasi</span>
                                @if($unreadCount > 0)
                                <form action="{{ route('notifications.readAll') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="notif-mark-all">Tandai semua dibaca</button>
                                </form>
                                @endif
                            </div>
                            {{-- List --}}
                            <div class="notif-list">
                                @forelse($notifications as $notif)
                                @php
                                    $d    = $notif->data;
                                    $read = $notif->read_at !== null;
                                    $iconClass = $colorMap[$d['color'] ?? 'green'] ?? 'notif-icon-green';
                                @endphp
                                <div class="notif-item {{ $read ? '' : 'unread' }}"
                                     data-id="{{ $notif->id }}"
                                     data-url="{{ $d['url'] ?? '#' }}">
                                    <div class="notif-icon-wrap {{ $iconClass }}">
                                        <i class="{{ $d['icon'] ?? 'fas fa-bell' }}"></i>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div class="notif-title {{ $read ? 'read' : 'unread' }}">
                                            {{ $d['title'] ?? '' }}
                                            @if(!$read)<span class="notif-unread-dot"></span>@endif
                                        </div>
                                        <div class="notif-msg">{{ $d['message'] ?? '' }}</div>
                                        <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                @empty
                                <div class="notif-empty">
                                    <i class="fas fa-bell-slash"></i>
                                    <span>Belum ada notifikasi</span>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </li>

                    {{-- ── Dropdown User ── --}}
                    <li class="nav-item dropdown ms-1">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <span style="width:32px;height:32px;background:var(--green-100);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-user" style="color:var(--green-700);font-size:.8rem;"></i>
                            </span>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="px-3 py-2">
                                <small style="color:var(--text-muted)!important;display:block;">Level: {{ Auth::user()->level->name ?? 'Pemula' }}</small>
                                <small style="color:var(--text-muted)!important;">EXP: {{ Auth::user()->total_exp }}</small>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if(Auth::user()->is_admin)
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2" style="color:var(--green-400)"></i>Admin Panel</a></li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2" style="color:#D3968C"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- ── Mobile Sidebar Overlay ── --}}
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    {{-- ── Mobile Sidebar ── --}}
    <div id="mobileSidebar" class="mobile-sidebar d-lg-none">

        <div class="sidebar-header">
            <span style="font-family:'DM Serif Display',serif;font-size:1.2rem;color:var(--text-primary)!important;">
                <i class="fas fa-chart-line" style="color:var(--green-500);margin-right:.3rem;"></i>Glovix<span style="color:var(--green-500)">.</span>Co
            </span>
            <button id="sidebarClose" class="btn-close-sidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Info user --}}
        <div class="sidebar-user-info">
            <div class="sidebar-avatar"><i class="fas fa-user"></i></div>
            <div style="min-width:0;">
                <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                <div class="sidebar-user-meta">Level: {{ Auth::user()->level->name ?? 'Pemula' }} &middot; EXP: {{ Auth::user()->total_exp }}</div>
            </div>
        </div>

        <hr class="sidebar-divider">

        {{-- Notifikasi di sidebar mobile --}}
        @if($notifications->count() > 0)
        <div class="sidebar-notif-section">
            <div class="sidebar-notif-title">
                <i class="fas fa-bell me-1"></i> Notifikasi
                @if($unreadCount > 0)
                <span style="background:#F43F5E;color:#fff;font-size:.6rem;padding:.1rem .4rem;border-radius:99px;margin-left:.3rem;">{{ $unreadCount }}</span>
                @endif
            </div>
            @foreach($notifications->take(4) as $notif)
            @php $d = $notif->data; $read = $notif->read_at !== null; $iconClass = $colorMap[$d['color'] ?? 'green'] ?? 'notif-icon-green'; @endphp
            <div class="sidebar-notif-item {{ $read ? '' : 'unread' }}"
                 data-id="{{ $notif->id }}" data-url="{{ $d['url'] ?? '#' }}">
                <div class="sidebar-notif-icon {{ $iconClass }}">
                    <i class="{{ $d['icon'] ?? 'fas fa-bell' }}"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="sidebar-notif-text">{{ $d['title'] ?? '' }}</div>
                    <div class="sidebar-notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                </div>
                @if(!$read)<span style="width:6px;height:6px;background:#F43F5E;border-radius:50%;flex-shrink:0;margin-top:.3rem;display:block;"></span>@endif
            </div>
            @endforeach
            @if($unreadCount > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" style="width:100%;background:var(--green-50);border:1px solid var(--border);border-radius:var(--r-sm);padding:.4rem;font-size:.75rem;font-weight:600;color:var(--green-500);cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;">
                    Tandai semua dibaca
                </button>
            </form>
            @endif
        </div>
        <hr class="sidebar-divider">
        @endif

        {{-- Navigasi --}}
        <nav class="sidebar-nav">
            <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="{{ route('news.index') }}" class="sidebar-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i> Berita
            </a>
            <a href="{{ route('charts.index') }}" class="sidebar-link {{ request()->routeIs('charts.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Grafik
            </a>
            <a href="{{ route('education.index') }}" class="sidebar-link {{ request()->routeIs('education.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i> Edukasi
            </a>
            <a href="{{ route('purchase.index') }}" class="sidebar-link {{ request()->routeIs('purchase.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Pembelian
            </a>
            @if(Auth::user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                <i class="fas fa-cog"></i> Admin Panel
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" class="sidebar-link sidebar-logout"
               onclick="event.preventDefault();document.getElementById('logout-form-mobile').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>

    <main class="py-4">
        <div class="container">
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
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer>
        <div class="container text-center">
            <i class="fas fa-chart-line fa-2x mb-3"></i>
            <p class="brand-name mb-1">Glovix.Co</p>
            <p class="mb-0" style="font-size:.85rem;">&copy; {{ date('Y') }} Glovix.Co. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    // ── Mobile Sidebar ────────────────────────────────────
    (function () {
        const sidebar  = document.getElementById('mobileSidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        const btnOpen  = document.getElementById('sidebarToggle');
        const btnClose = document.getElementById('sidebarClose');
        if (!sidebar || !overlay || !btnOpen || !btnClose) return;

        function openSidebar()  { sidebar.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }

        btnOpen.addEventListener('click', openSidebar);
        btnClose.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
        window.addEventListener('resize', () => { if (window.innerWidth >= 992) closeSidebar(); });
    })();

    // ── Notifikasi: klik item → mark as read → redirect ──
    (function () {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.querySelectorAll('.notif-item, .sidebar-notif-item').forEach(function (item) {
            item.addEventListener('click', function () {
                const id  = this.dataset.id;
                const url = this.dataset.url;

                fetch('/notifications/' + id + '/read', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'Content-Type': 'application/json' }
                }).finally(function () {
                    window.location.href = url;
                });
            });
        });
    })();
    </script>

    @stack('scripts')
</body>
</html>