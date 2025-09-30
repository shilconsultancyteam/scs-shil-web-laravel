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
                        {{-- Iterate over the Eloquent Collection $categories --}}
                        @foreach ($categories as $category)
                            {{-- Store children names as JSON data attribute --}}
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
                        {{-- Subcategories will be populated by JavaScript --}}
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="image" class="block text-gray-400 font-semibold mb-2">Featured Image</label>
                    <input type="file" id="image" name="image"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="content" class="block font-semibold mb-2">Content</label>
                    <textarea id="content" name="content" class="hidden" required>{{ old('content') }}</textarea>
                    <div id="editor">{!! old('content') !!}</div>
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
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- DYNAMIC SUBCATEGORY LOGIC ---
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('subcategory');
            // Store the old subcategory value to persist selection after validation errors
            const oldSubcategory = "{{ old('subcategory') }}"; 

            function updateSubcategories() {
                // Clear existing subcategories
                subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

                const selectedOption = categorySelect.options[categorySelect.selectedIndex];

                // Get the children data attribute (containing JSON string of subcategory names)
                const childrenJson = selectedOption.getAttribute('data-children');
                
                if (childrenJson) {
                    try {
                        const children = JSON.parse(childrenJson);

                        children.forEach(function(subCategoryName) {
                            const option = document.createElement('option');
                            option.value = subCategoryName;
                            option.textContent = subCategoryName;
                            
                            // Select the option if it matches the old submitted value
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

            // Initial load check for old input persistence
            if (categorySelect.value) {
                updateSubcategories();
            }

            // Event listener for category change
            categorySelect.addEventListener('change', updateSubcategories);
            // --- END DYNAMIC SUBCATEGORY LOGIC ---


            // CKEditor Initialization (using #editor)
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    ckfinder: {
                        uploadUrl: "{{ route('dashboard.blogs.upload') }}"
                    },
                })
                .then(editor => {
                    // Update the hidden textarea ('content') on submit
                    const form = document.querySelector('form');
                    form.addEventListener('submit', function() {
                        document.getElementById('content').value = editor.getData();
                    });
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
        });
    </script>
@endpush