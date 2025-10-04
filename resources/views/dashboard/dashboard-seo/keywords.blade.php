@extends('layouts.admin_panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold gradient-text">Keywords Management</h2>
    </div>

    <div class="card-bg rounded-lg p-6">
        <form method="POST" action="{{ route('dashboard.seo.keywords.update') }}">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Primary Keywords</label>
                    <textarea name="primary_keywords" rows="3" 
                              class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white"
                              placeholder="consultancy services, business consulting, management consulting">{{ isset($keywords->value) ? json_decode($keywords->value)->primary ?? '' : '' }}</textarea>
                    <div class="text-xs text-gray-400 mt-1">
                        Main keywords that represent your core services (comma separated)
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Secondary Keywords</label>
                    <textarea name="secondary_keywords" rows="3" 
                              class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white"
                              placeholder="corporate strategy, process improvement, digital transformation">{{ isset($keywords->value) ? json_decode($keywords->value)->secondary ?? '' : '' }}</textarea>
                    <div class="text-xs text-gray-400 mt-1">
                        Supporting keywords and long-tail phrases
                    </div>
                </div>
                
                <div class="bg-blue-500/10 border border-blue-500/50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-lightbulb text-blue-400 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-blue-300">Keyword Strategy Tips</h4>
                            <p class="text-sm text-blue-200 mt-1">
                                Focus on location-based keywords (e.g., "consultancy services in [city]"), 
                                service-specific terms, and problem-solving phrases your clients might search for.
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="bg-primary hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition">
                    Save Keywords
                </button>
            </div>
        </form>
    </div>
</div>
@endsection