<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageView;

class AnalyticsController extends Controller
{
    public function popularPages()
    {
        $popular = PageView::selectRaw('page, SUM(views) as total_views')
            ->groupBy('page')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        return view('dashboard.pages.popular_pages', compact('popular'));
    }
}
