@extends('layouts.admin_panel')

@section('content')
    <div class="container mx-auto max-w-4xl">
        <h2 class="text-3xl font-bold orbitron mb-6">Edit Job Post</h2>

        <div class="card-bg p-8 rounded-lg shadow-lg">
            <form action="{{ route('dashboard.jobs.update', $job) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="post_name" class="block mb-2 text-sm font-medium text-gray-400">Post Name</label>
                        <input type="text" id="post_name" name="post_name"
                            class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-black focus:outline-none focus:ring-2 focus:ring-primary"
                            value="{{ old('post_name', $job->post_name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-400">Location</label>

                        <select id="location" name="location" required
                            class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-black focus:outline-none focus:ring-2 focus:ring-primary">

                            <option value="">Select Job Location</option>

                            <option value="Head office: Golpahar, Rahim mention"
                                {{ old('location', $job->location ?? '') == 'Head office: Golpahar, Rahim mention' ? 'selected' : '' }}>
                                Head office: Golpahar, Rahim mention
                            </option>

                            <option value="Branch office: California"
                                {{ old('location', $job->location ?? '') == 'Branch office: California' ? 'selected' : '' }}>
                                Branch office: California
                            </option>

                            <option value="Branch office: UK"
                                {{ old('location', $job->location ?? '') == 'Branch office: UK' ? 'selected' : '' }}>
                                Branch office: UK
                            </option>

                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="time" class="block mb-2 text-sm font-medium text-gray-400">Time</label>
                        <select id="time" name="time"
                            class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-black focus:outline-none focus:ring-2 focus:ring-primary"
                            required>
                            <option value="Full-time" {{ $job->time == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Part-time" {{ $job->time == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="Contract" {{ $job->time == 'Contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="section" class="block mb-2 text-sm font-medium text-gray-400">Post Section</label>
                        <select id="section" name="section"
                            class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-black focus:outline-none focus:ring-2 focus:ring-primary"
                            required>
                            <option value="Engineering" {{ $job->section == 'Engineering' ? 'selected' : '' }}>Engineering
                            </option>
                            <option value="Marketing" {{ $job->section == 'Marketing' ? 'selected' : '' }}>Marketing
                            </option>
                            <option value="Design" {{ $job->section == 'Design' ? 'selected' : '' }}>Design</option>
                            <option value="SEO" {{ $job->section == 'SEO Expert' ? 'selected' : '' }}>SEO Expert
                            </option>
                        </select>
                    </div>
                    <div class="mb-4 w-[850px]">
                        <label for="job_description" class="block mb-2 text-sm font-medium text-gray-400">Job
                            Description</label>
                        <textarea id="job_description" name="job_description" rows="10"
                            class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-primary"
                            required>{{ old('job_description', $job->job_description) }}</textarea>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-opacity-80 transition">Update Job
                        Post</button>
                    <a href="{{ route('dashboard.jobs.index') }}"
                        class="px-6 py-2 bg-dark-3 text-white rounded-lg hover:bg-opacity-80 transition ml-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#job_description'), {
                    ckfinder: {
                        uploadUrl: '{{ route('dashboard.jobs.upload') }}'
                    },

                    // 🌟 UPDATED: Force Black Text and White Background
                    contentStyle: `
                body { 
                    color: #000000 !important; 
                    background-color: #ffffff !important; 
                    font-size: 14px;
                }
                .ck-content {
                    color: #000000 !important;
                    background-color: #ffffff !important;
                }
                .ck-editor__editable {
                    color: #000000 !important;
                    background-color: #ffffff !important;
                }
            `,

                    toolbar: {
                        items: [
                            'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                            'uploadImage', 'blockQuote', '|', 'undo', 'redo'
                        ]
                    }
                })
                .then(editor => {
                    console.log('CKEditor initialized for job_description', editor);

                    // CRUCIAL: Add a listener to update the hidden textarea before form submission
                    const form = document.querySelector('form');
                    if (form) {
                        form.addEventListener('submit', function() {
                            document.querySelector('#job_description').value = editor.getData();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
        });
    </script>
@endsection
