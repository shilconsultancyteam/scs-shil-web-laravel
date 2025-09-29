@extends('layouts.admin_panel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-white">Manage Blog Posts</h2>
            <a href="{{ route('dashboard.blogs.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Add New Blog
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#1a1a1a] rounded-lg shadow-lg overflow-hidden">
            <table class="w-full text-left text-gray-300">
                <thead>
                    <tr class="uppercase text-sm bg-gray-900 border-b border-gray-700">
                        <th class="p-4">Title</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Comments</th>
                        <th class="p-4">Published Date</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blogs as $blog)
                        <tr class="border-b border-gray-700 hover:bg-gray-800">
                            <td class="p-4 font-semibold">{{ Str::limit($blog->title, 50) }}</td>
                            <td class="p-4">{{ $blog->category }}</td>
                            <td class="p-4">{{ $blog->comments_count ?? 0 }}</td>
                            <td class="p-4">{{ $blog->created_at->format('Y-m-d') }}</td>
                            <td class="p-4 text-center">
                                <a href="{{ route('dashboard.blogs.edit', $blog->slug) }}"
                                    class="text-blue-400 hover:text-blue-200 mr-4" title="Edit"><i
                                        class="fas fa-edit"></i></a>

                                <form action="{{ route('dashboard.blogs.destroy', $blog->slug) }}" method="POST"
                                    class="inline-block" id="delete-form-{{ $blog->slug }}"
                                    onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-300" title="Delete"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No blog posts found. Click "Add New Blog" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection