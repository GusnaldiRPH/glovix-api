<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glovix.Co</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── Design Tokens ── */
        :root {
            --bg-page:    #F7F4D5;
            --bg-white:   #FDFBF0;
            --bg-soft:    #EDE9BF;
            --text-primary:   #0A3323;
            --text-secondary: #3D5243;
            --text-muted:     #7A8C6E;
            --green-700:  #0A3323;
            --green-500:  #105666;
            --green-400:  #839958;
            --green-100:  #EEF2E3;
            --green-50:   #F7F4D5;
            --border:     #D4CFA0;
            --border-soft:#E5E0BC;
            --shadow-xs:  0 1px 3px rgba(0,0,0,.06);
            --shadow-sm:  0 2px 8px rgba(0,0,0,.08);
            --shadow-md:  0 4px 20px rgba(0,0,0,.10);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            color: var(--text-primary);
            font-size: .925rem;
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }

        h1,h2,h3,h4,h5,h6 {
            font-family: 'DM Serif Display', Georgia, serif;
            color: var(--text-primary);
            font-weight: 400;
            letter-spacing: -.01em;
        }

        p, li, span { color: var(--text-primary); }
        .text-muted { color: var(--text-muted) !important; }
        a { color: var(--green-500); text-decoration: none; transition: .2s; }
        a:hover { color: var(--green-700); }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-soft); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 99px; }

        /* ── Navbar ── */
        .navbar {
            background: var(--bg-white);
            border-bottom: 1px solid var(--border-soft);
            box-shadow: var(--shadow-xs);
            padding: .9rem 0;
            position: sticky; top: 0; z-index: 100;
        }
        .navbar-brand {
            font-family: 'DM Serif Display', serif;
            font-size: 1.5rem; color: var(--text-primary); letter-spacing: -.02em;
        }
        .navbar-brand i { color: var(--green-500); margin-right: .3rem; }
        .navbar-brand .brand-dot { color: var(--green-500); }
        .btn-masuk {
            background: var(--green-500); color: #fff !important;
            font-weight: 700; font-size: .85rem;
            padding: .5rem 1.4rem; border-radius: 8px;
            border: none; transition: all .2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: inline-flex; align-items: center; gap: .4rem;
        }
        .btn-masuk:hover {
            background: var(--green-700); color: #fff !important;
            box-shadow: 0 4px 14px rgba(16,86,102,.3); transform: translateY(-1px);
        }

        /* ── Hero (sama persis home.blade) ── */
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

        /* Hero stats */
        .hero-stats {
            display: flex; gap: 2rem; flex-wrap: wrap;
            margin-top: 2rem; padding-top: 1.75rem;
            border-top: 1px solid rgba(255,255,255,.15);
        }
        .hero-stat-num { font-family:'DM Serif Display',serif; font-size:1.5rem; color:#fff; line-height:1; }
        .hero-stat-label { font-size:.72rem; color:rgba(255,255,255,.6); margin-top:.15rem; }

        /* ── Feature cards (identik home.blade) ── */
        .feature-card {
            background: var(--bg-white); border: 1px solid var(--border-soft);
            border-radius: 16px; overflow: hidden; transition: all .3s ease;
            height: 100%; display: flex; flex-direction: column;
        }
        .feature-card:hover { border-color:var(--border); box-shadow:0 8px 32px rgba(16,86,102,.12); transform:translateY(-4px); }
        .feature-card-header {
            padding: 1.25rem 1.25rem .9rem;
            display: flex; align-items: center; gap: .75rem;
        }
        .feature-card-header .feat-icon {
            width:44px; height:44px; border-radius:10px;
            background:rgba(255,255,255,.22);
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .feature-card-header .feat-icon i { color:#fff !important; font-size:1.1rem; }
        .feature-card-header .feat-title { color:#fff !important; font-weight:700; font-size:.95rem; line-height:1.2; }
        .feat-color-1 { background:linear-gradient(135deg,#0A3323,#105666); }
        .feat-color-2 { background:linear-gradient(135deg,#105666,#2a7d4f); }
        .feat-color-3 { background:linear-gradient(135deg,#2a7d4f,#839958); }
        .feat-color-4 { background:linear-gradient(135deg,#839958,#B8705E); }
        .feature-card-body { padding:.9rem 1.25rem 1.25rem; flex:1; display:flex; flex-direction:column; }
        .feature-card-body p { color:var(--text-secondary) !important; font-size:.85rem; line-height:1.55; flex:1; margin-bottom:.75rem; }
        .btn-outline-success {
            border:2px solid var(--green-500) !important; color:var(--green-500) !important;
            background:transparent !important; border-radius:8px !important;
            font-weight:600 !important; font-size:.82rem !important;
            padding:.35rem .9rem !important; transition:all .2s !important;
        }
        .btn-outline-success:hover { background:var(--green-500) !important; color:#fff !important; }

        /* ── Info card (identik home.blade) ── */
        .info-card { background:#fff; border:1px solid #D4CFA0; border-radius:16px; transition:all .3s ease; }
        .info-card:hover { box-shadow:0 8px 24px rgba(0,0,0,.08); }

        /* ── Step cards ── */
        .step-card {
            background:var(--bg-white); border:1px solid var(--border-soft);
            border-radius:16px; padding:1.6rem; height:100%; transition:.3s;
        }
        .step-card:hover { box-shadow:var(--shadow-md); transform:translateY(-2px); border-color:var(--border); }
        .step-num {
            width:38px; height:38px;
            background:linear-gradient(135deg,#105666,#0A3323); color:#fff;
            border-radius:10px; display:flex; align-items:center; justify-content:center;
            font-weight:800; font-size:.9rem; margin-bottom:.9rem; font-family:'Plus Jakarta Sans',sans-serif;
        }
        .step-title { font-size:.95rem; font-weight:700; color:var(--text-primary); margin-bottom:.4rem; font-family:'Plus Jakarta Sans',sans-serif; }
        .step-desc { font-size:.82rem; color:var(--text-muted); line-height:1.6; margin:0; }

        /* ── Footer ── */
        footer { background:var(--text-primary); color:#9CA3AF; margin-top:5rem; padding:2.5rem 0; }
        footer p, footer span { color:#9CA3AF !important; }
        footer .brand-name { color:#fff !important; font-family:'DM Serif Display',serif; font-size:1.3rem; }
        footer i { color:var(--green-400); }

        /* ══ MOBILE ══ */
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
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="#">
            <i class="fas fa-chart-line"></i>Glovix<span class="brand-dot">.</span>Co
        </a>
        <a href="{{ route('login') }}" class="btn-masuk">
            <i class="fas fa-sign-in-alt"></i> Masuk
        </a>
    </div>
</nav>

<div class="py-4">
    <div class="container">

        <!-- Hero -->
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

        <!-- Fitur Unggulan -->
        <div class="row mb-5" id="fitur">
            <div class="col-12 mb-3">
                <h2 class="fw-bold" style="color:#0A3323;">
                    <span style="color:#105666;">Fitur</span> Unggulan
                </h2>
            </div>
            <div class="col-12">
                <div class="row feature-row g-0">

                    <div class="col-md-3 col-6 feature-col mb-3 px-2">
                        <div class="feature-card">
                            <div class="feature-card-header feat-color-1">
                                <div class="feat-icon"><i class="fas fa-newspaper"></i></div>
                                <span class="feat-title">Berita Terkini</span>
                            </div>
                            <div class="feature-card-body">
                                <p>Update berita pasar saham setiap hari dari berbagai sumber terpercaya</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">Lihat Berita</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 feature-col mb-3 px-2">
                        <div class="feature-card">
                            <div class="feature-card-header feat-color-2">
                                <div class="feat-icon"><i class="fas fa-chart-line"></i></div>
                                <span class="feat-title">Grafik Real-Time</span>
                            </div>
                            <div class="feature-card-body">
                                <p>Pantau pergerakan harga saham dan crypto secara real-time</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">Lihat Grafik</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 feature-col mb-3 px-2">
                        <div class="feature-card">
                            <div class="feature-card-header feat-color-3">
                                <div class="feat-icon"><i class="fas fa-graduation-cap"></i></div>
                                <span class="feat-title">Video Edukasi</span>
                            </div>
                            <div class="feature-card-body">
                                <p>Pelajari investasi dari pemula hingga profesional dengan sistem level</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">Mulai Belajar</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 feature-col mb-3 px-2">
                        <div class="feature-card">
                            <div class="feature-card-header feat-color-4">
                                <div class="feat-icon"><i class="fas fa-shopping-cart"></i></div>
                                <span class="feat-title">Trading</span>
                            </div>
                            <div class="feature-card-body">
                                <p>Beli dan jual saham, crypto, dan logam mulia dengan mudah</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">Mulai Trading</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Cara Mulai -->
        <div class="row mb-5">
            <div class="col-12 mb-3">
                <h2 class="fw-bold" style="color:#0A3323;">
                    Mulai dalam <span style="color:#105666;">3 Langkah</span>
                </h2>
            </div>
            <div class="col-md-4 mb-3">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <div class="step-title">Daftar & Masuk</div>
                    <p class="step-desc">Buat akun gratis dan masuk ke platform. Tidak perlu kartu kredit, langsung bisa mulai belajar.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="step-card">
                    <div class="step-num">2</div>
                    <div class="step-title">Pilih Materi Edukasi</div>
                    <p class="step-desc">Pilih modul sesuai level — dari dasar investasi hingga analisis teknikal dan manajemen portofolio.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="step-card">
                    <div class="step-num">3</div>
                    <div class="step-title">Praktik & Investasi</div>
                    <p class="step-desc">Terapkan ilmu yang dipelajari. Pantau grafik real-time dan mulai trading aset pilihanmu.</p>
                </div>
            </div>
        </div>

        <!-- Tujuan Platform -->
        <div class="row">
            <div class="col-12">
                <div class="card info-card">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-4" style="color:#0A3323;">
                            <i class="fas fa-bullseye me-2" style="color:#105666;"></i>
                            Tujuan Platform
                        </h3>
                        <p class="card-text text-muted mb-3" style="line-height:1.8;">
                            LMS Edukasi Saham adalah platform pembelajaran investasi yang dirancang untuk membantu investor pemula hingga profesional
                            memahami dunia investasi saham, cryptocurrency, dan logam mulia. Dengan sistem pembelajaran bertingkat, Anda akan:
                        </p>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2"><i class="fas fa-check-circle me-2" style="color:#105666;"></i><span class="text-muted">Memahami dasar investasi dengan benar</span></li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2" style="color:#105666;"></i><span class="text-muted">Belajar analisis teknikal dan fundamental</span></li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2" style="color:#105666;"></i><span class="text-muted">Mengelola risiko investasi dengan bijak</span></li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2" style="color:#105666;"></i><span class="text-muted">Praktik trading dengan sistem yang aman</span></li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2" style="color:#105666;"></i><span class="text-muted">Mendapatkan update berita pasar terkini</span></li>
                        </ul>
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn" style="background:linear-gradient(135deg,#105666,#0A3323);color:#fff;font-weight:700;border-radius:10px;padding:.7rem 2rem;border:none;font-family:'Plus Jakarta Sans',sans-serif;">
                                <i class="fas fa-rocket me-2"></i>Mulai Sekarang — Gratis!
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<footer>
    <div class="container text-center">
        <i class="fas fa-chart-line fa-2x mb-3"></i>
        <p class="brand-name mb-1">Glovix.Co</p>
        <p class="mb-0" style="font-size:.85rem;">&copy; {{ date('Y') }} Glovix.Co. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('btnLihatFitur').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#fitur').scrollIntoView({ behavior: 'smooth' });
    });
</script>
</body>
</html>