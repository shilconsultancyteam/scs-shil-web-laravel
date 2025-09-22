@extends('layouts.admin_panel')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold orbitron">Manage Job Posts</h2>
        <a href="{{ route('dashboard.jobs.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-80 transition">
            <i class="fas fa-plus mr-2"></i>Add New Job
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500/20 text-green-300 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-bg rounded-lg shadow-lg overflow-hidden">
        <table class="w-full text-left table-custom">
            <thead>
                <tr class="border-b border-dark-3">
                    <th class="p-4">Post Name</th>
                    <th class="p-4">Location</th>
                    <th class="p-4">Time</th>
                    <th class="p-4">Section</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobs as $job)
                    <tr class="border-b border-dark-3">
                        <td class="p-4">{{ $job->post_name }}</td>
                        <td class="p-4">{{ $job->location }}</td>
                        <td class="p-4">{{ $job->time }}</td>
                        <td class="p-4">{{ $job->section }}</td>
                        <td class="p-4 text-center">
                            <a href="{{ route('dashboard.jobs.edit', $job) }}" class="text-secondary hover:text-white mr-4"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('dashboard.jobs.destroy', $job) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this job post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-accent hover:text-white"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">No job posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection