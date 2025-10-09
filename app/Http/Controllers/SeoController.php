<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeoSettings;
use App\Models\Page;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

    /**
     * Display blog meta tags management page
     */
    public function blogMetaTags()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('dashboard.dashboard-seo.blog-meta-tags', compact('blogs'));
    }

    /**
     * Display blog keywords management page
     */
    public function blogKeywords()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('dashboard.dashboard-seo.blog-keywords', compact('blogs'));
    }

    /**
     * Get blog meta data via AJAX
     */
    public function getBlogMeta($id)
    {
        try {
            Log::info('Fetching blog meta data for ID: ' . $id);

            // Use find() instead of route model binding for better error handling
            $blog = Blog::find($id);
            
            if (!$blog) {
                Log::warning('Blog not found with ID: ' . $id);
                return response()->json([
                    'error' => 'Blog not found',
                    'message' => "No blog found with ID: {$id}"
                ], 404);
            }

            Log::info('Blog found: ' . $blog->title);

            $responseData = [
                'success' => true,
                'meta_title' => $blog->meta_title ?? '',
                'meta_description' => $blog->meta_description ?? '',
                'meta_keywords' => $blog->meta_keywords ?? '',
                'primary_keywords' => $blog->primary_keywords ?? '',
                'secondary_keywords' => $blog->secondary_keywords ?? '',
                'blog_title' => $blog->title, // For debugging
                'blog_id' => $blog->id
            ];

            Log::info('Blog meta data retrieved successfully', $responseData);

            return response()->json($responseData);

        } catch (\Exception $e) {
            Log::error('Error fetching blog meta data: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e
            ]);

            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update blog meta tags
     */
    public function updateBlogMetaTags(Request $request, $id)
    {
        try {
            Log::info('Updating blog meta tags for ID: ' . $id, $request->all());

            $blog = Blog::find($id);
            
            if (!$blog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Blog not found'
                ], 404);
            }

            $validated = $request->validate([
                'meta_title' => 'nullable|string|max:60',
                'meta_description' => 'nullable|string|max:160',
                'meta_keywords' => 'nullable|string',
            ]);

            $blog->update($validated);

            Log::info('Blog meta tags updated successfully', [
                'blog_id' => $id,
                'updates' => $validated
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Meta tags updated successfully!',
                'data' => $validated
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating blog meta tags: ' . $e->getMessage(), [
                'id' => $id,
                'request' => $request->all(),
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating meta tags: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update blog keywords
     */
    public function updateBlogKeywords(Request $request, $id)
    {
        try {
            Log::info('Updating blog keywords for ID: ' . $id, $request->all());

            $blog = Blog::find($id);
            
            if (!$blog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Blog not found'
                ], 404);
            }

            $validated = $request->validate([
                'primary_keywords' => 'nullable|string',
                'secondary_keywords' => 'nullable|string',
            ]);

            $blog->update($validated);

            Log::info('Blog keywords updated successfully', [
                'blog_id' => $id,
                'updates' => $validated
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Keywords updated successfully!',
                'data' => $validated
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating blog keywords: ' . $e->getMessage(), [
                'id' => $id,
                'request' => $request->all(),
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating keywords: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Debug method to check blog data
     */
    public function debugBlog($id)
    {
        try {
            $blog = Blog::find($id);
            
            if (!$blog) {
                return response()->json([
                    'error' => 'Blog not found',
                    'id' => $id
                ], 404);
            }

            return response()->json([
                'blog_exists' => true,
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'meta_title' => $blog->meta_title,
                'meta_description' => $blog->meta_description,
                'meta_keywords' => $blog->meta_keywords,
                'primary_keywords' => $blog->primary_keywords,
                'secondary_keywords' => $blog->secondary_keywords,
                'all_columns' => array_keys($blog->getAttributes()),
                'created_at' => $blog->created_at,
                'updated_at' => $blog->updated_at
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Debug error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}