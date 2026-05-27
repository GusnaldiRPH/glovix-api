@extends('layouts.user')

@section('title', 'Glovix.Co - Grafik')

@push('styles')
<style>
    .chart-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .chart-header {
        background: var(--bg-white);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .instrument-selector { position: relative; }

    .instrument-dropdown {
        background: var(--bg-white);
        border: 1px solid #D4CFA0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-weight: 600;
        color: #0A3323;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-width: 280px;
        transition: all 0.3s ease;
    }
    .instrument-dropdown:hover {
        border-color: #839958;
        box-shadow: 0 2px 8px rgba(131,153,88,.15);
    }

    .instrument-badge {
        background: #EDE9BF;
        color: #7A8C6E;
        padding: 0.25rem 0.6rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-left: 0.5rem;
    }

    .currency-badge {
        background: linear-gradient(135deg, #EEF2E3, #DDE5C8);
        color: #105666;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    .instrument-menu {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--bg-white);
        border: 1px solid #D4CFA0;
        border-radius: 8px;
        margin-top: 0.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        max-height: 400px;
        overflow-y: auto;
        z-index: 100;
        display: none;
    }
    .instrument-menu.show { display: block; }

    .instrument-menu-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #EDE9BF;
    }
    .instrument-menu-item:last-child { border-bottom: none; }
    .instrument-menu-item:hover { background: #EEF2E3; }
    .instrument-menu-item.active { background: #EEF2E3; color: #105666; }

    .period-selector { display: flex; gap: 0.5rem; }

    .period-btn {
        background: var(--bg-white);
        border: 1px solid #D4CFA0;
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        color: #7A8C6E;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }
    .period-btn:hover { border-color: #839958; color: #105666; }
    .period-btn.active {
        background: linear-gradient(135deg, #839958, #105666);
        border-color: #839958;
        color: white;
    }

    .live-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #839958;
        font-weight: 600;
        font-size: 0.875rem;
    }
    .live-dot {
        width: 8px; height: 8px;
        background: #839958;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .main-chart-section { display: flex; gap: 1.5rem; }

    .chart-main {
        flex: 1;
        background: var(--bg-white) !important;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .price-display { margin-bottom: 1.5rem; }

    .asset-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0A3323;
        margin-bottom: 0.25rem;
    }
    .asset-symbol {
        color: #7A8C6E;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .current-price {
        font-size: 2.5rem;
        font-weight: 700;
        color: #0A3323;
        margin: 0.5rem 0;
    }
    .price-change { font-size: 1rem; font-weight: 600; }
    .price-change.positive { color: #839958; }
    .price-change.negative { color: #ef4444; }

    .stats-row {
        display: flex;
        gap: 3rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #EDE9BF;
    }
    .stat-item { flex: 1; }
    .stat-label { color: #7A8C6E; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem; }
    .stat-value { color: #0A3323; font-size: 1.125rem; font-weight: 700; }

    /* Market Summary */
    .market-summary {
        width: 320px;
        background: var(--bg-white);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        max-height: calc(100vh - 250px);
        overflow-y: auto;
    }
    .market-summary-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.125rem;
        font-weight: 700;
        color: #0A3323;
        margin-bottom: 1.5rem;
    }
    .category-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #7A8C6E;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 1.25rem 0 0.75rem 0;
        padding-left: 0.25rem;
    }
    .category-label:first-child { margin-top: 0; }

    .summary-item {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .summary-item:hover { background: #EEF2E3; }
    .summary-item.active {
        background: linear-gradient(135deg, #839958, #105666);
        color: white;
    }
    .summary-item.active .summary-symbol,
    .summary-item.active .summary-type,
    .summary-item.active .currency-badge {
        color: rgba(255, 255, 255, 0.8);
        background: rgba(255, 255, 255, 0.2);
    }
    .summary-item.active .summary-price,
    .summary-item.active .summary-change,
    .summary-item.active .summary-name { color: white !important; }

    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.25rem;
    }
    .summary-name { font-weight: 600; color: #0A3323; font-size: 0.95rem; }
    .summary-price { font-weight: 700; color: #0A3323; font-size: 0.95rem; }
    .summary-footer { display: flex; justify-content: space-between; align-items: center; }
    .summary-info { display: flex; gap: 0.5rem; align-items: center; }
    .summary-symbol { color: #7A8C6E; font-size: 0.8rem; font-weight: 500; }
    .summary-type { background: #EDE9BF; color: #7A8C6E; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.7rem; font-weight: 500; }
    .summary-change { font-size: 0.85rem; font-weight: 600; }
    .summary-change.positive { color: #839958; }
    .summary-change.negative { color: #ef4444; }
    .summary-change.loading { color: #D4CFA0; }

    .market-summary::-webkit-scrollbar { width: 6px; }
    .market-summary::-webkit-scrollbar-track { background: #EDE9BF; border-radius: 10px; }
    .market-summary::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    .market-summary::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

    #priceChart { max-height: 400px; }

    /* ── Mobile Drawer ── */
    @media (max-width: 991px) {
        .main-chart-section { flex-direction: column; }

        .market-summary {
            position: fixed !important;
            top: 0; right: 0;
            width: 300px !important;
            max-width: 85vw;
            height: 100dvh !important;
            max-height: 100dvh !important;
            border-radius: 16px 0 0 16px !important;
            z-index: 1050;
            transform: translateX(100%);
            transition: transform .32s cubic-bezier(.4,0,.2,1);
            box-shadow: -4px 0 24px rgba(0,0,0,.12) !important;
            padding-top: 3.5rem !important;
        }
        .market-summary.open { transform: translateX(0); }

        .ms-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(10,51,35,.35);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            z-index: 1049;
        }
        .ms-overlay.open { display: block; }

        .ms-pull-tab {
            position: fixed;
            right: 0; top: 50%;
            transform: translateY(-50%);
            z-index: 1051;
            background: linear-gradient(135deg, #0A3323, #105666);
            color: #fff;
            border-radius: 10px 0 0 10px;
            padding: .65rem .5rem;
            cursor: pointer;
            display: flex; flex-direction: column;
            align-items: center; gap: .35rem;
            box-shadow: -2px 0 12px rgba(0,0,0,.18);
            transition: padding .2s, right .32s cubic-bezier(.4,0,.2,1);
            user-select: none;
        }
        .ms-pull-tab:hover { padding-right: .75rem; }
        .ms-pull-tab.hidden { right: -60px; }
        .ms-pull-tab i { font-size: .8rem; color: #fff !important; }
        .ms-pull-tab .tab-label {
            writing-mode: vertical-rl; text-orientation: mixed;
            font-size: .62rem; font-weight: 700;
            color: rgba(255,255,255,.85) !important;
            letter-spacing: .06em; text-transform: uppercase;
        }

        .ms-close-btn {
            position: absolute; top: .85rem; right: .85rem;
            background: var(--bg-soft); border: 1px solid var(--border);
            border-radius: 50%; width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--text-secondary) !important;
            font-size: .8rem; transition: .2s;
        }
        .ms-close-btn:hover { background: var(--amber-100); }
        .ms-close-btn i { color: inherit !important; }
    }

    @media (min-width: 992px) {
        .ms-pull-tab, .ms-overlay, .ms-close-btn { display: none !important; }
    }

    /* ── Mobile price & stats ── */
    @media (max-width: 767px) {
        .asset-title { font-size: 1.1rem; }
        .asset-symbol { font-size: 0.78rem; }
        .current-price { font-size: 1.6rem; }
        .price-change { font-size: 0.8rem; }
        .stats-row {
            gap: 0 !important;
            margin-bottom: 1rem; padding-bottom: 1rem;
            justify-content: space-between;
        }
        .stat-item { flex: 0 0 auto !important; min-width: 0; }
        .stat-label { font-size: 0.72rem; }
        .stat-value { font-size: 0.85rem; white-space: nowrap; }
        .chart-main { padding: 1.25rem; }
        .chart-header { padding: 1.25rem; }
        .instrument-dropdown { min-width: 0; width: 100%; }
        .period-btn { padding: .4rem .8rem; font-size: .8rem; }
    }
</style>
@endpush

@section('content')
<div class="chart-container py-4">

    <!-- Top Section -->
    <div class="chart-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex gap-4 align-items-center flex-wrap">

                <!-- Instrumen Selector -->
                <div>
                    <label class="text-muted mb-2 d-block fw-semibold" style="font-size:0.875rem;">Instrumen</label>
                    <div class="instrument-selector">
                        <div class="instrument-dropdown" id="instrumentDropdown">
                            <div>
                                <span id="selectedAssetName">Pilih Instrumen</span>
                                <span class="instrument-badge" id="selectedAssetType">-</span>
                                <span class="currency-badge" id="selectedCurrency">-</span>
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="instrument-menu" id="instrumentMenu">
                            @foreach($assets as $asset)
                            <div class="instrument-menu-item"
                                 data-asset-id="{{ $asset->id }}"
                                 data-asset-name="{{ $asset->name }}"
                                 data-asset-symbol="{{ $asset->symbol }}"
                                 data-asset-type="{{ $asset->type }}"
                                 data-asset-price="{{ $asset->current_price }}"
                                 data-currency="{{ in_array($asset->type, ['crypto','precious_metal']) ? 'USD' : 'IDR' }}">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $asset->name }}
                                        @if(in_array($asset->type, ['crypto','precious_metal']))
                                            <span class="currency-badge">USD</span>
                                        @else
                                            <span class="currency-badge">IDR</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $asset->symbol }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="instrument-badge">{{ ucfirst($asset->type) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Period Selector -->
                <div>
                    <label class="text-muted mb-2 d-block fw-semibold" style="font-size:0.875rem;">Periode</label>
                    <div class="period-selector">
                        <button class="period-btn" data-period="7">1W</button>
                        <button class="period-btn active" data-period="30">1M</button>
                        <button class="period-btn" data-period="365">1Y</button>
                    </div>
                </div>
            </div>

            <div class="live-indicator">
                <div class="live-dot"></div>
                <span>Live</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-chart-section">

        <!-- Main Chart -->
        <div class="chart-main">
            <div class="price-display">
                <h1 class="asset-title" id="mainAssetName">-</h1>
                <p class="asset-symbol mb-0" id="mainAssetSymbol">-</p>
                <div class="d-flex align-items-baseline gap-3 mt-3">
                    <div class="current-price" id="mainPrice">-</div>
                    <div class="price-change positive" id="mainChange">
                        <i class="summary-change loading" id="change-{{ $asset->id }}">...</i>
                    </div>
                </div>
            </div>

            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-label">Value High</div>
                    <div class="stat-value" id="stat24hHigh">-</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Value Low</div>
                    <div class="stat-value" id="stat24hLow">-</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Volume</div>
                    <div class="stat-value" id="statVolume">-</div>
                </div>
            </div>

            <canvas id="priceChart"></canvas>
        </div>

        {{-- Pull tab mobile --}}
        <div class="ms-pull-tab" id="msPullTab">
            <i class="fas fa-chart-bar"></i>
            <span class="tab-label">Market</span>
        </div>

        {{-- Overlay --}}
        <div class="ms-overlay" id="msOverlay"></div>

        <!-- Market Summary -->
        <div class="market-summary" id="marketSummary">
            <div class="ms-close-btn" id="msCloseBtn">
                <i class="fas fa-times"></i>
            </div>

            <h3 class="market-summary-title">
                <i class="fas fa-chart-line" style="color:#839958;"></i>
                Market Summary
            </h3>

            <div id="marketSummaryList">
                @php
                    $cryptoAssets = $assets->where('type', 'crypto');
                    $stockAssets  = $assets->where('type', 'stock');
                    $metalAssets  = $assets->where('type', 'precious_metal');
                @endphp

                @if($cryptoAssets->count() > 0)
                    <div class="category-label"><i class="fas fa-bitcoin-sign me-1"></i> Cryptocurrency</div>
                    @foreach($cryptoAssets as $asset)
                    <div class="summary-item"
                         data-asset-id="{{ $asset->id }}"
                         data-asset-name="{{ $asset->name }}"
                         data-asset-symbol="{{ $asset->symbol }}"
                         data-asset-type="{{ $asset->type }}"
                         data-asset-price="{{ $asset->current_price }}"
                         data-currency="USD">
                        <div class="summary-header">
                            <div class="summary-name">{{ $asset->symbol }}</div>
                            <div class="summary-price">${{ number_format($asset->current_price, 0, ',', ',') }}</div>
                        </div>
                        <div class="summary-footer">
                            <div class="summary-info">
                                <span class="summary-symbol">{{ $asset->name }}</span>
                                <span class="currency-badge">USD</span>
                            </div>
                            <div class="summary-change loading" id="change-{{ $asset->id }}">...</div>
                        </div>
                    </div>
                    @endforeach
                @endif

                @if($stockAssets->count() > 0)
                    <div class="category-label"><i class="fas fa-chart-line me-1"></i> Saham</div>
                    @foreach($stockAssets->take(4) as $asset)
                    <div class="summary-item"
                         data-asset-id="{{ $asset->id }}"
                         data-asset-name="{{ $asset->name }}"
                         data-asset-symbol="{{ $asset->symbol }}"
                         data-asset-type="{{ $asset->type }}"
                         data-asset-price="{{ $asset->current_price }}"
                         data-currency="IDR">
                        <div class="summary-header">
                            <div class="summary-name">{{ $asset->symbol }}</div>
                            <div class="summary-price">Rp {{ number_format($asset->current_price, 0, ',', '.') }}</div>
                        </div>
                        <div class="summary-footer">
                            <div class="summary-info">
                                <span class="summary-symbol">{{ $asset->name }}</span>
                                <span class="currency-badge">IDR</span>
                            </div>
                            <div class="summary-change loading" id="change-{{ $asset->id }}">...</div>
                        </div>
                    </div>
                    @endforeach
                @endif

                @if($metalAssets->count() > 0)
                    <div class="category-label"><i class="fas fa-coins me-1"></i> Logam Mulia</div>
                    @foreach($metalAssets as $asset)
                    <div class="summary-item"
                         data-asset-id="{{ $asset->id }}"
                         data-asset-name="{{ $asset->name }}"
                         data-asset-symbol="{{ $asset->symbol }}"
                         data-asset-type="{{ $asset->type }}"
                         data-asset-price="{{ $asset->current_price }}"
                         data-currency="USD">
                        <div class="summary-header">
                            <div class="summary-name">{{ $asset->symbol }}</div>
                            <div class="summary-price">${{ number_format($asset->current_price, 0, ',', ',') }}</div>
                        </div>
                        <div class="summary-footer">
                            <div class="summary-info">
                                <span class="summary-symbol">{{ $asset->name }}</span>
                                <span class="currency-badge">USD</span>
                            </div>
                            <div class="summary-change loading" id="change-{{ $asset->id }}">...</div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chart         = null;
let currentAssetId = null;
let currentPeriod  = 30;
let currentCurrency = 'USD';

// ── Currency Formatter ────────────────────────────────────
function formatPrice(price, currency) {
    if (currency === 'USD') {
        return '$' + parseFloat(price).toLocaleString('en-US', {
            minimumFractionDigits: 0, maximumFractionDigits: 2
        });
    }
    return 'Rp ' + parseFloat(price).toLocaleString('id-ID', {
        minimumFractionDigits: 0, maximumFractionDigits: 0
    });
}

// ── Hitung % change dari array harga ─────────────────────
function calcChange(prices) {
    if (!prices || prices.length < 2) return null;
    const first  = prices[0];
    const last   = prices[prices.length - 1];
    return ((last - first) / first) * 100;
}

// ── Dropdown Instrumen ────────────────────────────────────
$('#instrumentDropdown').on('click', function(e) {
    e.stopPropagation();
    $('#instrumentMenu').toggleClass('show');
});
$(document).on('click', function() {
    $('#instrumentMenu').removeClass('show');
});

// ── Pilih Instrumen ───────────────────────────────────────
$('.instrument-menu-item, .summary-item').on('click', function() {
    const assetId    = $(this).data('asset-id');
    const assetName  = $(this).data('asset-name');
    const assetSymbol= $(this).data('asset-symbol');
    const assetType  = $(this).data('asset-type');
    const assetPrice = $(this).data('asset-price');
    const currency   = $(this).data('currency') || 'USD';

    currentCurrency = currency;

    $('#selectedAssetName').text(assetName);
    $('#selectedAssetType').text(assetType);
    $('#selectedCurrency').text(currency);

    $('#mainAssetName').text(assetName);
    $('#mainAssetSymbol').text(assetSymbol);
    $('#mainPrice').text(formatPrice(assetPrice, currency));

    $('.instrument-menu-item, .summary-item').removeClass('active');
    $(`.instrument-menu-item[data-asset-id="${assetId}"], .summary-item[data-asset-id="${assetId}"]`).addClass('active');

    $('#instrumentMenu').removeClass('show');

    currentAssetId = assetId;
    loadChart(assetId, currentPeriod);
});

// ── Pilih Periode ─────────────────────────────────────────
$('.period-btn').on('click', function() {
    $('.period-btn').removeClass('active');
    $(this).addClass('active');
    currentPeriod = $(this).data('period');
    if (currentAssetId) loadChart(currentAssetId, currentPeriod);
});

// ── Load Chart ────────────────────────────────────────────
function loadChart(assetId, period) {
    $.ajax({
        url: `/charts/data/${assetId}`,
        method: 'GET',
        data: { period: period },
        success: function(data) {
            if (chart) chart.destroy();

            const ctx = document.getElementById('priceChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(106, 156, 119, 0.2)');
            gradient.addColorStop(1, 'rgba(106, 156, 119, 0.01)');

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.prices,
                        borderColor: '#839958',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#839958',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(31,41,55,.95)',
                            padding: 12, cornerRadius: 8, displayColors: false,
                            callbacks: {
                                label: ctx => formatPrice(ctx.parsed.y, currentCurrency)
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: { color: 'rgba(229,231,235,.3)', drawBorder: false },
                            ticks: {
                                font: { size: 11 }, color: '#9ca3af',
                                callback: v => formatPrice(v, currentCurrency)
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 }, color: '#9ca3af' }
                        }
                    }
                }
            });

            updateStats(data.prices);
        }
    });
}

// ── Update Stats + % Change Utama ─────────────────────────
function updateStats(prices) {
    if (!prices || prices.length === 0) return;

    const high   = Math.max(...prices);
    const low    = Math.min(...prices);
    const volume = (Math.random() * 5).toFixed(1);

    $('#stat24hHigh').text(formatPrice(high, currentCurrency));
    $('#stat24hLow').text(formatPrice(low, currentCurrency));
    $('#statVolume').text(volume + 'M');

    // ✅ % change dari harga pertama ke terakhir
    const change = calcChange(prices);
    if (change !== null) {
        const sign = change >= 0 ? '+' : '';
        const icon = change >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
        const cls  = change >= 0 ? 'positive' : 'negative';

        $('#mainChange')
            .removeClass('positive negative')
            .addClass(cls)
            .html(`<i class="fas ${icon} me-1"></i>${sign}${change.toFixed(2)}%`);
    }
}

// ── Load % Change tiap aset di Market Summary ─────────────
function loadSummaryChanges() {
    document.querySelectorAll('.summary-item').forEach(function(item) {
        const assetId = item.dataset.assetId;
        const spanEl  = document.getElementById('change-' + assetId);
        if (!spanEl) return;

        spanEl.className   = 'summary-change loading';
        spanEl.textContent = '...';

        $.ajax({
            url: `/charts/data/${assetId}`,
            method: 'GET',
            data: { period: 7 },
            success: function(data) {
                const change = calcChange(data.prices);
                if (change === null) {
                    spanEl.textContent = '-';
                    return;
                }
                const sign = change >= 0 ? '+' : '';
                const cls  = change >= 0 ? 'positive' : 'negative';
                spanEl.className   = 'summary-change ' + cls;
                spanEl.textContent = sign + change.toFixed(2) + '%';
            },
            error: function() {
                spanEl.className   = 'summary-change';
                spanEl.textContent = '-';
            }
        });
    });
}

// ── Init ──────────────────────────────────────────────────
$(document).ready(function() {
    $('.instrument-menu-item:first').click();
    loadSummaryChanges();
});

// Auto-refresh 30 detik
setInterval(function() {
    if (currentAssetId) loadChart(currentAssetId, currentPeriod);
    loadSummaryChanges();
}, 30000);

// ── Market Summary Drawer (mobile) ────────────────────────
(function() {
    const panel   = document.getElementById('marketSummary');
    const overlay = document.getElementById('msOverlay');
    const pullTab = document.getElementById('msPullTab');
    const closeBtn= document.getElementById('msCloseBtn');

    function openPanel() {
        panel.classList.add('open');
        overlay.classList.add('open');
        pullTab.classList.add('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closePanel() {
        panel.classList.remove('open');
        overlay.classList.remove('open');
        pullTab.classList.remove('hidden');
        document.body.style.overflow = '';
    }

    pullTab.addEventListener('click', openPanel);
    closeBtn.addEventListener('click', closePanel);
    overlay.addEventListener('click', closePanel);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closePanel(); });

    document.querySelectorAll('.summary-item').forEach(function(item) {
        item.addEventListener('click', function() {
            if (window.innerWidth < 992) closePanel();
        });
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            panel.classList.remove('open');
            overlay.classList.remove('open');
            pullTab.classList.remove('hidden');
            document.body.style.overflow = '';
        }
    });
})();
</script>
@endpush