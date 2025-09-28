<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageView;

class TrackPageView
{
    public function handle(Request $request, Closure $next)
    {
        // শুধুমাত্র GET requests track করা
        if ($request->isMethod('get')) {
            $path = $request->path(); // যেমন: /about, /contact

            // যদি entry থাকে, increment views, else create
            $pageView = PageView::firstOrCreate(
                ['page' => '/' . $path], // db column 'page'
                ['views' => 0]           // default
            );

            $pageView->increment('views');
        }

        return $next($request);
    }
}
