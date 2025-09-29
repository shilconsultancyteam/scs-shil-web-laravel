<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// NOTE: Uncomment this when you create your Category model
// use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories and the form to add new ones.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = [
            'Digital Marketing' => ['Social Media Marketing', 'SEO', 'Content Creation'],
            'Web Development' => ['Full-Stack', 'Frontend', 'Backend', 'Mobile App'],
            'Branding' => ['Brand Strategy', 'Visual Identity']
        ];
        
        // This is now looking for resources/views/dashboard/categories/index.blade.php
        return view('dashboard.categories.index', compact('categories')); 
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|integer', // For subcategories
        ]);

        // When Category model is created, use:
        // Category::create($request->all());

        Session::flash('success', 'Category added successfully! (Placeholder functionality)');
        return redirect()->route('dashboard.categories.index');
    }
}