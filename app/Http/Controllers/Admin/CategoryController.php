<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories and the form to add new ones.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all top-level categories, eagerly load their children (subcategories)
        // Eager loading prevents the N+1 query problem.
        $categories = Category::parents()->with('children')->get();

        // Also fetch all top-level categories for the Parent dropdown list in the 'Add' form
        $parent_categories = Category::parents()->get();

        // This is now looking for resources/views/dashboard/categories/index.blade.php
        return view('dashboard.categories.index', compact('categories', 'parent_categories'));
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
            // 'name' must be unique in the 'categories' table
            'name' => 'required|string|max:255|unique:categories,name',
            // parent_id must exist in the 'categories' table OR be null
            'parent_id' => 'nullable|integer|exists:categories,id',
        ]);

        // Use the Category model to create the new record in the database
        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id // Will be null if not selected
        ]);

        Session::flash('success', 'Category added successfully!');
        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();

        // Since we used onDelete('cascade') in the migration,
        // deleting a parent will automatically delete its subcategories.
        Session::flash('warning', 'Category and its subcategories (if any) deleted successfully!');
        return redirect()->route('dashboard.categories.index');
    }

    // NOTE: For 'update' functionality, you would typically add an 'edit' and 'update' method.
    // The 'edit' method fetches the category for the form, and the 'update' method handles the POST request.
}