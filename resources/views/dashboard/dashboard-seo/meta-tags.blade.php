@extends('layouts.admin_panel')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold gradient-text">Meta Tags Management</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Page Selection -->
        <div class="card-bg rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Select Page</h3>
            <select id="pageSelector" class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white">
                @foreach($pages as $page)
                    <option value="{{ $page->id }}">{{ $page->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Meta Tags Form -->
        <div class="card-bg rounded-lg p-6 lg:col-span-2">
            <form id="metaForm" method="POST">
                @csrf
                <input type="hidden" name="page_id" id="page_id">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" 
                               class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white"
                               maxlength="60">
                        <div class="text-xs text-gray-400 mt-1"><span id="titleCount">0</span>/60</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3"
                                  class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-black"
                                  maxlength="160"></textarea>
                        <div class="text-xs text-gray-400 mt-1"><span id="descCount">0</span>/160</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" 
                               class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-black"
                               placeholder="keyword1, keyword2, keyword3">
                    </div>
                    
                    <button type="submit" class="bg-primary hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition">
                        Update Meta Tags
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('pageSelector').addEventListener('change', function() {
    const pageId = this.value;
    // AJAX call to fetch page meta data
    fetch(`/api/pages/${pageId}/meta`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('page_id').value = data.id;
            document.getElementById('meta_title').value = data.meta_title || '';
            document.getElementById('meta_description').value = data.meta_description || '';
            document.getElementById('meta_keywords').value = data.meta_keywords || '';
            updateCharacterCounts();
        });
});

function updateCharacterCounts() {
    document.getElementById('titleCount').textContent = document.getElementById('meta_title').value.length;
    document.getElementById('descCount').textContent = document.getElementById('meta_description').value.length;
}

document.getElementById('meta_title').addEventListener('input', updateCharacterCounts);
document.getElementById('meta_description').addEventListener('input', updateCharacterCounts);

// Initialize with first page
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('pageSelector').dispatchEvent(new Event('change'));
});
</script>
@endsection