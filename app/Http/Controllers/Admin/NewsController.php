<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;
use App\Models\Video;
use App\Models\Transaction;
use App\Notifications\NewNewsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('author')->orderBy('created_at', 'desc')->paginate(10);

        $totalNews   = News::count();
        $totalUsers  = User::count();
        $totalSales  = Transaction::count(); // ✅ fix di sini
        $totalVideos = Video::count();

        $recentNews   = News::latest()->take(5)->get();
        $recentVideos = Video::latest()->take(5)->get();

        return view('admin.news.index', compact(
            'news',
            'totalNews',
            'totalUsers',
            'totalSales',
            'totalVideos',
            'recentNews',
            'recentVideos'
        ));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $data               = $request->all();
        $data['created_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news = News::create($data);

        // ✅ Kirim notifikasi ke semua user (bukan admin)
        // Hanya kirim jika berita dipublish
        if ($request->boolean('is_published', true)) {
            User::where('is_admin', false)->each(function ($user) use ($news) {
                $user->notify(new NewNewsNotification($news));
            });
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $news = News::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diupdate!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}