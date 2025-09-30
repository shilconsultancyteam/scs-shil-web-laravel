@extends('layouts.admin_panel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Create New Blog</h1>
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

        <form action="{{ route('dashboard.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-[#1a1a1a] p-6 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-gray-400 font-semibold mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500"
                        required>
                </div>

                <div>
                    <label for="subtitle" class="block text-gray-400 font-semibold mb-2">Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle') }}"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="category" class="block text-gray-400 font-semibold mb-2">Category</label>
                    <select id="category" name="category"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500"
                        required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}" 
                                {{ old('category') == $category->name ? 'selected' : '' }} 
                                data-children="{{ json_encode($category->children->pluck('name')) }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="subcategory" class="block text-gray-400 font-semibold mb-2">Subcategory</label>
                    <select id="subcategory" name="subcategory"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
                        <option value="">Select Subcategory</option>
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="image" class="block text-gray-400 font-semibold mb-2">Featured Image</label>
                    <input type="file" id="image" name="image"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
                </div>

                {{-- Content Section - UPDATED WITH WORKING CKEDITOR --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="content" class="block font-semibold mb-2 text-gray-400">Content</label>
                    <textarea id="content" name="content" rows="10" class="w-full bg-gray-400 border border-gray-700 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary" required>{{ old('content') }}</textarea>
                </div>

                <div class="col-span-1 md:col-span-2 flex justify-end">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                        Create Blog Post
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
            // --- DYNAMIC SUBCATEGORY LOGIC ---
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('subcategory');
            const oldSubcategory = "{{ old('subcategory') }}"; 

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

            if (categorySelect.value) {
                updateSubcategories();
            }

            categorySelect.addEventListener('change', updateSubcategories);
            // --- END DYNAMIC SUBCATEGORY LOGIC ---

            // CKEditor Initialization - USING WORKING VERSION FROM JOBS
            ClassicEditor
                .create(document.querySelector('#content'), {
                    ckfinder: {
                        uploadUrl: '{{ route('dashboard.blogs.upload') }}'
                    },
                    
                    // Force Black Text and White Background for better visibility
                    contentStyle: 'body { color: #000000 !important; background-color: #ffffff !important; }', 

                    toolbar: {
                        items: [
                            'heading', '|', 
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'uploadImage', 'blockQuote', '|', 
                            'undo', 'redo'
                        ]
                    }
                })
                .then(editor => {
                    console.log('CKEditor initialized for blog content', editor);

                    // Update the textarea before form submission
                    const form = document.querySelector('form');
                    if (form) {
                        form.addEventListener('submit', function() {
                            document.querySelector('#content').value = editor.getData();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
        });
    </script>
@endpush