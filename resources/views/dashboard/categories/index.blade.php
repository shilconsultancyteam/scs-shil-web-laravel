{{-- resources/views/dashboard/categories/index.blade.php (Tailwind CSS Version) --}}

@extends('layouts.admin_panel') 

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Category Management</h1>

    {{-- Session Message Display (Tailwind Alerts) --}}
    @if(Session::has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ Session::get('success') }}</span>
        </div>
    @endif
    @if(Session::has('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Warning!</strong>
            <span class="block sm:inline">{{ Session::get('warning') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Whoops!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white shadow-lg rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-700">Add New Category / Subcategory</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('dashboard.categories.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    
                    {{-- Category Name Input --}}
                    <div class="md:col-span-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                        <input type="text" name="name" id="name" 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-500 @enderror" 
                               required value="{{ old('name') }}">
                    </div>

                    {{-- Parent Category Select --}}
                    <div class="md:col-span-5">
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent Category (Optional)</label>
                        <select name="parent_id" id="parent_id" 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">-- Top Level Category --</option>
                            {{-- $parent_categories is passed from the index() method --}}
                            @foreach ($parent_categories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Add Button --}}
                    <div class="md:col-span-2">
                        <button type="submit" class="w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Add Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-700">Existing Categories</h3>
        </div>
        
        <ul class="divide-y divide-gray-200">
            @forelse ($categories as $category)
                <li class="p-6 flex justify-between items-start hover:bg-gray-50 transition duration-150 ease-in-out">
                    
                    {{-- Category Display (Name and Subcategories) --}}
                    <div class="flex-grow">
                        <strong class="text-lg font-medium text-gray-900">{{ $category->name }}</strong>
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            Parent
                        </span>
                        
                        <div class="mt-2 ml-4 border-l-2 border-gray-200 pl-4">
                            {{-- Display Subcategories --}}
                            @if ($category->children->count())
                                <p class="text-sm font-semibold text-gray-600 mb-1">Subcategories ({{ $category->children->count() }})</p>
                                <ul class="space-y-1">
                                    @foreach ($category->children as $subCategory)
                                        <li class="flex items-center justify-between text-sm text-gray-600 group">
                                            <span>&bull; {{ $subCategory->name }}</span>
                                            
                                            {{-- Subcategory Delete Form --}}
                                            <form action="{{ route('dashboard.categories.destroy', $subCategory->id) }}" method="POST" class="ml-4" onsubmit="return confirm('Are you sure you want to delete the subcategory \'{{ $subCategory->name }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 text-xs font-medium transition duration-150 ease-in-out px-2 py-1 rounded-md border border-red-500 hover:bg-red-50">
                                                    Delete
                                                </button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-sm text-gray-500 italic">No subcategories.</span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Parent Category Actions (Edit/Delete) --}}
                    <div class="flex space-x-2">
                        <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Edit
                        </a>
                        
                        {{-- Parent Category Delete Form --}}
                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to delete the parent category \'{{ $category->name }}\'? All its {{ $category->children->count() }} subcategories will also be deleted!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Delete Parent
                            </button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="p-6 text-center text-gray-500 italic">
                    No categories found. Use the form above to add your first category!
                </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection