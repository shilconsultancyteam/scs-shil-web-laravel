<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeoSettings;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    // Meta Tags Management
    public function metaTags()
    {
        $pages = Page::all();
        $globalMeta = SeoSettings::where('key', 'global_meta')->first();
        
        return view('dashboard.dashboard-seo.meta-tags', compact('pages', 'globalMeta'));
    }

    public function updateMetaTags(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string'
        ]);

        $page = Page::find($request->page_id);
        $page->update([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords
        ]);

        return redirect()->back()->with('success', 'Meta tags updated successfully!');
    }

    // Analytics Configuration
    public function analytics()
    {
        $analytics = SeoSettings::where('key', 'google_analytics')->first();
        return view('dashboard.dashboard-seo.analytics', compact('analytics'));
    }

    public function updateAnalytics(Request $request)
    {
        SeoSettings::updateOrCreate(
            ['key' => 'google_analytics'],
            ['value' => $request->analytics_code]
        );

        return redirect()->back()->with('success', 'Analytics configuration updated!');
    }

    // Keywords Management
    public function keywords()
    {
        $keywords = SeoSettings::where('key', 'focus_keywords')->first();
        return view('dashboard.dashboard-seo.keywords', compact('keywords'));
    }

    public function updateKeywords(Request $request)
    {
        $request->validate([
            'primary_keywords' => 'nullable|string',
            'secondary_keywords' => 'nullable|string'
        ]);

        SeoSettings::updateOrCreate(
            ['key' => 'focus_keywords'],
            ['value' => json_encode([
                'primary' => $request->primary_keywords,
                'secondary' => $request->secondary_keywords
            ])]
        );

        return redirect()->back()->with('success', 'Keywords updated successfully!');
    }

    // Sitemap Management
    public function sitemap()
    {
        $sitemapExists = Storage::disk('public')->exists('sitemap.xml');
        return view('dashboard.dashboard-seo.sitemap', compact('sitemapExists'));
    }

    public function generateSitemap()
    {
        // Simple sitemap generation logic
        $pages = Page::where('status', 'active')->get();
        
        $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemapContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($pages as $page) {
            $sitemapContent .= "
            <url>
                <loc>" . url($page->slug) . "</loc>
                <lastmod>" . $page->updated_at->format('Y-m-d') . "</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
            </url>";
        }
        
        $sitemapContent .= '</urlset>';
        
        Storage::disk('public')->put('sitemap.xml', $sitemapContent);

        return redirect()->back()->with('success', 'Sitemap generated successfully!');
    }

    // Robots.txt Management
    public function robots()
    {
        $robotsContent = Storage::disk('public')->exists('robots.txt') 
            ? Storage::disk('public')->get('robots.txt') 
            : "User-agent: *\nDisallow: /admin\nDisallow: /dashboard\nAllow: /";
            
        return view('dashboard.dashboard-seo.robots', compact('robotsContent'));
    }

    public function updateRobots(Request $request)
    {
        Storage::disk('public')->put('robots.txt', $request->robots_content);
        return redirect()->back()->with('success', 'Robots.txt updated successfully!');
    }
}