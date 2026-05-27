<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TwelveDataService
{
    private $apiKey;
    private $baseUrl = 'https://api.twelvedata.com';
    private $cacheDuration = 60;

    public function __construct()
    {
        $this->apiKey = config('services.twelvedata.api_key');
    }

    /**
     * Get real-time price dari Twelve Data (crypto & XAU/USD)
     */
    public function getPrice($symbol)
    {
        $cacheKey = "price_{$symbol}";

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($symbol) {
            try {
                $response = Http::timeout(10)->get("{$this->baseUrl}/price", [
                    'symbol' => $symbol,
                    'apikey' => $this->apiKey,
                ]);

                $data = $response->json();
                Log::info("TwelveData [{$symbol}]: " . json_encode($data));

                if ($response->successful()) {
                    if (isset($data['status']) && $data['status'] === 'error') {
                        Log::error('TwelveData API Error: ' . ($data['message'] ?? 'Unknown'));
                        return null;
                    }
                    return $data;
                }

                return null;
            } catch (\Exception $e) {
                Log::error('TwelveData Exception: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get real-time price saham IDX dari Yahoo Finance
     * Format: BBCA:IDX → BBCA.JK
     */
    public function getStockPriceIDX($symbol)
    {
        $yahooSymbol = str_replace(':IDX', '.JK', $symbol);
        $cacheKey    = "price_yahoo_{$yahooSymbol}";

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($yahooSymbol) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                    ->get("https://query1.finance.yahoo.com/v8/finance/chart/{$yahooSymbol}");

                $data = $response->json();
                Log::info("Yahoo Finance [{$yahooSymbol}]: " . json_encode($data));

                if ($response->successful()) {
                    $price = $data['chart']['result'][0]['meta']['regularMarketPrice'] ?? null;
                    if ($price) return ['price' => $price];
                }

                return null;
            } catch (\Exception $e) {
                Log::error('Yahoo Finance Exception: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get precious metal price dari Yahoo Finance Futures
     * XAU/USD → GC=F, XAG/USD → SI=F, XPT/USD → PL=F, XPD/USD → PA=F
     */
    public function getPreciousMetalPrice($symbol)
    {
        $yahooMap = [
            'XAU/USD' => 'GC=F',
            'XAG/USD' => 'SI=F',
            'XPT/USD' => 'PL=F',
            'XPD/USD' => 'PA=F',
        ];

        $yahooSymbol = $yahooMap[$symbol] ?? null;
        if (!$yahooSymbol) return null;

        $cacheKey = "price_metal_{$yahooSymbol}";

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($yahooSymbol, $symbol) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                    ->get("https://query1.finance.yahoo.com/v8/finance/chart/{$yahooSymbol}");

                $data = $response->json();
                Log::info("Yahoo Metal [{$yahooSymbol}] ({$symbol}): " . json_encode($data));

                if ($response->successful()) {
                    $price = $data['chart']['result'][0]['meta']['regularMarketPrice'] ?? null;
                    if ($price) return ['price' => $price];
                }

                return null;
            } catch (\Exception $e) {
                Log::error('Yahoo Metal Exception: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get historical time series dari Twelve Data (crypto & XAU/USD)
     */
    public function getTimeSeries($symbol, $interval = '1day', $outputsize = 30)
    {
        $cacheKey = "timeseries_{$symbol}_{$interval}_{$outputsize}";

        return Cache::remember($cacheKey, 300, function () use ($symbol, $interval, $outputsize) {
            try {
                $response = Http::timeout(15)->get("{$this->baseUrl}/time_series", [
                    'symbol'     => $symbol,
                    'interval'   => $interval,
                    'outputsize' => $outputsize,
                    'apikey'     => $this->apiKey,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                return null;
            } catch (\Exception $e) {
                Log::error('TwelveData TimeSeries Exception: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get historical time series saham IDX dari Yahoo Finance
     * Format: BBCA:IDX → BBCA.JK
     */
    public function getTimeSeriesIDX($symbol, $days = 30)
    {
        $yahooSymbol = str_replace(':IDX', '.JK', $symbol);
        $cacheKey    = "timeseries_yahoo_{$yahooSymbol}_{$days}";

        return Cache::remember($cacheKey, 300, function () use ($yahooSymbol, $days) {
            try {
                $period1 = now()->subDays($days)->timestamp;
                $period2 = now()->timestamp;

                $response = Http::timeout(10)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                    ->get("https://query1.finance.yahoo.com/v8/finance/chart/{$yahooSymbol}", [
                        'period1'  => $period1,
                        'period2'  => $period2,
                        'interval' => '1d',
                    ]);

                $data = $response->json();
                Log::info("Yahoo TimeSeries [{$yahooSymbol}]: " . json_encode($data));

                if ($response->successful()) {
                    $timestamps = $data['chart']['result'][0]['timestamp'] ?? [];
                    $quotes     = $data['chart']['result'][0]['indicators']['quote'][0] ?? [];
                    $closes     = $quotes['close'] ?? [];

                    if (empty($timestamps)) return null;

                    $values = [];
                    foreach ($timestamps as $i => $timestamp) {
                        if (!isset($closes[$i]) || $closes[$i] === null) continue;

                        $values[] = [
                            'datetime' => date('Y-m-d', $timestamp),
                            'close'    => $closes[$i],
                            'open'     => $quotes['open'][$i] ?? null,
                            'high'     => $quotes['high'][$i] ?? null,
                            'low'      => $quotes['low'][$i] ?? null,
                        ];
                    }

                    return ['values' => $values];
                }

                return null;
            } catch (\Exception $e) {
                Log::error('Yahoo TimeSeries Exception: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get historical time series logam mulia dari Yahoo Finance Futures
     */
    public function getTimeSeriesMetal($symbol, $days = 30)
    {
        $yahooMap = [
            'XAU/USD' => 'GC=F',
            'XAG/USD' => 'SI=F',
            'XPT/USD' => 'PL=F',
            'XPD/USD' => 'PA=F',
        ];

        $yahooSymbol = $yahooMap[$symbol] ?? null;
        if (!$yahooSymbol) return null;

        $cacheKey = "timeseries_metal_{$yahooSymbol}_{$days}";

        return Cache::remember($cacheKey, 300, function () use ($yahooSymbol, $days) {
            try {
                $period1 = now()->subDays($days)->timestamp;
                $period2 = now()->timestamp;

                $response = Http::timeout(10)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                    ->get("https://query1.finance.yahoo.com/v8/finance/chart/{$yahooSymbol}", [
                        'period1'  => $period1,
                        'period2'  => $period2,
                        'interval' => '1d',
                    ]);

                $data = $response->json();
                Log::info("Yahoo Metal TimeSeries [{$yahooSymbol}]: " . json_encode($data));

                if ($response->successful()) {
                    $timestamps = $data['chart']['result'][0]['timestamp'] ?? [];
                    $quotes     = $data['chart']['result'][0]['indicators']['quote'][0] ?? [];
                    $closes     = $quotes['close'] ?? [];

                    if (empty($timestamps)) return null;

                    $values = [];
                    foreach ($timestamps as $i => $timestamp) {
                        if (!isset($closes[$i]) || $closes[$i] === null) continue;

                        $values[] = [
                            'datetime' => date('Y-m-d', $timestamp),
                            'close'    => $closes[$i],
                            'open'     => $quotes['open'][$i] ?? null,
                            'high'     => $quotes['high'][$i] ?? null,
                            'low'      => $quotes['low'][$i] ?? null,
                        ];
                    }

                    return ['values' => $values];
                }

                return null;
            } catch (\Exception $e) {
                Log::error('Yahoo Metal TimeSeries Exception: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Format symbol based on asset type
     */
    public static function formatSymbol($symbol, $type)
    {
        switch ($type) {
            case 'crypto':
                return str_contains($symbol, '/') ? $symbol : "{$symbol}/USD";

            case 'stock':
                // BBCA.IDX → BBCA:IDX
                return str_replace('.', ':', $symbol);

            case 'precious_metal':
                return str_contains($symbol, '/') ? $symbol : "{$symbol}/USD";

            default:
                return $symbol;
        }
    }
}