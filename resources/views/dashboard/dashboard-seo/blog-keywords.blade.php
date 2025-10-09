@extends('layouts.admin_panel')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold gradient-text">Blog Posts Keywords</h2>
        <a href="{{ route('dashboard.seo.blog-meta-tags') }}" 
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
            Manage Blog Meta Tags
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Blog Selection -->
        <div class="card-bg rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Select Blog Post</h3>
            <select id="blogSelector" class="w-full bg-white border border-gray-700 rounded-lg px-4 py-2 text-black">
                <option value="">Select a blog post</option>
                @foreach($blogs as $blog)
                    <option value="{{ $blog->id }}" class="text-black">
                        {{ Str::limit($blog->title, 50) }}
                    </option>
                @endforeach
            </select>
            
            <div class="mt-4 text-sm text-gray-400">
                <p>Total Blogs: {{ $blogs->total() }}</p>
                <p class="mt-2 text-xs">Use the dropdown to select a blog and edit its keywords</p>
            </div>
            
            <div class="mt-4">
                {{ $blogs->links() }}
            </div>
        </div>

        <!-- Keywords Form -->
        <div class="card-bg rounded-lg p-6 lg:col-span-2">
            <form id="blogKeywordsForm" method="POST">
                @csrf
                <input type="hidden" name="blog_id" id="blog_id">
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Primary Keywords</label>
                        <textarea name="primary_keywords" id="primary_keywords" rows="3"
                                  class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white"
                                  placeholder="Main keywords that represent this blog post (comma separated)"></textarea>
                        <div class="text-xs text-gray-400 mt-1">
                            Focus on 3-5 main keywords that best describe your content
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Secondary Keywords</label>
                        <textarea name="secondary_keywords" id="secondary_keywords" rows="3"
                                  class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white"
                                  placeholder="Supporting keywords and long-tail phrases (comma separated)"></textarea>
                        <div class="text-xs text-gray-400 mt-1">
                            Include related terms, synonyms, and longer keyword phrases
                        </div>
                    </div>

                    <!-- Current Selection Info -->
                    <div id="currentBlogInfo" class="bg-blue-500/10 border border-blue-500/50 rounded-lg p-4 hidden">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-400 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-blue-300">Editing Keywords for:</h4>
                                <p id="selectedBlogTitle" class="text-sm text-blue-200 mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-500/10 border border-green-500/50 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-lightbulb text-green-400 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-green-300">Keyword Strategy Tips</h4>
                                <ul class="text-sm text-green-200 mt-2 space-y-1">
                                    <li>• Use specific, intent-based keywords</li>
                                    <li>• Include long-tail keywords (3+ words)</li>
                                    <li>• Research competitor keywords</li>
                                    <li>• Update keywords as trends change</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-primary hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition">
                            Update Keywords
                        </button>
                        <button type="button" id="resetBtn" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const blogSelector = document.getElementById('blogSelector');
    const keywordsForm = document.getElementById('blogKeywordsForm');
    const resetBtn = document.getElementById('resetBtn');
    const currentBlogInfo = document.getElementById('currentBlogInfo');
    const selectedBlogTitle = document.getElementById('selectedBlogTitle');

    // Load blog keywords when selection changes
    blogSelector.addEventListener('change', function() {
        const blogId = this.value;
        const selectedOption = this.options[this.selectedIndex];
        const blogTitle = selectedOption.textContent;
        
        console.log('🔄 Loading keywords for blog ID:', blogId);

        if (!blogId) {
            resetForm();
            return;
        }

        // Show loading state
        document.getElementById('primary_keywords').placeholder = 'Loading keywords...';
        document.getElementById('secondary_keywords').placeholder = 'Loading keywords...';

        // Construct the URL
        const url = `/dashboard/seo/blogs/${blogId}/meta`;
        console.log('📡 Fetching from:', url);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('📨 Response status:', response.status, response.statusText);
            
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}. Response: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Received keyword data:', data);
            
            // Check if we got an error response
            if (data.error) {
                throw new Error(data.message || data.error);
            }

            document.getElementById('blog_id').value = blogId;
            document.getElementById('primary_keywords').value = data.primary_keywords || '';
            document.getElementById('secondary_keywords').value = data.secondary_keywords || '';
            
            // Show current blog info
            selectedBlogTitle.textContent = blogTitle;
            currentBlogInfo.classList.remove('hidden');
            
            // Clear loading placeholders
            document.getElementById('primary_keywords').placeholder = 'Main keywords that represent this blog post (comma separated)';
            document.getElementById('secondary_keywords').placeholder = 'Supporting keywords and long-tail phrases (comma separated)';
            
            console.log('✅ Blog keywords loaded successfully');
        })
        .catch(error => {
            console.error('❌ Fetch error:', error);
            
            // Clear loading placeholders
            document.getElementById('primary_keywords').placeholder = 'Main keywords that represent this blog post (comma separated)';
            document.getElementById('secondary_keywords').placeholder = 'Supporting keywords and long-tail phrases (comma separated)';
            
            // Hide current blog info
            currentBlogInfo.classList.add('hidden');
            
            alert('Error loading blog data: ' + error.message);
        });
    });

    function resetForm() {
        document.getElementById('blog_id').value = '';
        document.getElementById('primary_keywords').value = '';
        document.getElementById('secondary_keywords').value = '';
        currentBlogInfo.classList.add('hidden');
    }

    resetBtn.addEventListener('click', resetForm);

    // Form submission
    keywordsForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const blogId = document.getElementById('blog_id').value;
        if (!blogId) {
            alert('Please select a blog post first.');
            return;
        }

        const formData = new FormData(this);
        const primaryKeywords = document.getElementById('primary_keywords').value;
        const secondaryKeywords = document.getElementById('secondary_keywords').value;

        console.log('🔄 Updating keywords for blog ID:', blogId, {
            primary_keywords: primaryKeywords,
            secondary_keywords: secondaryKeywords
        });

        // Show loading state on button
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Updating...';
        submitBtn.disabled = true;

        fetch(`/dashboard/seo/blogs/${blogId}/keywords`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('📨 Update response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('✅ Update response:', data);
            
            if (data.success) {
                alert('✅ ' + data.message);
            } else {
                alert('❌ Error updating keywords: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('❌ Update error:', error);
            alert('❌ Error updating keywords. Please try again.');
        })
        .finally(() => {
            // Restore button state
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });

    // Add some CSS to ensure select options are visible
    const style = document.createElement('style');
    style.textContent = `
        #blogSelector option {
            color: #000000 !important;
            background-color: #ffffff !important;
        }
        #blogSelector:focus {
            color: #000000 !important;
            background-color: #ffffff !important;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection