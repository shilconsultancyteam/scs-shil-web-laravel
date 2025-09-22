<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->get();
        return view('dashboard.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('dashboard.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'time' => 'required|in:Full-time,Part-time,Contract',
            'section' => 'required|string|max:255',
        ]);

        Job::create($request->all());

        return redirect()->route('dashboard.jobs.index')->with('success', 'Job post created successfully.');
    }

    public function edit(Job $job)
    {
        return view('dashboard.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'post_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'time' => 'required|in:Full-time,Part-time,Contract',
            'section' => 'required|string|max:255',
        ]);

        $job->update($request->all());

        return redirect()->route('dashboard.jobs.index')->with('success', 'Job post updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('dashboard.jobs.index')->with('success', 'Job post deleted successfully.');
    }
}
