@extends('layouts.admin_panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold gradient-text">Robots.txt Management</h2>
    </div>

    <div class="card-bg rounded-lg p-6">
        <form method="POST" action="{{ route('dashboard.seo.robots.update') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Robots.txt Content</label>
                <textarea name="robots_content" rows="12" 
                          class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white font-mono text-sm">{{ $robotsContent }}</textarea>
            </div>

            <div class="bg-blue-500/10 border border-blue-500/50 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <i class="fas fa-robot text-blue-400 mr-3 mt-1"></i>
                    <div>
                        <h4 class="font-semibold text-blue-300">About Robots.txt</h4>
                        <p class="text-sm text-blue-200 mt-1">
                            The robots.txt file tells search engine crawlers which pages or sections of your site should not be accessed. 
                            Be careful with disallow rules as they can affect your site's visibility in search results.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ url('robots.txt') }}" target="_blank" 
                   class="text-primary hover:text-purple-400 transition flex items-center">
                    <i class="fas fa-external-link-alt mr-2"></i> View Current Robots.txt
                </a>
                
                <button type="submit" class="bg-primary hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition">
                    Update Robots.txt
                </button>
            </div>
        </form>
    </div>

    <!-- Common Directives Example -->
    <div class="card-bg rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold mb-4">Common Directives Examples</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-dark-3 rounded-lg p-4">
                <h4 class="font-semibold text-green-400 mb-2">Allow All</h4>
                <pre class="text-xs text-gray-300">User-agent: *
Allow: /</pre>
            </div>
            <div class="bg-dark-3 rounded-lg p-4">
                <h4 class="font-semibold text-yellow-400 mb-2">Block Admin</h4>
                <pre class="text-xs text-gray-300">User-agent: *
Disallow: /admin
Disallow: /dashboard
Allow: /</pre>
            </div>
        </div>
    </div>
</div>
@endsection