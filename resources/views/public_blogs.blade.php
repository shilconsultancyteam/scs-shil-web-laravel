@extends('layouts.template')

@section('title', 'Blogs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 pt-32">
    <header class="text-center mb-16">
        <h1 class="text-4xl md:text-6xl font-bold gradient-text p-2">Digital Insights</h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto mt-4">Your source for the latest news, tips, and trends in digital marketing and web technology.</p>
    </header>

    <div class="flex flex-wrap justify-center gap-4 mb-10" id="category-filter">
        @php
            // Get current category slug from URL. It will be the segment after 'blog/category'.
            // If the URL is just '/blog', this will be null.
            $currentCategory = request()->segment(3) ?? null;
            $activeGradientStyle = 'background: linear-gradient(to right, #00bfff, #007bff);';
        @endphp
        
        {{-- "All" Button --}}
        <a href="{{ route('public.blogs.index') }}" 
           class="category-btn px-5 py-2 rounded-full font-medium text-white transition-colors duration-300 transform hover:scale-105 
           {{ !$currentCategory ? 'active' : 'text-gray-300 bg-gray-700 hover:bg-gray-600' }}" 
           {{-- Apply gradient style ONLY if it is the active "All" button --}}
           style="{{ !$currentCategory ? $activeGradientStyle : '' }}">
            All
        </a>
        
        {{-- Dynamic Category Buttons --}}
        @forelse ($categories as $category)
            @php
                $categorySlug = Str::slug($category);
                $isActive = $currentCategory === $categorySlug;
            @endphp
            <a href="{{ route('public.blogs.category', ['slug' => $categorySlug]) }}" 
               class="category-btn px-5 py-2 rounded-full font-medium transition-colors duration-300 transform hover:scale-105 
               {{ $isActive ? 'active' : 'text-gray-300 bg-gray-700 hover:bg-gray-600 hover:text-white' }}">
                {{ $category }}
            </a>
        @empty
            <p class="text-gray-400">No categories found.</p>
        @endforelse
    </div>
</div>

<main class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse ($blogs as $blog)
    <div class="blog-card rounded-xl overflow-hidden flex flex-col">
        <a href="{{ route('public.blogs.show', $blog->slug) }}" class="block">
            @if ($blog->image)
                <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" class="h-56 w-full object-cover">
            @else
                <div class="blog-placeholder-img h-56 w-full">
                    <i class="fas fa-chart-line text-6xl opacity-50"></i>
                </div>
            @endif
        </a>
        <div class="p-6 flex flex-col flex-grow">
            <div class="mb-4">
                <span class="px-3 py-1 bg-purple-500 bg-opacity-20 text-purple-300 rounded-full text-sm font-medium">{{ $blog->category }}</span>
            </div>
            <h3 class="text-2xl font-bold mb-3 text-white hover:text-cyan-400 transition-colors duration-300">
                <a href="{{ route('public.blogs.show', $blog->slug) }}">{{ $blog->title }}</a>
            </h3>
            <p class="text-gray-400 mb-4 flex-grow">{{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}</p>
            <div class="mt-auto pt-4 border-t border-gray-800 flex items-center text-sm text-gray-500">
                <span>By {{ $blog->author->name ?? 'Admin' }}</span>
                <span class="mx-2">&bull;</span>
                <span>{{ $blog->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>
    @empty
        <div class="md:col-span-3 text-center text-gray-400 p-8">
            <p class="text-xl">No blog posts found.</p>
        </div>
    @endforelse
</main>

<div class="mt-12 flex justify-center">
    {{ $blogs->links('vendor.pagination.tailwind') }}
</div>

<style>
    /* This CSS class applies the gradient to all category buttons with the 'active' class, 
       which includes the specific categories when they are active. */
    .category-btn.active {
        background: linear-gradient(to right, #00bfff, #007bff) !important;
        color: white !important;
    }
</style>
@endsection