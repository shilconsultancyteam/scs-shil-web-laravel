@extends('layouts.admin_panel')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold gradient-text">Blog Posts Meta Tags</h2>
            <a href="{{ route('dashboard.seo.blog-keywords') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                Manage Blog Keywords
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Blog Selection -->
            <div class="card-bg rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Select Blog Post</h3>
                <select id="blogSelector" class="w-full bg-dark border border-gray-700 rounded-lg px-4 py-2"
                    style="color: black !important;">
                    <option value="">Select a blog post</option>
                    @foreach ($blogs as $blog)
                        <option value="{{ $blog->id }}" data-slug="{{ $blog->slug }}"
                            style="color: black !important;" class="text-gray-800">
                            {{ Str::limit($blog->title, 50) }}
                        </option>
                    @endforeach
                </select>

                <div class="mt-4 text-sm text-gray-400">
                    <p>Total Blogs: {{ $blogs->total() }}</p>
                    <p class="mt-2 text-xs">Use the dropdown to select a blog and edit its meta tags</p>
                </div>

                <div class="mt-4">
                    {{ $blogs->links() }}
                </div>
            </div>

            <!-- Meta Tags Form -->
            <div class="card-bg rounded-lg p-6 lg:col-span-2">
                <form id="blogMetaForm" method="POST">
                    @csrf
                    <input type="hidden" name="blog_id" id="blog_id">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title"
                                class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white"
                                maxlength="60" placeholder="Optimized title for search engines">
                            <div class="text-xs text-gray-400 mt-1">
                                <span id="titleCount">0</span>/60 characters -
                                <span id="titleStatus" class="text-green-400">Good</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3"
                                class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white" maxlength="160"
                                placeholder="Compelling description for search results"></textarea>
                            <div class="text-xs text-gray-400 mt-1">
                                <span id="descCount">0</span>/160 characters -
                                <span id="descStatus" class="text-green-400">Good</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords"
                                class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white"
                                placeholder="keyword1, keyword2, keyword3">
                            <div class="text-xs text-gray-400 mt-1">
                                Separate keywords with commas
                            </div>
                        </div>

                        <div class="bg-blue-500/10 border border-blue-500/50 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-eye text-blue-400 mr-3"></i>
                                <div>
                                    <h4 class="font-semibold text-blue-300">Preview</h4>
                                    <div class="text-sm text-blue-200 mt-2">
                                        <div id="googlePreview" class="bg-white text-black p-3 rounded">
                                            <div id="previewTitle" class="text-blue-600 text-lg font-medium truncate"></div>
                                            <div id="previewUrl" class="text-green-600 text-sm">example.com/blog/<span
                                                    id="previewSlug"></span></div>
                                            <div id="previewDesc" class="text-gray-600 text-sm mt-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-primary hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition">
                                Update Meta Tags
                            </button>
                            <button type="button" id="resetBtn"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition">
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
            const metaForm = document.getElementById('blogMetaForm');
            const resetBtn = document.getElementById('resetBtn');

            // Load blog meta data when selection changes
            blogSelector.addEventListener('change', function() {
                const blogId = this.value;
                const selectedOption = this.options[this.selectedIndex];
                const blogSlug = selectedOption.getAttribute('data-slug');

                if (!blogId) {
                    resetForm();
                    return;
                }

                fetch(`/dashboard/seo/blogs/${blogId}/meta`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('blog_id').value = blogId;
                        document.getElementById('meta_title').value = data.meta_title || '';
                        document.getElementById('meta_description').value = data.meta_description || '';
                        document.getElementById('meta_keywords').value = data.meta_keywords || '';
                        document.getElementById('previewSlug').textContent = blogSlug;
                        updateCharacterCounts();
                        updatePreview();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error loading blog data. Please try again.');
                    });
            });

            // Character counting and validation
            function updateCharacterCounts() {
                const title = document.getElementById('meta_title');
                const desc = document.getElementById('meta_description');
                const titleCount = title.value.length;
                const descCount = desc.value.length;

                document.getElementById('titleCount').textContent = titleCount;
                document.getElementById('descCount').textContent = descCount;

                // Update status indicators
                document.getElementById('titleStatus').textContent =
                    titleCount >= 50 && titleCount <= 60 ? 'Perfect' :
                    titleCount >= 40 ? 'Good' : 'Too short';
                document.getElementById('titleStatus').className =
                    titleCount >= 50 && titleCount <= 60 ? 'text-green-400' :
                    titleCount >= 40 ? 'text-yellow-400' : 'text-red-400';

                document.getElementById('descStatus').textContent =
                    descCount >= 150 && descCount <= 160 ? 'Perfect' :
                    descCount >= 120 ? 'Good' : 'Too short';
                document.getElementById('descStatus').className =
                    descCount >= 150 && descCount <= 160 ? 'text-green-400' :
                    descCount >= 120 ? 'text-yellow-400' : 'text-red-400';
            }

            function updatePreview() {
                const title = document.getElementById('meta_title').value || 'Blog Post Title';
                const desc = document.getElementById('meta_description').value || 'Blog post description...';

                document.getElementById('previewTitle').textContent = title;
                document.getElementById('previewDesc').textContent = desc;
            }

            function resetForm() {
                document.getElementById('blog_id').value = '';
                document.getElementById('meta_title').value = '';
                document.getElementById('meta_description').value = '';
                document.getElementById('meta_keywords').value = '';
                document.getElementById('previewSlug').textContent = 'slug';
                document.getElementById('previewTitle').textContent = 'Blog Post Title';
                document.getElementById('previewDesc').textContent = 'Blog post description...';
                updateCharacterCounts();
            }

            // Event listeners
            document.getElementById('meta_title').addEventListener('input', function() {
                updateCharacterCounts();
                updatePreview();
            });

            document.getElementById('meta_description').addEventListener('input', function() {
                updateCharacterCounts();
                updatePreview();
            });

            resetBtn.addEventListener('click', resetForm);

            // Form submission
            metaForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const blogId = document.getElementById('blog_id').value;
                if (!blogId) {
                    alert('Please select a blog post first.');
                    return;
                }

                const formData = new FormData(this);

                fetch(`/dashboard/seo/blogs/${blogId}/meta-tags`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Meta tags updated successfully!');
                        } else {
                            alert('Error updating meta tags: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error updating meta tags. Please try again.');
                    });
            });

            // Initialize
            updateCharacterCounts();
            updatePreview();
        });
    </script>
@endsection
