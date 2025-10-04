@extends('layouts.admin_panel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Live Statistics</h1>
            <p class="text-gray-400 mt-2">Real-time overview of your website performance</p>
        </div>
        <div class="flex items-center space-x-4">
            <span class="flex items-center text-green-400 text-sm">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                Live Updated
            </span>
            <span class="text-gray-400 text-sm">{{ now()->format('M j, Y g:i A') }}</span>
        </div>
    </div>

    @if(!$liveStats['has_views_column'])
    <div class="bg-yellow-500/20 border border-yellow-500/50 text-yellow-300 p-4 rounded-lg mb-6">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-3"></i>
            <div>
                <p class="font-semibold">Views tracking not fully configured</p>
                <p class="text-sm">Blog view counts will be available after running migrations.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Views Today -->
        <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 p-6 rounded-xl border border-blue-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-300 text-sm font-medium">Views Today</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($liveStats['views_today']) }}</p>
                    <p class="{{ $liveStats['views_change_type'] === 'increase' ? 'text-green-400' : 'text-red-400' }} text-xs mt-1">
                        <i class="fas fa-arrow-{{ $liveStats['views_change_type'] === 'increase' ? 'up' : 'down' }} mr-1"></i>
                        {{ abs($liveStats['views_change']) }}% from yesterday
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-eye text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Blogs -->
        <div class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 p-6 rounded-xl border border-green-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-300 text-sm font-medium">Total Blogs</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($liveStats['total_blogs']) }}</p>
                    <p class="text-green-400 text-xs mt-1">
                        <i class="fas fa-plus mr-1"></i>
                        {{ $liveStats['blogs_this_month'] }} this month
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-blog text-green-300 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Comments Overview -->
        <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 p-6 rounded-xl border border-purple-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-300 text-sm font-medium">Total Comments</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($liveStats['total_comments']) }}</p>
                    <p class="text-yellow-400 text-xs mt-1">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $liveStats['pending_comments'] }} pending
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-comments text-purple-300 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="bg-gradient-to-br from-orange-500/20 to-red-500/20 p-6 rounded-xl border border-orange-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-300 text-sm font-medium">Total Users</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($liveStats['total_users']) }}</p>
                    <p class="text-green-400 text-xs mt-1">
                        <i class="fas fa-user-plus mr-1"></i>
                        {{ $liveStats['new_users_this_month'] }} new this month
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-orange-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Weekly Views -->
        <div class="bg-gray-800/50 p-6 rounded-lg border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">This Week</p>
                    <p class="text-white font-semibold text-2xl">{{ number_format($liveStats['views_this_week']) }}</p>
                    <p class="text-cyan-400 text-xs mt-1">Total Views</p>
                </div>
                <i class="fas fa-calendar-week text-cyan-400 text-2xl"></i>
            </div>
        </div>
        
        <!-- Monthly Views -->
        <div class="bg-gray-800/50 p-6 rounded-lg border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">This Month</p>
                    <p class="text-white font-semibold text-2xl">{{ number_format($liveStats['views_this_month']) }}</p>
                    <p class="text-purple-400 text-xs mt-1">Total Views</p>
                </div>
                <i class="fas fa-calendar-alt text-purple-400 text-2xl"></i>
            </div>
        </div>
        
        <!-- Most Viewed Blog -->
        <div class="bg-gray-800/50 p-6 rounded-lg border border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-400 text-sm">Most Popular Blog</p>
                    <p class="text-white font-semibold text-sm truncate">
                        {{ $liveStats['most_viewed_blog']->title ?? 'No blogs yet' }}
                    </p>
                    <p class="text-yellow-400 text-xs mt-1">
                        @if($liveStats['has_views_column'] && $liveStats['most_viewed_blog'])
                            {{ $liveStats['most_viewed_blog']->views ?? 0 }} views
                        @else
                            Latest Blog
                        @endif
                    </p>
                </div>
                <i class="fas fa-trophy text-yellow-400 text-2xl ml-2"></i>
            </div>
        </div>
    </div>

    <!-- Popular Blogs Section -->
    <div class="mt-8 bg-[#1a1a1a] rounded-xl p-6 border border-gray-700">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <i class="fas fa-fire text-orange-400 mr-2"></i>
            @if($liveStats['has_views_column'])
                Most Popular Blogs
            @else
                Latest Blogs
            @endif
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($liveStats['popular_blogs'] as $blog)
            <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-600">
                <h4 class="text-white font-semibold text-sm mb-2 truncate">{{ $blog->title }}</h4>
                <div class="flex justify-between items-center text-xs">
                    @if($liveStats['has_views_column'])
                        <span class="text-gray-400">{{ $blog->views }} views</span>
                    @else
                        <span class="text-gray-400">{{ $blog->created_at->format('M j, Y') }}</span>
                    @endif
                    <span class="text-cyan-400">{{ $blog->comments_count }} comments</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Auto-refresh script -->
<script>
    // Auto-refresh every 30 seconds
    setInterval(function() {
        window.location.reload();
    }, 30000);
</script>
@endsection