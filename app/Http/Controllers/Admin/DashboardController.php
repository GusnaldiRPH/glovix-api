<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\EducationalVideo;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalNews = News::count();
        $totalVideos = EducationalVideo::count();
        $totalUsers = User::where('is_admin', false)->count();
        $totalSales = Transaction::where('type', 'purchase')
            ->where('status', 'completed')
            ->sum('amount');
        
        $recentNews = News::orderBy('created_at', 'desc')->take(5)->get();
        $recentVideos = EducationalVideo::with('level')->orderBy('created_at', 'desc')->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalNews',
            'totalVideos',
            'totalUsers',
            'totalSales',
            'recentNews',
            'recentVideos'
        ));
    }
}