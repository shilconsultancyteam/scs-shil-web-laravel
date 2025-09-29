@extends('layouts.admin_panel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-white">Manage Blog Comments</h2>
            </div>

        @if (session('success'))
            <div class="bg-green-500/20 text-green-300 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-500/20 text-red-300 p-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif


        <div class="bg-[#1a1a1a] rounded-lg shadow-lg overflow-hidden">
            <table class="w-full text-left text-gray-300">
                <thead>
                    <tr class="uppercase text-sm bg-gray-900 border-b border-gray-700">
                        <th class="p-4">Commenter</th>
                        <th class="p-4">Comment</th>
                        <th class="p-4">Post</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        <tr class="border-b border-gray-700 hover:bg-gray-800">
                            <td class="p-4">
                                <span class="font-semibold">{{ $comment->name }}</span>
                                <br>
                                <span class="text-xs text-gray-500">{{ $comment->email }}</span>
                            </td>

                            <td class="p-4">
                                {{ Str::limit($comment->comment, 80) }}
                                <br>
                                <span class="text-xs text-gray-500">Posted: {{ $comment->created_at->diffForHumans() }}</span>
                            </td>

                            <td class="p-4">
                                <a href="{{ route('public.blogs.show', $comment->blog->slug) }}" target="_blank"
                                    class="text-blue-400 hover:text-blue-200">
                                    {{ Str::limit($comment->blog->title, 30) }}
                                </a>
                            </td>

                            <td class="p-4">
                                @if ($comment->status === 'approved')
                                    <span class="bg-green-600/20 text-green-400 text-xs font-medium px-2.5 py-1 rounded-full">Approved</span>
                                @elseif ($comment->status === 'rejected')
                                    <span class="bg-red-600/20 text-red-400 text-xs font-medium px-2.5 py-1 rounded-full">Rejected</span>
                                @else
                                    <span class="bg-yellow-600/20 text-yellow-400 text-xs font-medium px-2.5 py-1 rounded-full">Pending</span>
                                @endif
                            </td>

                            <td class="p-4 text-center whitespace-nowrap">
                                
                                {{-- 1. Approve Button (only if not already approved) --}}
                                @if ($comment->status !== 'approved')
                                    <form action="{{ route('dashboard.comments.update', $comment->id) }}" method="POST" class="inline-block mx-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="text-green-500 hover:text-white" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- 2. Reject/Pending Button (toggle based on status) --}}
                                @if ($comment->status !== 'pending')
                                    <form action="{{ route('dashboard.comments.update', $comment->id) }}" method="POST" class="inline-block mx-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="pending">
                                        <button type="submit" class="text-yellow-500 hover:text-white" title="Set to Pending">
                                            <i class="fas fa-hourglass-half"></i>
                                        </button>
                                    </form>
                                @endif


                                {{-- 3. Delete Form --}}
                                <form action="{{ route('dashboard.comments.destroy', $comment->id) }}" method="POST"
                                    class="inline-block mx-1"
                                    onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-white" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No comments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $comments->links() }}
        </div>
    </div>
@endsection