<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageView;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Referral;

use Illuminate\Support\Facades\Schema;

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

    public function liveStats()
    {
        // Today's date range
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();

        // Page View Statistics
        $viewsToday = PageView::whereDate('created_at', $today)->sum('views');
        $viewsYesterday = PageView::whereDate('created_at', $yesterday)->sum('views');
        $viewsThisWeek = PageView::whereBetween('created_at', [$weekStart, Carbon::now()])->sum('views');
        $viewsThisMonth = PageView::whereBetween('created_at', [$monthStart, Carbon::now()])->sum('views');
        
        // Calculate view percentage change
        $viewsChange = $viewsYesterday > 0 
            ? round((($viewsToday - $viewsYesterday) / $viewsYesterday) * 100, 1)
            : 0;

        // Blog Statistics
        $totalBlogs = Blog::count();
        $blogsThisMonth = Blog::whereBetween('created_at', [$monthStart, Carbon::now()])->count();
        
        // Check if views column exists before using it
        $mostViewedBlog = null;
        $popularBlogs = collect();
        
        if (Schema::hasColumn('blogs', 'views')) {
            $mostViewedBlog = Blog::orderBy('views', 'desc')->first();
            $popularBlogs = Blog::withCount('comments')
                ->orderBy('views', 'desc')
                ->limit(5)
                ->get();
        } else {
            // Fallback: use created_at if views column doesn't exist
            $mostViewedBlog = Blog::latest()->first();
            $popularBlogs = Blog::withCount('comments')
                ->latest()
                ->limit(5)
                ->get();
        }

        // Comment Statistics
        $totalComments = BlogComment::count();
        $pendingComments = BlogComment::where('status', 'pending')->count();
        $approvedComments = BlogComment::where('status', 'approved')->count();

        // User Statistics
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereBetween('created_at', [$monthStart, Carbon::now()])->count();

        // Top Pages
        $topPages = PageView::selectRaw('page, SUM(views) as total_views')
            ->groupBy('page')
            ->orderByDesc('total_views')
            ->limit(5)
            ->get();

        // Recent Activity (Last 10 comments)
        $recentComments = BlogComment::with('blog')
            ->latest()
            ->limit(10)
            ->get();

        $liveStats = [
            // Views Data
            'views_today' => $viewsToday,
            'views_yesterday' => $viewsYesterday,
            'views_this_week' => $viewsThisWeek,
            'views_this_month' => $viewsThisMonth,
            'views_change' => $viewsChange,
            'views_change_type' => $viewsChange >= 0 ? 'increase' : 'decrease',

            // Blog Data
            'total_blogs' => $totalBlogs,
            'blogs_this_month' => $blogsThisMonth,
            'most_viewed_blog' => $mostViewedBlog,

            // Comment Data
            'total_comments' => $totalComments,
            'pending_comments' => $pendingComments,
            'approved_comments' => $approvedComments,

            // User Data
            'total_users' => $totalUsers,
            'new_users_this_month' => $newUsersThisMonth,

            // Lists
            'top_pages' => $topPages,
            'recent_comments' => $recentComments,
            'popular_blogs' => $popularBlogs,
            
            // Check if views column exists
            'has_views_column' => Schema::hasColumn('blogs', 'views'),
        ];

        return view('dashboard.pages.live-stats', compact('liveStats'));
    }

     public function topReferrals()
    {
        // Get top referrals (you can replace this with actual data from your tracking)
        $referrals = Referral::orderBy('visit_count', 'desc')
                            ->limit(15)
                            ->get();

        // If no referrals exist, show sample data for demonstration
        if ($referrals->isEmpty()) {
            $referrals = $this->getSampleReferralData();
        }

        // Calculate totals and percentages
        $totalVisits = $referrals->sum('visit_count');
        
        foreach ($referrals as $referral) {
            $referral->percentage = $totalVisits > 0 ? ($referral->visit_count / $totalVisits) * 100 : 0;
        }

        // Get referral statistics
        $stats = [
            'total_referrals' => $referrals->count(),
            'total_visits' => $totalVisits,
            'top_referrer' => $referrals->first(),
            'social_media_visits' => $referrals->whereIn('referrer_domain', ['facebook.com', 'twitter.com', 'instagram.com', 'linkedin.com'])->sum('visit_count'),
            'search_engine_visits' => $referrals->where('referrer_domain', 'google.com')->sum('visit_count'),
            'direct_visits' => $referrals->where('referrer_url', 'direct')->sum('visit_count'),
        ];

        return view('dashboard.pages.top-referrals', compact('referrals', 'stats'));
    }

    /**
     * Sample data for demonstration purposes
     */
    private function getSampleReferralData()
    {
        return collect([
            new Referral([
                'referrer_url' => 'direct',
                'landing_page' => '/',
                'visit_count' => 245,
                'created_at' => now(),
                'updated_at' => now(),
            ]),
            new Referral([
                'referrer_url' => 'https://google.com',
                'landing_page' => '/',
                'visit_count' => 189,
                'created_at' => now(),
                'updated_at' => now(),
            ]),
            new Referral([
                'referrer_url' => 'https://facebook.com',
                'landing_page' => '/blog',
                'visit_count' => 156,
                'created_at' => now(),
                'updated_at' => now(),
            ]),
            new Referral([
                'referrer_url' => 'https://linkedin.com',
                'landing_page' => '/careers',
                'visit_count' => 98,
                'created_at' => now(),
                'updated_at' => now(),
            ]),
            new Referral([
                'referrer_url' => 'https://twitter.com',
                'landing_page' => '/services',
                'visit_count' => 87,
                'created_at' => now(),
                'updated_at' => now(),
            ]),
            new Referral([
                'referrer_url' => 'https://github.com',
                'landing_page' => '/about-us',
                'visit_count' => 65,
                'created_at' => now(),
                'updated_at' => now(),
            ]),
            new Referral([
                'referrer_url' => 'https://instagram.com',
                'landing_page' => '/blog',
                'visit_count' => 54,
                'created_at' => now(),
                'updated_at' => now(),
            ]),
            new Referral([
                'referrer_url' => 'https://reddit.com',
                'landing_page' => '/services/web-development',
                'visit_count' => 43,
                'created_at' => now(),
                'updated_at' => now(),
            ]),
        ]);
    }
}