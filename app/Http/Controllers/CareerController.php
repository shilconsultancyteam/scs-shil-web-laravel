<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CareerController extends Controller
{
     public function index()
    {
        $jobs = Job::latest()->get();
        return view('career', compact('jobs'));
    }

    public function showApplicationForm($job_id)
    {
        $job = Job::findOrFail($job_id);
        return view('career_form', compact('job'));
    }

    public function submitApplication(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'required|string',
            'portfolio_link' => 'nullable|url|max:255',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'job_id' => 'required|exists:jobs,id',
        ]);

        $cvPath = $request->file('cv')->store('resumes', 'public');

        Application::create([
            'job_id' => $request->job_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cover_letter' => $request->cover_letter,
            'portfolio_link' => $request->portfolio_link,
            'cv_path' => $cvPath,
        ]);

        return redirect()->route('careers')->with('success', 'Your application has been submitted successfully!');
    }

    public function showApplicants()
    {
        $applicants = Application::with('job')->latest()->get();
        return view('dashboard.jobs.applicants', compact('applicants'));
    }
    public function showJobDescription($job_id)
    {
        $job = Job::findOrFail($job_id);
        return view('job_description', compact('job'));
    }
}