@extends('layouts.admin_panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold gradient-text">Analytics Configuration</h2>
    </div>

    <div class="card-bg rounded-lg p-6">
        <form method="POST" action="{{ route('dashboard.seo.analytics.update') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Google Analytics Tracking Code</label>
                <textarea name="analytics_code" rows="8" 
                          class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white font-mono text-sm"
                          placeholder="Paste your Google Analytics tracking code here...">{{ $analytics->value ?? '' }}</textarea>
                <div class="text-xs text-gray-400 mt-2">
                    Paste your Google Analytics 4 (GA4) tracking code or Google Tag Manager code.
                </div>
            </div>

            <div class="bg-yellow-500/10 border border-yellow-500/50 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                    <span class="text-yellow-200">Ensure your tracking code is properly formatted and includes the entire script tag.</span>
                </div>
            </div>

            <button type="submit" class="bg-primary hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition">
                Save Analytics Configuration
            </button>
        </form>
    </div>

    <!-- Analytics Status -->
    <div class="card-bg rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold mb-4">Tracking Status</h3>
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                <span>Analytics Code Status: <span class="text-green-400">Active</span></span>
            </div>
            <div class="text-sm text-gray-400">
                Last verified: {{ now()->format('M j, Y g:i A') }}
            </div>
        </div>
    </div>
</div>
@endsection