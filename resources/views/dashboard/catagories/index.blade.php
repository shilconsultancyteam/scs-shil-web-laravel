@extends('layouts.admin_panel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-white">Manage Blog Categories</h2>
            <button onclick="openAddCategoryModal()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Add New Category
            </button>
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
                                <button onclick="editCategory('{{ $category }}')" 
                                    class="text-yellow-400 hover:text-white mr-3" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button onclick="deleteCategory('{{ $category }}')" 
                                    class="text-red-500 hover:text-white" title="Delete">
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
        
        <!-- Add Category Modal -->
        <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-[#1a1a1a] rounded-lg p-6 w-full max-w-md">
                <h3 class="text-xl font-bold text-white mb-4">Add New Category</h3>
                <form action="{{ route('dashboard.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-300 mb-2">Category Name</label>
                        <input type="text" name="name" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-300 mb-2">Parent Category (Optional)</label>
                        <select name="parent_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">None (Main Category)</option>
                            @foreach ($categories as $category => $subcategories)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAddCategoryModal()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-8 p-4 bg-yellow-600/20 text-yellow-300 rounded-lg">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Note:</strong> These categories are currently hardcoded. To enable full CRUD functionality, you'll need to:
            <ul class="mt-2 list-disc list-inside">
                <li>Create a Category model and migration</li>
                <li>Update the CategoryController to use the database</li>
                <li>Implement the edit and delete functionality</li>
            </ul>
        </div>
    </div>

    <script>
        function openAddCategoryModal() {
            document.getElementById('addCategoryModal').classList.remove('hidden');
        }

        function closeAddCategoryModal() {
            document.getElementById('addCategoryModal').classList.add('hidden');
        }

        function editCategory(categoryName) {
            alert('Edit functionality for: ' + categoryName + '\n\nThis will be implemented when you create the Category model and database table.');
        }

        function deleteCategory(categoryName) {
            if (confirm('Are you sure you want to delete: ' + categoryName + '?')) {
                alert('Delete functionality for: ' + categoryName + '\n\nThis will be implemented when you create the Category model and database table.');
            }
        }

        // Close modal when clicking outside
        document.getElementById('addCategoryModal').addEventListener('click', function(e) {
            if (e.target.id === 'addCategoryModal') {
                closeAddCategoryModal();
            }
        });
    </script>
@endsection