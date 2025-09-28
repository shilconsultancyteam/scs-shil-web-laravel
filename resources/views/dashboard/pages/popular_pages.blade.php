@extends('layouts.admin_panel')

@section('content')
<div class="card-bg p-6 rounded-xl mb-6">
    <h3 class="text-xl font-bold text-white mb-4">Top 10 Popular Pages</h3>
    <ul class="space-y-2 text-gray-300">
        @foreach ($popular as $item)
            <li class="flex justify-between">
                <span>{{ $item->page }}</span>
                <span class="font-bold">{{ $item->total_views }} views</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
