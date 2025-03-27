<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $highlightNews = Berita::where('is_highlight', true)
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        $latestNews = Berita::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('highlightNews', 'latestNews'));
    }
} 