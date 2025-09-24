@extends('layouts.admin_panel')

@section('content')

<div class="container mx-auto max-w-4xl">
    <h2 class="text-3xl font-bold orbitron mb-6 text-white">Add New Job Post</h2>

    <div class="card-bg p-8 rounded-lg shadow-lg">
        <form action="{{ route('dashboard.jobs.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="post_name" class="block mb-2 text-sm font-medium text-gray-400">Post Name</label>
                    <input type="text" id="post_name" name="post_name" class="w-full bg-white border border-gray-700 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('post_name') }}" required>
                </div>

                <div class="mb-4">
                    <label for="location" class="block mb-2 text-sm font-medium text-gray-400">Location</label>
                    <input type="text" id="location" name="location" class="w-full bg-white border border-gray-700 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('location') }}" required>
                </div>

                <div class="mb-4">
                    <label for="time" class="block mb-2 text-sm font-medium text-gray-400">Job Type</label>
                    <select id="time" name="time" class="w-full bg-white border border-gray-700 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                        <option value="Contract">Contract</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="section" class="block mb-2 text-sm font-medium text-gray-400">Post Section</label>
                    <select id="section" name="section" class="w-full bg-white border border-gray-700 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <option value="Engineering">Engineering</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Design">Design</option>
                        <option value="SEO">SEO Expert</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="job_description" class="block mb-2 text-sm font-medium text-gray-400">Job Description</label>
                <textarea id="job_description" name="job_description" rows="10" class="w-full bg-white border border-gray-700 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary" required>{{ old('job_description') }}</textarea>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-opacity-80 transition">Create Job Post</button>
                <a href="{{ route('dashboard.jobs.index') }}" class="px-6 py-2 bg-dark-3 text-white rounded-lg hover:bg-opacity-80 transition ml-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- TinyMCE Script Includes -->
<script src="https://cdn.tiny.cloud/1/vxg8uzmmaeixyal8pd4kbw5ynle2faavvmao3b6xv086l8vh/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
  tinymce.init({
    selector: '#job_description',
    plugins: [
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    uploadcare_public_key: '39570e4ec86cce90d031',
  });
</script>

@endsection
