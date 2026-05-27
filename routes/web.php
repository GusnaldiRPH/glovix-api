<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\NewsController as UserNewsController;
use App\Http\Controllers\User\ChartController;
use App\Http\Controllers\User\EducationController;
use App\Http\Controllers\User\PurchaseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\SalesController;

// Welcome Page (halaman pertama, tanpa auth)
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Redirect root ke welcome jika belum login, ke home jika sudah login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('home')
        : redirect()->route('welcome');
});

// Auth Routes
Auth::routes();

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [UserNewsController::class, 'index'])->name('index');
        Route::get('/{id}', [UserNewsController::class, 'show'])->name('show');
    });
    
    Route::prefix('charts')->name('charts.')->group(function () {
        Route::get('/', [ChartController::class, 'index'])->name('index');
        Route::get('/data/{assetId}', [ChartController::class, 'getData'])->name('data');
    });
    
    Route::prefix('education')->name('education.')->group(function () {
        Route::get('/', [EducationController::class, 'index'])->name('index');
        Route::get('/{id}', [EducationController::class, 'show'])->name('show');
        Route::post('/{id}/complete', [EducationController::class, 'complete'])->name('complete');
    });
    
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('index');
        Route::post('/store', [PurchaseController::class, 'store'])->name('store');
        Route::post('/topup', [PurchaseController::class, 'topup'])->name('topup');
        Route::delete('/{id}', [PurchaseController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        // Tandai satu notifikasi sebagai sudah dibaca
        Route::post('/{id}/read', function ($id) {
            $notif = Auth::user()->notifications()->findOrFail($id);
            $notif->markAsRead();
            return response()->json(['success' => true]);
        })->name('read');
    
        // Tandai semua sebagai sudah dibaca
        Route::post('/read-all', function () {
            Auth::user()->unreadNotifications->markAsRead();
            return redirect()->back()->with('success', 'Semua notifikasi ditandai dibaca.');
        })->name('readAll');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('news', AdminNewsController::class);
    Route::resource('videos', VideoController::class);
    
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [SalesController::class, 'index'])->name('index');
    });
});