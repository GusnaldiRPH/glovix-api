<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetPrice;
use App\Services\TwelveDataService;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    private $twelveData;

    public function __construct(TwelveDataService $twelveData)
    {
        $this->twelveData = $twelveData;
    }

    /**
     * Display chart page
     */
    public function index()
    {
        $assets = Asset::all();
        return view('user.charts.index', compact('assets'));
    }

    /**
     * Get chart data for specific asset and period
     */
    public function getData($assetId, Request $request)
    {
        $asset  = Asset::findOrFail($assetId);
        $period = $request->get('period', 30); // Default 30 hari
        
        $formattedSymbol = TwelveDataService::formatSymbol($asset->symbol, $asset->type);

        // 🎯 STRATEGI 1: Pilih source API berdasarkan type
        if ($asset->type === 'stock') {
            $apiData = $this->twelveData->getTimeSeriesIDX($formattedSymbol, $period);
        } elseif ($asset->type === 'precious_metal' && $asset->symbol === 'XAU/USD') {
            $apiData = $this->twelveData->getTimeSeries($formattedSymbol, '1day', $period);
        } elseif ($asset->type === 'precious_metal') {
            $apiData = $this->twelveData->getTimeSeriesMetal($asset->symbol, $period);
        } else {
            // Crypto atau lainnya
            $apiData = $this->twelveData->getTimeSeries($formattedSymbol, '1day', $period);
        }

        if ($apiData && isset($apiData['values']) && count($apiData['values']) > 0) {
            $labels = [];
            $prices = [];

            // Reverse untuk crypto dan XAU/USD
            $values = ($asset->type === 'crypto' || $asset->symbol === 'XAU/USD')
                ? array_reverse(array_values($apiData['values']))
                : array_values($apiData['values']);

            foreach ($values as $value) {
                $labels[] = $this->formatDateLabel($value['datetime'], $period);
                $prices[] = floatval($value['close']);

                // Simpan ke database untuk historical data
                AssetPrice::updateOrCreate(
                    [
                        'asset_id'   => $asset->id,
                        'price_date' => $value['datetime'],
                    ],
                    [
                        'price'  => $value['close'],
                        'open'   => $value['open'] ?? null,
                        'high'   => $value['high'] ?? null,
                        'low'    => $value['low'] ?? null,
                        'volume' => $value['volume'] ?? null,
                    ]
                );
            }

            return response()->json([
                'labels' => $labels,
                'prices' => $prices,
                'source' => 'api',
            ]);
        }

        // 🎯 STRATEGI 2: Fallback ke database
        $historicalData = AssetPrice::getChartData($asset->id, $period);

        if ($historicalData->count() > 0) {
            $labels = [];
            $prices = [];

            foreach ($historicalData as $data) {
                $labels[] = $this->formatDateLabel($data->price_date->format('Y-m-d'), $period);
                $prices[] = floatval($data->price);
            }

            return response()->json([
                'labels' => $labels,
                'prices' => $prices,
                'source' => 'database',
            ]);
        }

        // 🎯 STRATEGI 3: Last resort - simulated data
        return $this->getSimulatedData($asset, $period);
    }

    /**
     * Format date label berdasarkan period
     */
    private function formatDateLabel($datetime, $period)
    {
        $timestamp = is_string($datetime) ? strtotime($datetime) : $datetime;
        
        if ($period == 1) {
            // 1 Day: Show hours (H:i)
            return date('H:i', $timestamp);
        } elseif ($period <= 7) {
            // 1 Week: Show day (d M)
            return date('d M', $timestamp);
        } elseif ($period <= 30) {
            // 1 Month: Show date (M d)
            return date('M d', $timestamp);
        } else {
            // 1 Year: Show month (M Y)
            return date('M Y', $timestamp);
        }
    }

    /**
     * Generate simulated data dengan period support
     */
    private function getSimulatedData($asset, $period = 30)
    {
        $data       = ['labels' => [], 'prices' => []];
        $basePrice  = $asset->current_price;
        $volatility = $basePrice * 0.02; // 2% volatility

        // Tentukan jumlah data points dan format
        if ($period == 1) {
            // 1 Day = 24 hours
            $dataPoints = 24;
            
            for ($i = $dataPoints - 1; $i >= 0; $i--) {
                $data['labels'][] = now()->subHours($i)->format('H:i');
                $randomChange     = (rand(-100, 100) / 100) * $volatility;
                $data['prices'][] = round($basePrice + $randomChange, 2);
            }
            
        } elseif ($period == 7) {
            // 1 Week = 7 days
            $dataPoints = 7;
            
            for ($i = $dataPoints - 1; $i >= 0; $i--) {
                $data['labels'][] = now()->subDays($i)->format('d M');
                $randomChange     = (rand(-100, 100) / 100) * $volatility;
                $data['prices'][] = round($basePrice + $randomChange, 2);
            }
            
        } elseif ($period == 30) {
            // 1 Month = 30 days
            $dataPoints = 30;
            
            for ($i = $dataPoints - 1; $i >= 0; $i--) {
                $data['labels'][] = now()->subDays($i)->format('M d');
                $randomChange     = (rand(-100, 100) / 100) * $volatility;
                $data['prices'][] = round($basePrice + $randomChange, 2);
            }
            
        } else {
            // 1 Year = 12 months (monthly data)
            $dataPoints = 12;
            
            for ($i = $dataPoints - 1; $i >= 0; $i--) {
                $data['labels'][] = now()->subMonths($i)->format('M Y');
                $randomChange     = (rand(-100, 100) / 100) * $volatility;
                $data['prices'][] = round($basePrice + $randomChange, 2);
            }
        }

        return response()->json([
            'labels' => $data['labels'],
            'prices' => $data['prices'],
            'source' => 'simulated',
        ]);
    }
}