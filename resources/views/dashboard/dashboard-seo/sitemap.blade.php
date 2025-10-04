@extends('layouts.admin_panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold gradient-text">Sitemap Management</h2>
    </div>

    <div class="card-bg rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold">XML Sitemap</h3>
                <p class="text-gray-400">Generate and manage your website sitemap for search engines</p>
            </div>
            
            <div class="flex items-center space-x-4">
                @if($sitemapExists)
                    <a href="{{ asset('storage/sitemap.xml') }}" target="_blank" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                        <i class="fas fa-eye mr-2"></i> View Sitemap
                    </a>
                @endif
                
                <form method="POST" action="{{ route('dashboard.seo.sitemap.generate') }}">
                    @csrf
                    <button type="submit" 
                            class="bg-primary hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i> Generate Sitemap
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-blue-500/10 border border-blue-500/50 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-400 mr-3 mt-1"></i>
                <div>
                    <h4 class="font-semibold text-blue-300">Sitemap Information</h4>
                    <p class="text-sm text-blue-200 mt-1">
                        Your sitemap helps search engines discover and index your pages. 
                        Generate a new sitemap whenever you add or update pages on your website.
                        Current sitemap URL: <code class="bg-black/30 px-2 py-1 rounded">{{ url('storage/sitemap.xml') }}</code>
                    </p>
                </div>
            </div>
        </div>

        <!-- Sitemap Status -->
        <div class="border border-gray-700 rounded-lg p-4">
            <h4 class="font-semibold mb-3">Sitemap Status</h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span>File Exists:</span>
                    <span class="{{ $sitemapExists ? 'text-green-400' : 'text-red-400' }}">
                        {{ $sitemapExists ? 'Yes' : 'No' }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span>Last Generated:</span>
                    <span class="text-gray-400">
                        {{ $sitemapExists ? Storage::disk('public')->lastModified('sitemap.xml') : 'Never' }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span>Pages in Sitemap:</span>
                    <span class="text-gray-400">
                        {{ $sitemapExists ? 'Calculating...' : 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection