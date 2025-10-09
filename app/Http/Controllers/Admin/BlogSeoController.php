<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogSeoController extends Controller
{
    /**
     * Display blog SEO management page
     */
    public function blogMetaTags()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('dashboard.seo.blog-meta-tags', compact('blogs'));
    }

    /**
     * Display blog keywords management page
     */
    public function blogKeywords()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('dashboard.seo.blog-keywords', compact('blogs'));
    }

    /**
     * Update blog meta tags
     */
    public function updateBlogMetaTags(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
        ]);

        $blog->update($validated);

        return back()->with('success', 'Meta tags updated successfully!');
    }

    /**
     * Update blog keywords
     */
    public function updateBlogKeywords(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'primary_keywords' => 'nullable|string',
            'secondary_keywords' => 'nullable|string',
        ]);

        $blog->update($validated);

        return back()->with('success', 'Keywords updated successfully!');
    }

    /**
     * Get blog meta data via AJAX
     */
    public function getBlogMeta(Blog $blog)
    {
        return response()->json([
            'meta_title' => $blog->meta_title,
            'meta_description' => $blog->meta_description,
            'meta_keywords' => $blog->meta_keywords,
            'primary_keywords' => $blog->primary_keywords,
            'secondary_keywords' => $blog->secondary_keywords,
        ]);
    }
}