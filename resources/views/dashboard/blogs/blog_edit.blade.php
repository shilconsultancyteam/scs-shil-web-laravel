@extends('layouts.admin_panel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Edit Blog: <span class="text-blue-400">{{ $blog->title }}</span></h1>
            
            <a href="{{ route('dashboard.blogs.index') }}"
                class="px-4 py-2 bg-gray-500/20 text-white rounded-lg hover:bg-gray-500/30 transition">
                <i class="fas fa-list mr-2"></i>View All Blogs
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dashboard.blogs.update', $blog->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="bg-[#1a1a1a] p-6 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Title --}}
                <div>
                    <label for="title" class="block text-gray-400 font-semibold mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $blog->title) }}"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500"
                        required>
                </div>

                {{-- Subtitle --}}
                <div>
                    <label for="subtitle" class="block text-gray-400 font-semibold mb-2">Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $blog->subtitle) }}"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
                </div>

                {{-- Category --}}
                <div>
                    <label for="category" class="block text-gray-400 font-semibold mb-2">Category</label>
                    <select id="category" name="category"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500"
                        required>
                        <option value="">Select Category</option>
                        
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}" 
                                {{ old('category', $blog->category) == $category->name ? 'selected' : '' }} 
                                data-children="{{ json_encode($category->children->pluck('name')) }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Subcategory --}}
                <div>
                    <label for="subcategory" class="block text-gray-400 font-semibold mb-2">Subcategory</label>
                    <select id="subcategory" name="subcategory"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
                        <option value="">Select Subcategory</option>
                    </select>
                </div>

                {{-- Featured Image --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="image" class="block text-gray-400 font-semibold mb-2">Featured Image (Leave blank to keep existing)</label>
                    <input type="file" id="image" name="image"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
                    
                    @if ($blog->image)
                        <p class="text-sm text-gray-500 mt-2">Current Image: <a href="{{ asset('storage/' . $blog->image) }}" target="_blank" class="text-blue-400 hover:text-blue-300">View Image</a></p>
                    @endif
                </div>

                {{-- Content Section - UPDATED WITH WORKING CKEDITOR --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="content" class="block font-semibold mb-2 text-gray-400">Content</label>
                    <textarea id="content" name="content" rows="10" class="w-full bg-white border border-gray-700 rounded-lg px-4 py-2 text-black focus:outline-none focus:ring-2 focus:ring-primary" required>{{ old('content', $blog->content) }}</textarea>
                </div>

                {{-- SEO Meta Tags Section --}}
                <div class="col-span-1 md:col-span-2 mt-6 pt-6 border-t border-gray-700">
                    <h3 class="text-xl font-bold text-white mb-4">SEO Meta Tags</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="meta_title" class="block text-gray-400 font-semibold mb-2">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}"
                                class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500"
                                maxlength="60" placeholder="Optimized title for search engines">
                            <div class="text-xs text-gray-400 mt-1"><span id="metaTitleCount">0</span>/60 characters</div>
                        </div>

                        <div>
                            <label for="meta_keywords" class="block text-gray-400 font-semibold mb-2">Meta Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $blog->meta_keywords) }}"
                                class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500"
                                placeholder="keyword1, keyword2, keyword3">
                        </div>

                        <div class="md:col-span-2">
                            <label for="meta_description" class="block text-gray-400 font-semibold mb-2">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500"
                                maxlength="160" placeholder="Brief description for search engine results">{{ old('meta_description', $blog->meta_description) }}</textarea>
                            <div class="text-xs text-gray-400 mt-1"><span id="metaDescCount">0</span>/160 characters</div>
                        </div>

                        <div class="md:col-span-2">
                            <label for="primary_keywords" class="block text-gray-400 font-semibold mb-2">Primary Keywords</label>
                            <textarea id="primary_keywords" name="primary_keywords" rows="2"
                                class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500"
                                placeholder="Main keywords that represent this blog post (comma separated)">{{ old('primary_keywords', $blog->primary_keywords) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label for="secondary_keywords" class="block text-gray-400 font-semibold mb-2">Secondary Keywords</label>
                            <textarea id="secondary_keywords" name="secondary_keywords" rows="2"
                                class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500"
                                placeholder="Supporting keywords and long-tail phrases (comma separated)">{{ old('secondary_keywords', $blog->secondary_keywords) }}</textarea>
                        </div>
                    </div>

                    {{-- Google Preview --}}
                    <div class="mt-6 bg-blue-500/10 border border-blue-500/50 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-eye text-blue-400 mr-3"></i>
                            <h4 class="font-semibold text-blue-300">Google Search Preview</h4>
                        </div>
                        <div id="googlePreview" class="bg-white text-black p-3 rounded border">
                            <div id="previewTitle" class="text-blue-600 text-lg font-medium truncate">{{ $blog->meta_title ?: $blog->title }}</div>
                            <div id="previewUrl" class="text-green-600 text-sm">yourdomain.com/blog/{{ $blog->slug }}</div>
                            <div id="previewDesc" class="text-gray-600 text-sm mt-1">{{ $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160) }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 flex justify-end">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                        Update Blog Post
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
   <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- DYNAMIC SUBCATEGORY LOGIC (keep your existing code) ---
        const categorySelect = document.getElementById('category');
        const subcategorySelect = document.getElementById('subcategory');
        const oldSubcategory = "{{ old('subcategory', $blog->subcategory) }}"; 

        function updateSubcategories() {
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const childrenJson = selectedOption.getAttribute('data-children');
            
            if (childrenJson) {
                try {
                    const children = JSON.parse(childrenJson);
                    children.forEach(function(subCategoryName) {
                        const option = document.createElement('option');
                        option.value = subCategoryName;
                        option.textContent = subCategoryName;
                        if (oldSubcategory && oldSubcategory === subCategoryName) {
                            option.selected = true;
                        }
                        subcategorySelect.appendChild(option);
                    });
                } catch (e) {
                    console.error('Error parsing subcategory JSON:', e);
                }
            }
        }

        // Set initial subcategory based on blog data
        if (categorySelect.value) {
            updateSubcategories();
            // Set the current subcategory after options are populated
            setTimeout(() => {
                if (oldSubcategory) {
                    subcategorySelect.value = oldSubcategory;
                }
            }, 100);
        }
        categorySelect.addEventListener('change', updateSubcategories);
        // --- END DYNAMIC SUBCATEGORY LOGIC ---

        // --- SEO META TAGS FUNCTIONALITY ---
        const metaTitle = document.getElementById('meta_title');
        const metaDescription = document.getElementById('meta_description');
        const blogTitle = document.getElementById('title');

        function updateMetaCharacterCounts() {
            document.getElementById('metaTitleCount').textContent = metaTitle.value.length;
            document.getElementById('metaDescCount').textContent = metaDescription.value.length;
        }

        function updateGooglePreview() {
            const title = metaTitle.value || blogTitle.value;
            const description = metaDescription.value || document.getElementById('previewDesc').textContent;
            
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('previewDesc').textContent = description;
        }

        // Auto-fill meta title with blog title if empty
        blogTitle.addEventListener('blur', function() {
            if (!metaTitle.value.trim()) {
                metaTitle.value = this.value;
                updateMetaCharacterCounts();
                updateGooglePreview();
            }
        });

        // Event listeners for meta fields
        metaTitle.addEventListener('input', function() {
            updateMetaCharacterCounts();
            updateGooglePreview();
        });

        metaDescription.addEventListener('input', function() {
            updateMetaCharacterCounts();
            updateGooglePreview();
        });

        // Initialize counts and preview
        updateMetaCharacterCounts();
        updateGooglePreview();

        // Enhanced CKEditor Configuration
        ClassicEditor
            .create(document.querySelector('#content'), {
                ckfinder: {
                    uploadUrl: '{{ route('dashboard.blogs.upload') }}?_token={{ csrf_token() }}'
                },
                
                // Content styling
                contentStyle: `
                    body { 
                        color: #000000 !important; 
                        background-color: #ffffff !important; 
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        line-height: 1.6;
                    }
                    h1, h2, h3, h4, h5, h6 {
                        color: #000000;
                        margin-top: 1.5em;
                        margin-bottom: 0.5em;
                    }
                    strong, b { font-weight: bold; }
                    em, i { font-style: italic; }
                    ul, ol { 
                        padding-left: 2em;
                        margin: 1em 0;
                    }
                    li { margin-bottom: 0.5em; }
                    blockquote {
                        border-left: 4px solid #ccc;
                        margin: 1em 0;
                        padding-left: 1em;
                        font-style: italic;
                    }
                `,

                // Paste handling configuration
                pasteFromWord: {
                    enabled: true,
                    // Remove problematic Word styles
                    removeFontStyles: true,
                    removeStyles: true
                },

                // HTML content filtering
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ],
                    disallow: [
                        {
                            attributes: [
                                'onabort', 'onblur', 'onchange', 'onclick', 'ondblclick', 'onerror',
                                'onfocus', 'onkeydown', 'onkeypress', 'onkeyup', 'onload', 'onmousedown',
                                'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onreset',
                                'onresize', 'onselect', 'onsubmit', 'onunload'
                            ]
                        }
                    ]
                },

                // Toolbar configuration
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'fontColor', 'fontBackgroundColor', '|',
                        'bulletedList', 'numberedList', '|',
                        'alignment', 'outdent', 'indent', '|',
                        'link', 'uploadImage', 'blockQuote', 'insertTable', '|',
                        'undo', 'redo', '|',
                        'sourceEditing'
                    ]
                },

                // Heading options
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                    ]
                },

                // Font colors
                fontColor: {
                    colors: [
                        { color: '#000000', label: 'Black' },
                        { color: '#333333', label: 'Dark Gray' },
                        { color: '#666666', label: 'Gray' },
                        { color: '#ff0000', label: 'Red' },
                        { color: '#0000ff', label: 'Blue' },
                        { color: '#008000', label: 'Green' },
                        { color: '#ffff00', label: 'Yellow' }
                    ]
                },

                // Font background colors
                fontBackgroundColor: {
                    colors: [
                        { color: '#ffff00', label: 'Yellow Highlight' },
                        { color: '#00ff00', label: 'Green Highlight' },
                        { color: '#00ffff', label: 'Cyan Highlight' },
                        { color: '#ffc0cb', label: 'Pink Highlight' }
                    ]
                },

                // Image configuration
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'toggleImageCaption',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side',
                        'linkImage'
                    ]
                },

                // Table configuration
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableCellProperties',
                        'tableProperties'
                    ]
                },

                // Remove plugins that might cause issues
                removePlugins: [
                    'Markdown',
                    'Title' // Remove if you don't want title field
                ],

                // Extra plugins
                extraPlugins: [
                    // Add any extra plugins you need
                ]

            })
            .then(editor => {
                console.log('CKEditor initialized successfully');

                // Enhanced paste event handling
                editor.editing.view.document.on('paste', (evt, data) => {
                    console.log('Paste event detected');
                });

                // Ensure content is synced before form submission
                editor.model.document.on('change:data', () => {
                    const content = editor.getData();
                    document.querySelector('#content').value = content;
                });

                // Handle form submission
                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Final sync before submission
                        document.querySelector('#content').value = editor.getData();
                        
                        // Validate content
                        if (!editor.getData().trim()) {
                            e.preventDefault();
                            alert('Please enter some content for the blog post.');
                            return false;
                        }
                    });
                }

                // Add custom CSS for better editor appearance
                const style = document.createElement('style');
                style.textContent = `
                    .ck.ck-editor {
                        border: 1px solid #e2e8f0;
                        border-radius: 0.375rem;
                    }
                    .ck.ck-toolbar {
                        border-bottom: 1px solid #e2e8f0;
                        background: #f8fafc;
                    }
                    .ck.ck-content {
                        min-height: 300px;
                        color: #000000;
                        background: #ffffff;
                    }
                    .ck.ck-editor__editable_inline {
                        padding: 1rem;
                    }
                `;
                document.head.appendChild(style);

            })
            .catch(error => {
                console.error('CKEditor initialization failed:', error);
                // Fallback handling
                document.querySelector('#content').style.display = 'block';
                
                const warning = document.createElement('div');
                warning.className = 'bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4';
                warning.innerHTML = '<strong>Note:</strong> Using basic text editor. For rich text formatting, please refresh the page.';
                document.querySelector('#content').parentNode.insertBefore(warning, document.querySelector('#content'));
            });
    });
</script>
@endpush