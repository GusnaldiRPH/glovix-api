@extends('layouts.user')

@section('title', 'Glovix.Co - Pembelian Aset')

@push('styles')
<style>
    /* ═══ HERO ═══ */
    .page-header {
        background: linear-gradient(135deg, #105666 0%, #0A3323 100%);
        border-radius: 16px; padding: 1.75rem 2rem;
        margin-bottom: 1.25rem; position: relative; overflow: hidden;
        box-shadow: 0 4px 20px rgba(10,51,35,.2);
    }
    .page-header::before {
        content:''; position:absolute; right:-30px; top:-30px;
        width:160px; height:160px; background:rgba(255,255,255,.06); border-radius:50%;
    }
    .page-header h2, .page-header p { color: #ffffff !important; }

    /* ═══ WALLET CARD ═══ */
    .wallet-card {
        background: linear-gradient(135deg, #105666, #0A3323);
        border-radius: 14px; padding: 1.4rem 1.6rem;
        color: white; position: relative; overflow: hidden;
        box-shadow: 0 6px 20px rgba(10,51,35,.3); height: 100%;
    }
    .wallet-card::before {
        content:''; position:absolute; top:-40px; right:-40px;
        width:180px; height:180px; background:rgba(255,255,255,.07); border-radius:50%;
    }
    .wallet-balance { font-size: 1.9rem; font-weight: 800; margin: .35rem 0 .2rem; }
    .wallet-label   { font-size: .8rem; opacity: .7; }

    /* ═══ PORTFOLIO SUMMARY ═══ */
    .portfolio-summary {
        background: #fff; border: 1px solid #E5E0BC;
        border-radius: 14px; padding: 1.2rem 1.4rem;
        box-shadow: 0 1px 6px rgba(0,0,0,.05); height: 100%;
    }
    .summary-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: .55rem 0; border-bottom: 1px solid #F3F4F6; font-size: .88rem;
    }
    .summary-item:last-child { border-bottom: none; }
    .summary-label { color: #7A8C6E; font-weight: 500; }
    .summary-value { font-weight: 700; color: #0A3323; }

    /* ═══ FILTER BAR (desktop) ═══ */
    .filter-bar { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; margin-bottom: 1rem; }
    .filter-chip {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .38rem .9rem; border-radius: 99px;
        font-size: .8rem; font-weight: 600; cursor: pointer;
        border: 1.5px solid #D4CFA0; background: #fff; color: #3D5243;
        transition: .18s; white-space: nowrap; text-decoration: none;
    }
    .filter-chip:hover { background: #F7F4D5; border-color: #DDE5C8; color: #0A3323; }
    .filter-chip.active { background: #EEF2E3; border-color: #105666; color: #0A3323; }
    .filter-chip .chip-dot { width: 7px; height: 7px; border-radius: 50%; }
    .filter-count { font-size: .68rem; background: rgba(0,0,0,.07); padding: .05rem .4rem; border-radius: 99px; }
    .filter-chip.active .filter-count { background: rgba(16,86,102,.15); }

    .filter-search { position: relative; flex: 1; min-width: 180px; max-width: 280px; }
    .filter-search input {
        width: 100%; padding: .42rem 1rem .42rem 2.2rem;
        border: 1.5px solid #D4CFA0; border-radius: 99px;
        font-size: .82rem; outline: none; background: #fff; color: #0A3323;
        transition: .2s; font-family: inherit;
    }
    .filter-search input:focus { border-color: #105666; box-shadow: 0 0 0 3px rgba(16,86,102,.1); }
    .filter-search input::placeholder { color: #9AAB8A; }
    .filter-search i { position:absolute; left:.75rem; top:50%; transform:translateY(-50%); color:#9AAB8A; font-size:.78rem; }

    /* ═══ MOBILE FILTER ROW ═══ */
    .mobile-filter-row { display: none; align-items: center; gap: .5rem; margin-bottom: 1rem; }
    .mobile-filter-search { position: relative; flex: 1; }
    .mobile-filter-search input {
        width: 100%; padding: .45rem 1rem .45rem 2.2rem;
        border: 1.5px solid #D4CFA0; border-radius: 99px;
        font-size: .82rem; outline: none; background: #fff; color: #0A3323;
        transition: .2s; font-family: inherit;
    }
    .mobile-filter-search input:focus { border-color: #105666; box-shadow: 0 0 0 3px rgba(16,86,102,.1); }
    .mobile-filter-search input::placeholder { color: #9AAB8A; }
    .mobile-filter-search i { position:absolute; left:.75rem; top:50%; transform:translateY(-50%); color:#9AAB8A; font-size:.78rem; }

    .btn-filter-drawer {
        display: flex; align-items: center; gap: .4rem;
        padding: .45rem .9rem; border-radius: 99px;
        border: 1.5px solid #D4CFA0; background: #fff;
        font-size: .8rem; font-weight: 600; color: #3D5243;
        cursor: pointer; white-space: nowrap; transition: .18s; flex-shrink: 0;
    }
    .btn-filter-drawer:hover { background: #F7F4D5; border-color: #DDE5C8; }
    .btn-filter-drawer.has-filter { background: #EEF2E3; border-color: #105666; color: #0A3323; }
    .btn-filter-drawer i { font-size: .75rem; color: #105666; }

    /* ═══ FILTER DRAWER ═══ */
    .filter-drawer {
        position: fixed; bottom: 0; left: 0; right: 0;
        background: var(--bg-white); border-radius: 20px 20px 0 0;
        padding: 0 1.25rem 2rem; z-index: 1060;
        transform: translateY(100%); transition: transform .32s cubic-bezier(.4,0,.2,1);
        box-shadow: 0 -4px 24px rgba(0,0,0,.12); max-height: 75vh; overflow-y: auto;
    }
    .filter-drawer.open { transform: translateY(0); }
    .filter-drawer-handle { width: 40px; height: 4px; background: #D4CFA0; border-radius: 99px; margin: .75rem auto 1rem; }
    .filter-drawer-title { font-weight: 700; font-size: .95rem; color: #0A3323; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; }
    .filter-drawer-close { background: var(--bg-soft); border: 1px solid var(--border); border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: .78rem; color: var(--text-secondary); transition: .2s; }
    .filter-drawer-close:hover { background: var(--amber-100); }

    .drawer-chip-group { display: flex; flex-direction: column; gap: .5rem; margin-bottom: 1.25rem; }
    .drawer-chip { display: flex; align-items: center; justify-content: space-between; padding: .7rem 1rem; border-radius: 10px; border: 1.5px solid #D4CFA0; background: #fff; font-size: .88rem; font-weight: 600; color: #3D5243; cursor: pointer; transition: .18s; }
    .drawer-chip:hover { background: #F7F4D5; border-color: #DDE5C8; }
    .drawer-chip.active { background: #EEF2E3; border-color: #105666; color: #0A3323; }
    .drawer-chip .left { display: flex; align-items: center; gap: .6rem; }
    .drawer-chip .chip-dot { width: 9px; height: 9px; border-radius: 50%; }
    .drawer-chip .chip-count { font-size: .72rem; background: rgba(0,0,0,.07); padding: .1rem .45rem; border-radius: 99px; font-weight: 600; }
    .drawer-chip.active .chip-count { background: rgba(16,86,102,.15); }
    .drawer-chip .check-icon { color: #105666; font-size: .85rem; display: none; }
    .drawer-chip.active .check-icon { display: block; }

    .btn-apply-filter { width: 100%; padding: .75rem; background: linear-gradient(135deg, #105666, #0A3323); color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: .9rem; cursor: pointer; transition: .2s; }
    .btn-apply-filter:hover { opacity: .9; }

    .filter-overlay { display: none; position: fixed; inset: 0; background: rgba(10,51,35,.35); backdrop-filter: blur(2px); z-index: 1059; }
    .filter-overlay.open { display: block; }

    /* ═══ ASSET GRID ═══ */
    .asset-grid { display: grid; gap: .75rem; grid-template-columns: repeat(2, 1fr); }
    @media (min-width: 480px) { .asset-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 768px) { .asset-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (min-width: 1024px){ .asset-grid { grid-template-columns: repeat(5, 1fr); } }
    @media (min-width: 1280px){ .asset-grid { grid-template-columns: repeat(6, 1fr); } }

    @media (max-width: 767px) {
        .asset-grid { display: flex !important; flex-wrap: nowrap !important; overflow-x: auto; gap: .65rem; padding-bottom: .5rem; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; }
        .asset-grid::-webkit-scrollbar { display: none; }
        .asset-grid { scrollbar-width: none; }
        .asset-grid .asset-card { flex: 0 0 150px; min-width: 150px; scroll-snap-align: start; }
        #noAssets { flex: 0 0 100%; min-width: 100%; }
    }

    /* ═══ ASSET CARD ═══ */
    .asset-card {
        background: #fff; border: 1px solid #E5E0BC; border-radius: 12px; padding: .9rem;
        cursor: pointer; transition: all .2s ease; box-shadow: 0 1px 4px rgba(0,0,0,.05);
        position: relative; overflow: hidden;
    }
    .asset-card::after { content:''; position:absolute; top:0; left:0; right:0; height:3px; background: linear-gradient(90deg, #105666, #839958); transform: scaleX(0); transition: transform .2s ease; }
    .asset-card:hover { transform:translateY(-3px); box-shadow:0 8px 20px rgba(0,0,0,.1); border-color:#DDE5C8; }
    .asset-card:hover::after { transform: scaleX(1); }
    .asset-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: .65rem; font-size: 1rem; }
    .icon-stock  { background: #EEF2E3; color: #0A3323; }
    .icon-crypto { background: #F5DDD9; color: #B8705E; }
    .icon-metal  { background: #EDE9FE; color: #5B21B6; }
    .asset-name   { font-size: .8rem; font-weight: 700; color: #0A3323; margin-bottom: .1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .asset-symbol { font-size: .7rem; color: #7A8C6E; margin-bottom: .5rem; }
    .asset-price  { font-size: .95rem; font-weight: 800; color: #0A3323; margin-bottom: .45rem; }
    .asset-badges { display: flex; gap: .3rem; flex-wrap: wrap; }
    .abadge { font-size: .62rem; font-weight: 700; padding: .15rem .45rem; border-radius: 4px; }
    .abadge-usd   { background: #F5DDD9; color: #B8705E; }
    .abadge-idr   { background: #EEF2E3; color: #0A3323; }
    .abadge-stock { background: #F3F4F6; color: #6B7280; }
    .abadge-crypto{ background: #FFF7ED; color: #C2410C; }
    .abadge-metal { background: #F5F3FF; color: #7C3AED; }

    /* ═══ PORTFOLIO TABLE ═══ */
    .portfolio-card { background: #fff; border: 1px solid #E5E0BC; border-radius: 14px; overflow: hidden; box-shadow: 0 1px 6px rgba(0,0,0,.05); }
    .portfolio-card table thead th { background: #F7F4D5; font-size: .78rem; font-weight: 700; color: #3D5243; padding: .75rem 1rem; border-bottom: 1.5px solid #E5E0BC; text-transform: uppercase; letter-spacing: .04em; }
    .portfolio-card table tbody td { padding: .75rem 1rem; vertical-align: middle; border-bottom: 1px solid #F3F4F6; font-size: .85rem; }
    .portfolio-card table tbody tr:hover td { background: #EEF2E3; }
    .portfolio-card table tbody tr:last-child td { border-bottom: none; }

    /* ═══ PORTFOLIO MOBILE CARD ═══ */
    .portfolio-mobile-card { display: none; }
    .portfolio-item-card { background: #fff; border: 1px solid #E5E0BC; border-radius: 12px; padding: 1rem 1.1rem; margin-bottom: .75rem; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
    .portfolio-item-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: .65rem; }
    .portfolio-item-name { font-weight: 700; font-size: .9rem; color: #0A3323; }
    .portfolio-item-symbol { font-size: .73rem; color: #7A8C6E; margin-top: .1rem; }
    .portfolio-item-body { display: grid; grid-template-columns: 1fr 1fr; gap: .45rem 1rem; }
    .portfolio-item-row { display: flex; flex-direction: column; }
    .portfolio-item-label { font-size: .68rem; color: #9AAB8A; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
    .portfolio-item-val { font-size: .82rem; font-weight: 700; color: #0A3323; margin-top: .05rem; }
    .portfolio-item-footer { margin-top: .75rem; padding-top: .65rem; border-top: 1px solid #F3F4F6; display: flex; justify-content: space-between; align-items: center; }

    .profit-badge { display: inline-block; padding: .28rem .65rem; border-radius: 6px; font-weight: 700; font-size: .78rem; }
    .profit-badge.pos { background: #EEF2E3; color: #0A3323; }
    .profit-badge.neg { background: #F5DDD9; color: #991B1B; }

    .currency-tag { font-size: .65rem; font-weight: 700; padding: .12rem .4rem; border-radius: 4px; vertical-align: middle; }
    .currency-tag.usd { background: #F5DDD9; color: #B8705E; }
    .currency-tag.idr { background: #EEF2E3; color: #0A3323; }

    /* ═══ SELL PREVIEW BOX ═══ */
    .sell-preview {
        background: #F7F4D5; border: 1px solid #DDE5C8;
        border-radius: 10px; padding: .85rem 1rem;
        margin-top: .75rem; display: none;
    }
    .sell-preview.show { display: block; }
    .sell-preview-row { display: flex; justify-content: space-between; align-items: center; font-size: .84rem; margin-bottom: .3rem; }
    .sell-preview-row:last-child { margin-bottom: 0; padding-top: .35rem; border-top: 1px solid #DDE5C8; font-weight: 700; }
    .sell-preview-label { color: #7A8C6E; }
    .sell-preview-val { color: #0A3323; font-weight: 600; }

    /* ═══ MODALS ═══ */
    .modal-content  { border-radius: 16px; border: none; }
    .modal-header   { background: linear-gradient(135deg, #105666, #0A3323); color: white; border-radius: 12px 12px 0 0; }
    .btn-purchase   { background: linear-gradient(135deg, #105666, #0A3323); color: white; font-weight: 700; border: none; border-radius: 9px; padding: .65rem 1.6rem; transition: all .2s; }
    .btn-purchase:hover { box-shadow: 0 4px 14px rgba(16,86,102,.4); transform: translateY(-1px); color: white; }
    .btn-sell { background: linear-gradient(135deg, #B8705E, #991B1B); color: white; font-weight: 700; border: none; border-radius: 9px; padding: .65rem 1.6rem; transition: all .2s; }
    .btn-sell:hover { box-shadow: 0 4px 14px rgba(185,112,94,.4); transform: translateY(-1px); color: white; }
    .quick-amount:hover { background: linear-gradient(135deg, #105666, #0A3323); border-color:#105666; color:white; }

    .sec-title { font-size: 1rem; font-weight: 700; color: #0A3323; margin-bottom: .85rem; display: flex; align-items: center; gap: .5rem; }
    .sec-title i { color: #105666; }
    .empty-assets { grid-column: 1/-1; text-align: center; padding: 2.5rem; background: #F7F4D5; border-radius: 12px; color: #9AAB8A; }

    /* ═══ SELL QUICK BUTTONS ═══ */
    .sell-quick-btn {
        padding: .28rem .7rem; border-radius: 6px; font-size: .75rem; font-weight: 600;
        border: 1.5px solid #EBBBAF; background: #F5DDD9; color: #B8705E;
        cursor: pointer; transition: .18s;
    }
    .sell-quick-btn:hover { background: #B8705E; color: #fff; border-color: #B8705E; }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width: 767px) {
        .filter-bar { display: none !important; }
        .mobile-filter-row { display: flex !important; }
        .portfolio-table-desktop { display: none !important; }
        .portfolio-mobile-card { display: block !important; }
    }
</style>
@endpush

@section('content')

<!-- Header -->
<div class="page-header text-white mb-3">
    <div style="position:relative;z-index:1;">
        <h2 class="mb-1 fw-bold" style="font-size:1.5rem;"><i class="fas fa-shopping-cart me-2"></i>Pembelian Aset</h2>
        <p class="mb-0" style="opacity:.75;font-size:.85rem;">Beli dan kelola portofolio investasi Anda</p>
    </div>
</div>

<!-- Wallet + Portfolio Summary -->
<div class="row g-3 mb-3">
    <div class="col-md-5">
        <div class="wallet-card">
            <div style="position:relative;z-index:1;">
                <div class="wallet-label">Saldo Dompet</div>
                <div class="wallet-balance">Rp {{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</div>
                <div class="wallet-label mb-3">Tersedia untuk investasi</div>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#topupModal" style="font-weight:600;font-size:.8rem;">
                    <i class="fas fa-plus me-1"></i>Top Up
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        @php
            $totalInvestment = $totalCurrentValue = 0;
            $usdToIdr = 15000;
            foreach($userAssets ?? [] as $ua) {
                $q = $ua->quantity; $bp = $ua->purchase_price; $cp = $ua->asset->current_price;
                if (in_array($ua->asset->type, ['crypto','precious_metal'])) { $bp *= $usdToIdr; $cp *= $usdToIdr; }
                $totalInvestment   += $q * $bp;
                $totalCurrentValue += $q * $cp;
            }
            $totalProfit    = $totalCurrentValue - $totalInvestment;
            $totalProfitPct = $totalInvestment > 0 ? (($totalProfit / $totalInvestment) * 100) : 0;
        @endphp
        <div class="portfolio-summary">
            <div class="sec-title"><i class="fas fa-chart-pie"></i>Ringkasan Portfolio</div>
            <div class="summary-item">
                <span class="summary-label">Total Investasi</span>
                <span class="summary-value">Rp {{ number_format($totalInvestment, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Nilai Saat Ini</span>
                <span class="summary-value {{ $totalProfit >= 0 ? 'text-success' : 'text-danger' }}">
                    Rp {{ number_format($totalCurrentValue, 0, ',', '.') }}
                </span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Profit / Loss</span>
                <span class="summary-value {{ $totalProfit >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $totalProfit >= 0 ? '+' : '' }}Rp {{ number_format(abs($totalProfit), 0, ',', '.') }}
                    <small>({{ number_format($totalProfitPct, 2) }}%)</small>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Available Assets -->
<div class="mb-4">
    <div class="sec-title"><i class="fas fa-coins"></i>Aset Tersedia</div>

    <div class="filter-bar">
        <div class="filter-search"><i class="fas fa-search"></i><input type="text" id="assetSearch" placeholder="Cari aset..."></div>
        <a href="#" class="filter-chip active" data-filter="all">Semua <span class="filter-count">{{ count($assets) }}</span></a>
        <a href="#" class="filter-chip" data-filter="stock"><span class="chip-dot" style="background:#0A3323;"></span>Saham <span class="filter-count">{{ $assets->where('type','stock')->count() }}</span></a>
        <a href="#" class="filter-chip" data-filter="crypto"><span class="chip-dot" style="background:#D3968C;"></span>Crypto <span class="filter-count">{{ $assets->where('type','crypto')->count() }}</span></a>
        <a href="#" class="filter-chip" data-filter="precious_metal"><span class="chip-dot" style="background:#7C3AED;"></span>Logam Mulia <span class="filter-count">{{ $assets->where('type','precious_metal')->count() }}</span></a>
    </div>

    <div class="mobile-filter-row">
        <div class="mobile-filter-search"><i class="fas fa-search"></i><input type="text" id="assetSearchMobile" placeholder="Cari aset..."></div>
        <button class="btn-filter-drawer" id="btnOpenFilterDrawer"><i class="fas fa-sliders-h"></i>Filter</button>
    </div>

    <div class="asset-grid" id="assetGrid">
        @foreach($assets as $asset)
        @php
            $isUSD     = in_array($asset->type, ['crypto','precious_metal']);
            $iconClass = $asset->type === 'stock' ? 'icon-stock' : ($asset->type === 'crypto' ? 'icon-crypto' : 'icon-metal');
            $faIcon    = $asset->type === 'stock' ? 'chart-line' : ($asset->type === 'crypto' ? 'bitcoin' : 'coins');
        @endphp
        <div class="asset-card"
             data-filter="{{ $asset->type }}"
             data-name="{{ strtolower($asset->name) }} {{ strtolower($asset->symbol) }}"
             data-bs-toggle="modal" data-bs-target="#purchaseModal"
             data-asset-id="{{ $asset->id }}"
             data-asset-name="{{ $asset->name }}"
             data-asset-symbol="{{ $asset->symbol }}"
             data-asset-price="{{ $asset->current_price }}"
             data-asset-type="{{ $asset->type }}"
             data-currency="{{ $isUSD ? 'USD' : 'IDR' }}">
            <div class="asset-icon {{ $iconClass }}"><i class="fas fa-{{ $faIcon }}"></i></div>
            <div class="asset-name" title="{{ $asset->name }}">{{ $asset->name }}</div>
            <div class="asset-symbol">{{ $asset->symbol }}</div>
            <div class="asset-price">
                @if($isUSD) ${{ number_format($asset->current_price, 2, '.', ',') }}
                @else Rp {{ number_format($asset->current_price, 0, ',', '.') }} @endif
            </div>
            <div class="asset-badges">
                <span class="abadge {{ $isUSD ? 'abadge-usd' : 'abadge-idr' }}">{{ $isUSD ? 'USD' : 'IDR' }}</span>
                <span class="abadge abadge-{{ $asset->type }}">{{ ucfirst(str_replace('_',' ',$asset->type)) }}</span>
            </div>
        </div>
        @endforeach
        <div class="empty-assets" id="noAssets" style="display:none;">
            <i class="fas fa-search" style="font-size:1.5rem;display:block;margin-bottom:.5rem;opacity:.4;"></i>
            Tidak ada aset yang cocok
        </div>
    </div>
</div>

<!-- Portfolio Section -->
<div class="mb-4">
    <div class="sec-title"><i class="fas fa-wallet"></i>Portfolio Saya</div>

    {{-- Desktop table --}}
    <div class="portfolio-card portfolio-table-desktop">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Aset</th><th>Jumlah</th><th>Harga Beli</th>
                    <th>Harga Kini</th><th>Total Nilai</th><th>Profit/Loss</th><th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($userAssets ?? [] as $ua)
                @php
                    $qty = $ua->quantity; $bp = $ua->purchase_price ?? 0; $cp = $ua->asset->current_price ?? 0;
                    $usd = in_array($ua->asset->type, ['crypto','precious_metal']);
                    $tv  = $qty * $cp; $pft = ($cp - $bp) * $qty;
                    $pct = $bp > 0 ? (($cp - $bp) / $bp * 100) : 0;
                @endphp
                <tr>
                    <td>
                        <div style="font-weight:700;font-size:.85rem;">{{ $ua->asset->name }}</div>
                        <div style="font-size:.73rem;color:#7A8C6E;">{{ $ua->asset->symbol }}
                            <span class="currency-tag {{ $usd ? 'usd' : 'idr' }}">{{ $usd ? 'USD' : 'IDR' }}</span>
                        </div>
                    </td>
                    <td>{{ number_format($qty, 4) }}</td>
                    <td style="font-size:.83rem;">{{ $usd ? '$'.number_format($bp,2,'.', ',') : 'Rp '.number_format($bp,0,',','.') }}</td>
                    <td style="font-size:.83rem;">{{ $usd ? '$'.number_format($cp,2,'.',',') : 'Rp '.number_format($cp,0,',','.') }}</td>
                    <td style="font-weight:700;font-size:.83rem;">
                        {{ $usd ? '$'.number_format($tv,2,'.',',') : 'Rp '.number_format($tv,0,',','.') }}
                        @if($usd)<div style="font-size:.7rem;color:#7A8C6E;">≈ Rp {{ number_format($tv*15000,0,',','.') }}</div>@endif
                    </td>
                    <td>
                        <span class="profit-badge {{ $pft >= 0 ? 'pos' : 'neg' }}">
                            {{ $pft >= 0 ? '+' : '' }}{{ $usd ? '$'.number_format(abs($pft),2,'.',',') : 'Rp '.number_format(abs($pft),0,',','.') }}
                            <div style="font-size:.68rem;opacity:.8;">({{ number_format($pct,2) }}%)</div>
                        </span>
                    </td>
                    <td>
                        {{-- ✅ Tombol Jual buka modal --}}
                        <button type="button" class="btn btn-sm btn-sell-open"
                                style="background:#F5DDD9;color:#DC2626;border:1px solid #EBBBAF;border-radius:7px;"
                                data-ua-id="{{ $ua->id }}"
                                data-asset-name="{{ $ua->asset->name }}"
                                data-asset-symbol="{{ $ua->asset->symbol }}"
                                data-current-qty="{{ $qty }}"
                                data-current-price="{{ $cp }}"
                                data-currency="{{ $usd ? 'USD' : 'IDR' }}"
                                data-bs-toggle="modal" data-bs-target="#sellModal">
                            <i class="fas fa-sign-out-alt" style="font-size:.75rem;"></i> Jual
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4" style="color:#9AAB8A;">
                        <i class="fas fa-inbox" style="font-size:1.8rem;display:block;margin-bottom:.5rem;opacity:.35;"></i>
                        Belum ada investasi. Mulai beli aset sekarang!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile cards --}}
    <div class="portfolio-mobile-card">
        @forelse($userAssets ?? [] as $ua)
        @php
            $qty = $ua->quantity; $bp = $ua->purchase_price ?? 0; $cp = $ua->asset->current_price ?? 0;
            $usd = in_array($ua->asset->type, ['crypto','precious_metal']);
            $tv  = $qty * $cp; $pft = ($cp - $bp) * $qty;
            $pct = $bp > 0 ? (($cp - $bp) / $bp * 100) : 0;
        @endphp
        <div class="portfolio-item-card">
            <div class="portfolio-item-header">
                <div>
                    <div class="portfolio-item-name">{{ $ua->asset->name }}</div>
                    <div class="portfolio-item-symbol">{{ $ua->asset->symbol }}
                        <span class="currency-tag {{ $usd ? 'usd' : 'idr' }}">{{ $usd ? 'USD' : 'IDR' }}</span>
                    </div>
                </div>
                <span class="profit-badge {{ $pft >= 0 ? 'pos' : 'neg' }}">{{ $pft >= 0 ? '+' : '' }}{{ number_format($pct,2) }}%</span>
            </div>
            <div class="portfolio-item-body">
                <div class="portfolio-item-row">
                    <span class="portfolio-item-label">Jumlah</span>
                    <span class="portfolio-item-val">{{ number_format($qty, 4) }}</span>
                </div>
                <div class="portfolio-item-row">
                    <span class="portfolio-item-label">Total Nilai</span>
                    <span class="portfolio-item-val">{{ $usd ? '$'.number_format($tv,2,'.',',') : 'Rp '.number_format($tv,0,',','.') }}</span>
                    @if($usd)<span style="font-size:.68rem;color:#9AAB8A;">≈ Rp {{ number_format($tv*15000,0,',','.') }}</span>@endif
                </div>
                <div class="portfolio-item-row">
                    <span class="portfolio-item-label">Harga Beli</span>
                    <span class="portfolio-item-val">{{ $usd ? '$'.number_format($bp,2,'.', ',') : 'Rp '.number_format($bp,0,',','.') }}</span>
                </div>
                <div class="portfolio-item-row">
                    <span class="portfolio-item-label">Harga Kini</span>
                    <span class="portfolio-item-val">{{ $usd ? '$'.number_format($cp,2,'.',',') : 'Rp '.number_format($cp,0,',','.') }}</span>
                </div>
            </div>
            <div class="portfolio-item-footer">
                <div>
                    <div style="font-size:.7rem;color:#9AAB8A;text-transform:uppercase;font-weight:600;">Profit / Loss</div>
                    <div class="{{ $pft >= 0 ? 'text-success' : 'text-danger' }}" style="font-weight:700;font-size:.85rem;">
                        {{ $pft >= 0 ? '+' : '' }}{{ $usd ? '$'.number_format(abs($pft),2,'.',',') : 'Rp '.number_format(abs($pft),0,',','.') }}
                    </div>
                </div>
                {{-- ✅ Tombol Jual mobile --}}
                <button type="button" class="btn btn-sm btn-sell-open"
                        style="background:#F5DDD9;color:#DC2626;border:1px solid #EBBBAF;border-radius:7px;font-size:.78rem;"
                        data-ua-id="{{ $ua->id }}"
                        data-asset-name="{{ $ua->asset->name }}"
                        data-asset-symbol="{{ $ua->asset->symbol }}"
                        data-current-qty="{{ $qty }}"
                        data-current-price="{{ $cp }}"
                        data-currency="{{ $usd ? 'USD' : 'IDR' }}"
                        data-bs-toggle="modal" data-bs-target="#sellModal">
                    <i class="fas fa-sign-out-alt me-1" style="font-size:.72rem;"></i>Jual
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-4" style="color:#9AAB8A;background:#F7F4D5;border-radius:12px;">
            <i class="fas fa-inbox" style="font-size:1.8rem;display:block;margin-bottom:.5rem;opacity:.35;"></i>
            Belum ada investasi. Mulai beli aset sekarang!
        </div>
        @endforelse
    </div>
</div>

{{-- Filter Drawer --}}
<div class="filter-overlay" id="filterOverlay"></div>
<div class="filter-drawer" id="filterDrawer">
    <div class="filter-drawer-handle"></div>
    <div class="filter-drawer-title">
        <span><i class="fas fa-sliders-h me-2" style="color:#105666;"></i>Filter Aset</span>
        <div class="filter-drawer-close" id="btnCloseFilterDrawer"><i class="fas fa-times"></i></div>
    </div>
    <div class="drawer-chip-group">
        <div class="drawer-chip active" data-filter="all"><div class="left"><span>Semua Aset</span><span class="chip-count">{{ count($assets) }}</span></div><i class="fas fa-check check-icon"></i></div>
        <div class="drawer-chip" data-filter="stock"><div class="left"><span class="chip-dot" style="background:#0A3323;"></span><span>Saham</span><span class="chip-count">{{ $assets->where('type','stock')->count() }}</span></div><i class="fas fa-check check-icon"></i></div>
        <div class="drawer-chip" data-filter="crypto"><div class="left"><span class="chip-dot" style="background:#D3968C;"></span><span>Cryptocurrency</span><span class="chip-count">{{ $assets->where('type','crypto')->count() }}</span></div><i class="fas fa-check check-icon"></i></div>
        <div class="drawer-chip" data-filter="precious_metal"><div class="left"><span class="chip-dot" style="background:#7C3AED;"></span><span>Logam Mulia</span><span class="chip-count">{{ $assets->where('type','precious_metal')->count() }}</span></div><i class="fas fa-check check-icon"></i></div>
    </div>
    <button class="btn-apply-filter" id="btnApplyFilter"><i class="fas fa-check me-2"></i>Terapkan Filter</button>
</div>

<!-- Purchase Modal -->
<div class="modal fade" id="purchaseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-shopping-cart me-2"></i>Beli <span id="modalAssetName">Aset</span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('purchase.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="asset_id" id="assetId">
                    <input type="hidden" id="assetCurrency">
                    <input type="hidden" name="purchase_price" id="purchasePriceInput">
                    <div class="alert alert-info mb-3 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><strong id="modalAssetSymbol">-</strong> <span class="currency-tag ms-1" id="modalCurrencyBadge">-</span></div>
                            <div><strong>Harga: </strong><span id="modalAssetPrice" class="fw-bold" style="color:#105666;">-</span></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Jumlah</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="0.001" step="0.001" required>
                        <small class="text-muted">Jumlah aset yang ingin dibeli</small>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Total Pembayaran</label>
                        <div class="alert alert-success mb-0 py-2">
                            <h5 class="mb-0" id="totalPrice">-</h5>
                            <small class="text-muted" id="conversionNote"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-purchase"><i class="fas fa-check me-1"></i>Konfirmasi Beli</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ✅ Sell Modal --}}
<div class="modal fade" id="sellModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#B8705E,#991B1B);">
                <h5 class="modal-title" style="color:#fff!important;">
                    <i class="fas fa-sign-out-alt me-2"></i>Jual <span id="sellModalAssetName">Aset</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="sellForm" method="POST">
                @csrf @method('DELETE')
                <div class="modal-body">
                    {{-- Info aset --}}
                    <div class="alert alert-info mb-3 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong id="sellModalSymbol">-</strong>
                                <span class="currency-tag ms-1" id="sellModalCurrency">-</span>
                            </div>
                            <div>
                                <strong>Harga Kini: </strong>
                                <span id="sellModalPrice" class="fw-bold" style="color:#105666;">-</span>
                            </div>
                        </div>
                        <div class="mt-1" style="font-size:.8rem;color:#3D5243;">
                            Kepemilikan: <strong id="sellModalQtyOwned">-</strong>
                        </div>
                    </div>

                    {{-- Input jumlah --}}
                    <div class="mb-2">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Jumlah yang Dijual</label>
                        <input type="number" class="form-control" id="sellQty" name="sell_quantity"
                               min="0.0001" step="0.0001" required placeholder="0.0000">
                        <small class="text-muted">Maks: <span id="sellMaxQty">-</span></small>
                    </div>

                    {{-- Quick buttons --}}
                    <div class="d-flex gap-2 mb-3 flex-wrap">
                        <button type="button" class="sell-quick-btn" data-pct="0.25">25%</button>
                        <button type="button" class="sell-quick-btn" data-pct="0.5">50%</button>
                        <button type="button" class="sell-quick-btn" data-pct="0.75">75%</button>
                        <button type="button" class="sell-quick-btn" data-pct="1">Semua</button>
                    </div>

                    {{-- Preview hasil jual --}}
                    <div class="sell-preview" id="sellPreview">
                        <div class="sell-preview-row">
                            <span class="sell-preview-label">Jumlah dijual</span>
                            <span class="sell-preview-val" id="previewQty">-</span>
                        </div>
                        <div class="sell-preview-row">
                            <span class="sell-preview-label">Harga jual/unit</span>
                            <span class="sell-preview-val" id="previewUnitPrice">-</span>
                        </div>
                        <div class="sell-preview-row">
                            <span class="sell-preview-label">Sisa kepemilikan</span>
                            <span class="sell-preview-val" id="previewRemaining">-</span>
                        </div>
                        <div class="sell-preview-row">
                            <span class="sell-preview-label">Estimasi diterima</span>
                            <span class="sell-preview-val" id="previewTotal" style="color:#0A3323;">-</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sell" id="btnConfirmSell" disabled>
                        <i class="fas fa-check me-1"></i>Konfirmasi Jual
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Top Up Modal -->
<div class="modal fade" id="topupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-wallet me-2"></i>Top Up Saldo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('purchase.topup') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info mb-3 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>Saldo Saat Ini:</strong>
                            <span class="fw-bold" style="color:#105666;">Rp {{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Jumlah Top Up</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="topupAmount" name="amount" min="10000" step="10000" placeholder="Masukkan jumlah" required>
                        </div>
                        <small class="text-muted">Minimal Rp 10,000</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Nominal Cepat</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach([100000,500000,1000000,5000000] as $amt)
                            <button type="button" class="btn btn-outline-primary btn-sm quick-amount" data-amount="{{ $amt }}">
                                Rp {{ number_format($amt,0,',','.') }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Metode Pembayaran</label>
                        <select class="form-select" name="payment_method" required>
                            <option value="">Pilih metode</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet (GoPay, OVO, Dana)</option>
                            <option value="virtual_account">Virtual Account</option>
                            <option value="credit_card">Kartu Kredit</option>
                        </select>
                    </div>
                    <div class="alert alert-success mb-0 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>Saldo Setelah Top Up:</strong>
                            <span class="fw-bold" id="newBalance">Rp {{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-purchase"><i class="fas fa-check me-1"></i>Konfirmasi Top Up</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const USD_TO_IDR    = 15000;
const currentBalance = {{ Auth::user()->wallet->balance ?? 0 }};

// ── Sell modal state ──────────────────────────────────────
let sellCurrentPrice = 0;
let sellCurrentQty   = 0;
let sellCurrency     = 'IDR';

function formatSellPrice(amount, currency) {
    if (currency === 'USD') {
        return '$' + parseFloat(amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    return 'Rp ' + parseFloat(amount).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

// ── Buka sell modal ───────────────────────────────────────
document.querySelectorAll('.btn-sell-open').forEach(btn => {
    btn.addEventListener('click', function () {
        const uaId       = this.dataset.uaId;
        const assetName  = this.dataset.assetName;
        const symbol     = this.dataset.assetSymbol;
        sellCurrentPrice = parseFloat(this.dataset.currentPrice);
        sellCurrentQty   = parseFloat(this.dataset.currentQty);
        sellCurrency     = this.dataset.currency;

        // Set form action ke route destroy
        document.getElementById('sellForm').action = `/purchase/${uaId}`;

        // Isi info modal
        document.getElementById('sellModalAssetName').textContent = assetName;
        document.getElementById('sellModalSymbol').textContent    = symbol;
        document.getElementById('sellModalCurrency').textContent  = sellCurrency;
        document.getElementById('sellModalPrice').textContent     = formatSellPrice(sellCurrentPrice, sellCurrency);
        document.getElementById('sellModalQtyOwned').textContent  = sellCurrentQty.toFixed(4) + ' ' + symbol;
        document.getElementById('sellMaxQty').textContent         = sellCurrentQty.toFixed(4);

        // Reset input & preview
        document.getElementById('sellQty').value        = '';
        document.getElementById('sellQty').max          = sellCurrentQty;
        document.getElementById('sellPreview').classList.remove('show');
        document.getElementById('btnConfirmSell').disabled = true;
    });
});

// ── Hitung preview saat qty berubah ──────────────────────
document.getElementById('sellQty').addEventListener('input', updateSellPreview);

function updateSellPreview() {
    const qty = parseFloat(document.getElementById('sellQty').value) || 0;

    if (qty <= 0 || qty > sellCurrentQty) {
        document.getElementById('sellPreview').classList.remove('show');
        document.getElementById('btnConfirmSell').disabled = true;
        return;
    }

    const totalNative = sellCurrentPrice * qty;
    const totalIdr    = sellCurrency === 'USD' ? totalNative * USD_TO_IDR : totalNative;
    const remaining   = sellCurrentQty - qty;

    document.getElementById('previewQty').textContent       = qty.toFixed(4);
    document.getElementById('previewUnitPrice').textContent = formatSellPrice(sellCurrentPrice, sellCurrency);
    document.getElementById('previewRemaining').textContent = remaining.toFixed(4);

    if (sellCurrency === 'USD') {
        document.getElementById('previewTotal').textContent =
            formatSellPrice(totalNative, 'USD') + ' ≈ Rp ' + totalIdr.toLocaleString('id-ID');
    } else {
        document.getElementById('previewTotal').textContent = formatSellPrice(totalIdr, 'IDR');
    }

    document.getElementById('sellPreview').classList.add('show');
    document.getElementById('btnConfirmSell').disabled = false;
}

// ── Quick % buttons ───────────────────────────────────────
document.querySelectorAll('.sell-quick-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const pct = parseFloat(this.dataset.pct);
        const qty = parseFloat((sellCurrentQty * pct).toFixed(4));
        document.getElementById('sellQty').value = qty;
        updateSellPreview();
    });
});

// ── Purchase modal ────────────────────────────────────────
let currentAssetPrice = 0;
let currentCurrency   = 'USD';

document.querySelectorAll('.asset-card').forEach(card => {
    card.addEventListener('click', function () {
        currentAssetPrice = parseFloat(this.dataset.assetPrice);
        currentCurrency   = this.dataset.currency;

        document.getElementById('purchasePriceInput').value        = currentAssetPrice;
        document.getElementById('assetId').value                   = this.dataset.assetId;
        document.getElementById('assetCurrency').value             = currentCurrency;
        document.getElementById('modalAssetName').textContent      = this.dataset.assetName;
        document.getElementById('modalAssetSymbol').textContent    = this.dataset.assetSymbol;
        document.getElementById('modalCurrencyBadge').textContent  = currentCurrency;
        document.getElementById('modalAssetPrice').textContent     =
            currentCurrency === 'USD'
                ? '$' + currentAssetPrice.toLocaleString('en-US', { minimumFractionDigits: 2 })
                : 'Rp ' + currentAssetPrice.toLocaleString('id-ID');
        document.getElementById('quantity').value                  = '';
        document.getElementById('totalPrice').textContent          = '-';
        document.getElementById('conversionNote').textContent      = '';
    });
});

document.getElementById('quantity').addEventListener('input', function () {
    const qty   = parseFloat(this.value) || 0;
    const total = currentAssetPrice * qty;
    if (qty > 0) {
        if (currentCurrency === 'USD') {
            document.getElementById('totalPrice').innerHTML =
                '<strong>$' + total.toLocaleString('en-US', { minimumFractionDigits: 2 }) + '</strong>';
            document.getElementById('conversionNote').innerHTML =
                '≈ Rp ' + (total * USD_TO_IDR).toLocaleString('id-ID') + ' (kurs $1 = Rp ' + USD_TO_IDR.toLocaleString('id-ID') + ')';
        } else {
            document.getElementById('totalPrice').innerHTML =
                '<strong>Rp ' + total.toLocaleString('id-ID') + '</strong>';
            document.getElementById('conversionNote').textContent = '';
        }
    } else {
        document.getElementById('totalPrice').textContent     = '-';
        document.getElementById('conversionNote').textContent = '';
    }
});

// ── Top up modal ──────────────────────────────────────────
document.querySelectorAll('.quick-amount').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('topupAmount').value = this.dataset.amount;
        calcNewBalance();
    });
});
document.getElementById('topupAmount').addEventListener('input', calcNewBalance);
function calcNewBalance() {
    const amt = parseFloat(document.getElementById('topupAmount').value) || 0;
    document.getElementById('newBalance').textContent = 'Rp ' + (currentBalance + amt).toLocaleString('id-ID');
}

// ── Asset filter (desktop) ────────────────────────────────
document.querySelectorAll('.filter-chip').forEach(chip => {
    chip.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        syncDrawerFromChips();
        filterAssets();
    });
});
document.getElementById('assetSearch').addEventListener('input', filterAssets);
document.getElementById('assetSearchMobile').addEventListener('input', filterAssets);

// ── Filter Drawer ─────────────────────────────────────────
const filterDrawer  = document.getElementById('filterDrawer');
const filterOverlay = document.getElementById('filterOverlay');
const btnOpen       = document.getElementById('btnOpenFilterDrawer');
const btnClose      = document.getElementById('btnCloseFilterDrawer');
const btnApply      = document.getElementById('btnApplyFilter');

function openDrawer()  { filterDrawer.classList.add('open'); filterOverlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeDrawer() { filterDrawer.classList.remove('open'); filterOverlay.classList.remove('open'); document.body.style.overflow = ''; }

btnOpen.addEventListener('click', openDrawer);
btnClose.addEventListener('click', closeDrawer);
filterOverlay.addEventListener('click', closeDrawer);

document.querySelectorAll('.drawer-chip').forEach(chip => {
    chip.addEventListener('click', function () {
        document.querySelectorAll('.drawer-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
    });
});

btnApply.addEventListener('click', function () {
    const active    = document.querySelector('.drawer-chip.active');
    const filterVal = active ? active.dataset.filter : 'all';
    document.querySelectorAll('.filter-chip').forEach(c => {
        c.classList.toggle('active', c.dataset.filter === filterVal);
    });
    btnOpen.classList.toggle('has-filter', filterVal !== 'all');
    filterAssets();
    closeDrawer();
});

function syncDrawerFromChips() {
    const activeChip = document.querySelector('.filter-chip.active');
    const filterVal  = activeChip ? activeChip.dataset.filter : 'all';
    document.querySelectorAll('.drawer-chip').forEach(c => {
        c.classList.toggle('active', c.dataset.filter === filterVal);
    });
}

function filterAssets() {
    const type         = (document.querySelector('.filter-chip.active') || {}).dataset?.filter || 'all';
    const queryDesktop = document.getElementById('assetSearch').value.toLowerCase().trim();
    const queryMobile  = document.getElementById('assetSearchMobile').value.toLowerCase().trim();
    const query        = queryDesktop || queryMobile;
    let visible        = 0;

    document.querySelectorAll('#assetGrid .asset-card').forEach(card => {
        const show = (type === 'all' || card.dataset.filter === type) && (!query || card.dataset.name.includes(query));
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('noAssets').style.display = visible === 0 ? '' : 'none';
}
</script>
@endpush