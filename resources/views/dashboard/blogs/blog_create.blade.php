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
                        @foreach (array_keys($categories) as $category)
                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                {{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="subcategory" class="block text-gray-400 font-semibold mb-2">Subcategory</label>
                    <select id="subcategory" name="subcategory"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
                        <option value="">Select Subcategory</option>
                        @if (old('category') && isset($categories[old('category')]))
                            @foreach ($categories[old('category')] as $subcategory)
                                <option value="{{ $subcategory }}"
                                    {{ old('subcategory') == $subcategory ? 'selected' : '' }}>{{ $subcategory }}</option>
                            @endforeach
                        @endif
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
            // Subcategory logic
            const categories = @json($categories);
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('subcategory');
            // ... (rest of the subcategory logic) ...

            // CKEditor Initialization (using #editor)
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    ckfinder: {
                        uploadUrl: "{{ route('dashboard.blogs.upload') }}"
                    },
                    // ... (rest of the CKEditor configuration) ...
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