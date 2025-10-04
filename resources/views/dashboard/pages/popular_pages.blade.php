@extends('layouts.admin_panel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Popular Pages Analytics</h1>
            <p class="text-gray-400 mt-2">Top performing pages by view count</p>
        </div>
        <div class="text-right">
            <p class="text-gray-400 text-sm">Last Updated</p>
            <p class="text-white font-semibold">{{ now()->format('M j, Y g:i A') }}</p>
        </div>
    </div>

    <!-- Stats Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 p-6 rounded-xl border border-blue-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-300 text-sm font-medium">Total Pages</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ $popular->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 p-6 rounded-xl border border-green-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-300 text-sm font-medium">Total Views</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($popular->sum('total_views')) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-eye text-green-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 p-6 rounded-xl border border-purple-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-300 text-sm font-medium">Avg. Views</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($popular->avg('total_views')) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-bar text-purple-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500/20 to-red-500/20 p-6 rounded-xl border border-orange-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-300 text-sm font-medium">Top Page</p>
                    <p class="text-lg font-bold text-white mt-2 truncate">
                        {{ $popular->first()->page ?? 'N/A' }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-orange-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Pages Table -->
    <div class="bg-[#1a1a1a] rounded-xl shadow-lg overflow-hidden border border-gray-700">
        <div class="px-6 py-4 border-b border-gray-700">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-chart-line text-blue-400 mr-3"></i>
                Top {{ $popular->count() }} Popular Pages
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-900/50 border-b border-gray-700">
                        <th class="py-4 px-6 text-left text-gray-300 font-semibold uppercase text-sm">Rank</th>
                        <th class="py-4 px-6 text-left text-gray-300 font-semibold uppercase text-sm">Page URL</th>
                        <th class="py-4 px-6 text-left text-gray-300 font-semibold uppercase text-sm">Page Name</th>
                        <th class="py-4 px-6 text-right text-gray-300 font-semibold uppercase text-sm">Total Views</th>
                        <th class="py-4 px-6 text-center text-gray-300 font-semibold uppercase text-sm">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAllViews = $popular->sum('total_views');
                    @endphp
                    @foreach ($popular as $index => $item)
                    <tr class="border-b border-gray-700 hover:bg-gray-800/50 transition-colors">
                        <!-- Rank -->
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                    @if($index === 0) bg-yellow-500/20 text-yellow-400
                                    @elseif($index === 1) bg-gray-400/20 text-gray-300
                                    @elseif($index === 2) bg-orange-500/20 text-orange-400
                                    @else bg-blue-500/20 text-blue-300 @endif">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                        </td>
                        
                        <!-- Page URL -->
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <i class="fas fa-link text-gray-400 mr-3 text-sm"></i>
                                <span class="text-white font-mono text-sm bg-gray-800 px-2 py-1 rounded">
                                    {{ $item->page }}
                                </span>
                            </div>
                        </td>
                        
                        <!-- Page Name -->
                        <td class="py-4 px-6">
                            <span class="text-white capitalize">
                                @php
                                    $pageName = str_replace('/', '', $item->page);
                                    $pageName = str_replace('-', ' ', $pageName);
                                    $pageName = $pageName ?: 'Homepage';
                                @endphp
                                {{ $pageName }}
                            </span>
                        </td>
                        
                        <!-- Total Views -->
                        <td class="py-4 px-6 text-right">
                            <span class="text-white font-bold text-lg">{{ number_format($item->total_views) }}</span>
                            <span class="text-gray-400 text-sm ml-1">views</span>
                        </td>
                        
                        <!-- Percentage -->
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center">
                                @php
                                    $percentage = $totalAllViews > 0 ? ($item->total_views / $totalAllViews) * 100 : 0;
                                @endphp
                                <div class="w-full bg-gray-700 rounded-full h-2 mr-3">
                                    <div class="h-2 rounded-full 
                                        @if($index === 0) bg-yellow-500
                                        @elseif($index === 1) bg-gray-400
                                        @elseif($index === 2) bg-orange-500
                                        @else bg-blue-500 @endif" 
                                        style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                                <span class="text-gray-300 text-sm font-medium w-12">
                                    {{ round($percentage, 1) }}%
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-900/50 border-t border-gray-700">
            <div class="flex justify-between items-center text-sm text-gray-400">
                <div>
                    <i class="fas fa-info-circle mr-2"></i>
                    Data collected from page view tracking middleware
                </div>
                <div>
                    Last updated: {{ now()->format('M j, Y g:i A') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Insights -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <!-- Page Categories -->
        <div class="bg-[#1a1a1a] rounded-xl p-6 border border-gray-700">
            <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                <i class="fas fa-tags text-green-400 mr-2"></i>
                Page Categories
            </h4>
            <div class="space-y-3">
                @php
                    $categories = [
                        'Services' => $popular->where('page', 'like', '%services%')->sum('total_views'),
                        'Careers' => $popular->where('page', 'like', '%careers%')->sum('total_views'),
                        'Blog' => $popular->where('page', 'like', '%blog%')->sum('total_views'),
                        'Policy' => $popular->where('page', 'like', '%policy%')->sum('total_views'),
                        'Contact' => $popular->where('page', 'like', '%contact%')->sum('total_views'),
                    ];
                @endphp
                @foreach($categories as $category => $views)
                    @if($views > 0)
                    <div class="flex justify-between items-center p-3 bg-gray-800/50 rounded-lg">
                        <span class="text-white">{{ $category }}</span>
                        <span class="text-cyan-400 font-semibold">{{ number_format($views) }} views</span>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-[#1a1a1a] rounded-xl p-6 border border-gray-700">
            <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                <i class="fas fa-rocket text-purple-400 mr-2"></i>
                Quick Actions
            </h4>
            <div class="space-y-3">
                <a href="{{ route('analytics.live-stats') }}" 
                   class="flex items-center justify-between p-3 bg-blue-500/20 hover:bg-blue-500/30 rounded-lg border border-blue-500/30 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-blue-400 mr-3"></i>
                        <span class="text-white">View Live Stats</span>
                    </div>
                    <i class="fas fa-arrow-right text-blue-400"></i>
                </a>
                
                <a href="/" target="_blank" 
                   class="flex items-center justify-between p-3 bg-green-500/20 hover:bg-green-500/30 rounded-lg border border-green-500/30 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-home text-green-400 mr-3"></i>
                        <span class="text-white">Visit Homepage</span>
                    </div>
                    <i class="fas fa-external-link-alt text-green-400"></i>
                </a>
                
                <button onclick="window.location.reload()" 
                   class="w-full flex items-center justify-between p-3 bg-orange-500/20 hover:bg-orange-500/30 rounded-lg border border-orange-500/30 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-sync-alt text-orange-400 mr-3"></i>
                        <span class="text-white">Refresh Data</span>
                    </div>
                    <i class="fas fa-redo text-orange-400"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Auto-refresh script -->
<script>
    // Auto-refresh every 2 minutes
    setInterval(function() {
        window.location.reload();
    }, 120000);
</script>

<style>
    .hover\:bg-gray-800\/50:hover {
        background-color: rgba(31, 41, 55, 0.5);
    }
</style>
@endsection