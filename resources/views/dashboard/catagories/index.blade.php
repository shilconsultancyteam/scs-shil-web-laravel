@extends('layouts.admin_panel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-white">Manage Blog Categories</h2>
            <a href="{{ route('dashboard.categories.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Add New Category
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500/20 text-green-300 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="bg-[#1a1a1a] rounded-lg shadow-lg overflow-hidden">
            <table class="w-full text-left text-gray-300">
                <thead>
                    <tr class="uppercase text-sm bg-gray-900 border-b border-gray-700">
                        <th class="p-4 w-1/4">Category Name</th>
                        <th class="p-4 w-3/4">Subcategories</th>
                        <th class="p-4 text-center w-24">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through the hardcoded $categories array from your controller --}}
                    @forelse ($categories as $category => $subcategories)
                        <tr class="border-b border-gray-700 hover:bg-gray-800">
                            <td class="p-4 font-semibold text-lg text-blue-400">
                                {{ $category }}
                            </td>

                            <td class="p-4">
                                @if (count($subcategories) > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($subcategories as $sub)
                                            <span class="bg-gray-700 text-gray-300 text-xs font-medium px-3 py-1 rounded-full">
                                                {{ $sub }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500 italic">No subcategories defined.</span>
                                @endif
                            </td>

                            <td class="p-4 text-center whitespace-nowrap">
                                {{-- NOTE: These routes assume you will build a Category model and Controller later --}}
                                <a href="#" 
                                    class="text-yellow-400 hover:text-white mr-3" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="text-red-500 hover:text-white" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-8 p-4 bg-yellow-600/20 text-yellow-300 rounded-lg">
            <i class="fas fa-info-circle mr-2"></i>
            **Note on Structure:** These categories are currently hardcoded in your `Admin\BlogController.php`. To make the "Edit" and "Delete" actions functional, you will need to migrate this data to a dedicated **`Category` database table** and create an **`Admin\CategoryController`** to manage the data.
        </div>
    </div>
@endsection