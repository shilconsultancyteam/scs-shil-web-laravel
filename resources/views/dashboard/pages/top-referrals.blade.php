@extends('layouts.admin_panel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Top Referrals</h1>
            <p class="text-gray-400 mt-2">Traffic sources and referral analytics</p>
        </div>
        <div class="text-right">
            <p class="text-gray-400 text-sm">Tracking Period</p>
            <p class="text-white font-semibold">Last 30 Days</p>
        </div>
    </div>

    <!-- Stats Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Referrals -->
        <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 p-6 rounded-xl border border-blue-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-300 text-sm font-medium">Total Sources</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($stats['total_referrals']) }}</p>
                    <p class="text-blue-400 text-xs mt-1">Referral Sources</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-share-alt text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Referral Visits -->
        <div class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 p-6 rounded-xl border border-green-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-300 text-sm font-medium">Referral Visits</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($stats['total_visits']) }}</p>
                    <p class="text-green-400 text-xs mt-1">Total Visits</p>
                </div>
                <div class="w-12 h-12 bg-green-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-green-300 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Social Media Visits -->
        <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 p-6 rounded-xl border border-purple-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-300 text-sm font-medium">Social Media</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($stats['social_media_visits']) }}</p>
                    <p class="text-purple-400 text-xs mt-1">From Social Platforms</p>
                </div>
                <div class="w-12 h-12 bg-purple-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-thumbs-up text-purple-300 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Search Engine Visits -->
        <div class="bg-gradient-to-br from-orange-500/20 to-red-500/20 p-6 rounded-xl border border-orange-500/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-300 text-sm font-medium">Search Engines</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ number_format($stats['search_engine_visits']) }}</p>
                    <p class="text-orange-400 text-xs mt-1">Organic Search</p>
                </div>
                <div class="w-12 h-12 bg-orange-500/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-search text-orange-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Top Referrals Table -->
        <div class="lg:col-span-2">
            <div class="bg-[#1a1a1a] rounded-xl shadow-lg overflow-hidden border border-gray-700">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-chart-pie text-blue-400 mr-3"></i>
                        Top {{ $referrals->count() }} Referral Sources
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-900/50 border-b border-gray-700">
                                <th class="py-4 px-6 text-left text-gray-300 font-semibold uppercase text-sm">Source</th>
                                <th class="py-4 px-6 text-left text-gray-300 font-semibold uppercase text-sm">Landing Page</th>
                                <th class="py-4 px-6 text-right text-gray-300 font-semibold uppercase text-sm">Visits</th>
                                <th class="py-4 px-6 text-center text-gray-300 font-semibold uppercase text-sm">Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($referrals as $index => $referral)
                            <tr class="border-b border-gray-700 hover:bg-gray-800/50 transition-colors">
                                <!-- Source -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-{{ $referral->referrer_color }}-500/20 flex items-center justify-center mr-3">
                                            <i class="{{ $referral->referrer_icon }} text-{{ $referral->referrer_color }}-400"></i>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ $referral->referrer_display_name }}</p>
                                            <p class="text-gray-400 text-xs">{{ $referral->referrer_domain }}</p>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Landing Page -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-link text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-white text-sm bg-gray-800 px-2 py-1 rounded">
                                            {{ $referral->landing_page }}
                                        </span>
                                    </div>
                                </td>
                                
                                <!-- Visits -->
                                <td class="py-4 px-6 text-right">
                                    <span class="text-white font-bold text-lg">{{ number_format($referral->visit_count) }}</span>
                                    <span class="text-gray-400 text-sm ml-1">visits</span>
                                </td>
                                
                                <!-- Percentage Share -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center">
                                        <div class="w-full bg-gray-700 rounded-full h-2 mr-3">
                                            <div class="h-2 rounded-full bg-{{ $referral->referrer_color }}-500" 
                                                 style="width: {{ $referral->percentage }}%">
                                            </div>
                                        </div>
                                        <span class="text-gray-300 text-sm font-medium w-12 text-right">
                                            {{ round($referral->percentage, 1) }}%
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
                            Referral data from external traffic sources
                        </div>
                        <div>
                            Showing top {{ $referrals->count() }} sources
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Analytics & Actions -->
        <div class="space-y-6">
            <!-- Traffic Source Distribution -->
            <div class="bg-[#1a1a1a] rounded-xl p-6 border border-gray-700">
                <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                    <i class="fas fa-chart-pie text-green-400 mr-2"></i>
                    Traffic Distribution
                </h4>
                <div class="space-y-4">
                    @php
                        $categories = [
                            'Direct' => $stats['direct_visits'],
                            'Search' => $stats['search_engine_visits'],
                            'Social' => $stats['social_media_visits'],
                            'Other' => $stats['total_visits'] - $stats['direct_visits'] - $stats['search_engine_visits'] - $stats['social_media_visits'],
                        ];
                    @endphp
                    
                    @foreach($categories as $label => $count)
                        @if($count > 0)
                        @php
                            $percentage = $stats['total_visits'] > 0 ? ($count / $stats['total_visits']) * 100 : 0;
                            $colors = [
                                'Direct' => 'blue',
                                'Search' => 'green', 
                                'Social' => 'purple',
                                'Other' => 'gray'
                            ];
                        @endphp
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-{{ $colors[$label] }}-500 mr-3"></div>
                                <span class="text-white text-sm">{{ $label }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-white font-semibold">{{ number_format($count) }}</span>
                                <span class="text-gray-400 text-sm ml-1">({{ round($percentage, 1) }}%)</span>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Quick Insights -->
            <div class="bg-[#1a1a1a] rounded-xl p-6 border border-gray-700">
                <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-yellow-400 mr-2"></i>
                    Quick Insights
                </h4>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <i class="fas fa-trophy text-yellow-400 mt-1 mr-3"></i>
                        <div>
                            <p class="text-white text-sm font-semibold">Top Performer</p>
                            <p class="text-gray-400 text-xs">{{ $stats['top_referrer']->referrer_display_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-users text-green-400 mt-1 mr-3"></i>
                        <div>
                            <p class="text-white text-sm font-semibold">Social Impact</p>
                            <p class="text-gray-400 text-xs">{{ number_format($stats['social_media_visits']) }} visits from social media</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-search text-blue-400 mt-1 mr-3"></i>
                        <div>
                            <p class="text-white text-sm font-semibold">SEO Performance</p>
                            <p class="text-gray-400 text-xs">{{ number_format($stats['search_engine_visits']) }} organic search visits</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-[#1a1a1a] rounded-xl p-6 border border-gray-700">
                <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                    <i class="fas fa-rocket text-purple-400 mr-2"></i>
                    Quick Actions
                </h4>
                <div class="space-y-3">
                    <a href="{{ route('analytics.popular') }}" 
                       class="flex items-center justify-between p-3 bg-blue-500/20 hover:bg-blue-500/30 rounded-lg border border-blue-500/30 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-chart-line text-blue-400 mr-3"></i>
                            <span class="text-white">Popular Pages</span>
                        </div>
                        <i class="fas fa-arrow-right text-blue-400"></i>
                    </a>
                    
                    <a href="{{ route('analytics.live-stats') }}" 
                       class="flex items-center justify-between p-3 bg-green-500/20 hover:bg-green-500/30 rounded-lg border border-green-500/30 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-chart-bar text-green-400 mr-3"></i>
                            <span class="text-white">Live Stats</span>
                        </div>
                        <i class="fas fa-arrow-right text-green-400"></i>
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
</div>

<!-- Auto-refresh script -->
<script>
    // Auto-refresh every 3 minutes
    setInterval(function() {
        window.location.reload();
    }, 180000);
</script>
@endsection