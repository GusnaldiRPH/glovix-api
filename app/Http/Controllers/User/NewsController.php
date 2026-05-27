<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.news.index', compact('news'));
    }

    public function show($id)
    {
        $newsItem = News::where('is_published', true)->findOrFail($id);
        return view('user.news.show', compact('newsItem'));
    }
}