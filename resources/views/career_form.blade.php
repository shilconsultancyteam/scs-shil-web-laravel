<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for {{ $job->post_name }} - Shil Consultancy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="grid-bg">

    @include('partials.header')

    <section id="application-form" class="py-20 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="service-card rounded-xl p-8 md:p-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text text-center">Application for {{ $job->post_name }}</h2>
                <p class="text-center text-gray-400 mb-8">Please fill out the form below to apply for this position.</p>

                <form action="{{ route('careers.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if ($errors->any())
        <div class="bg-red-500 bg-opacity-20 text-red-300 border border-red-500 p-4 rounded-lg mb-4">
            <h5 class="font-bold mb-2">There was a problem with your submission:</h5>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

                    <input type="hidden" name="job_id" value="{{ $job->id }}">

                    <div>
                        <label for="name" class="block text-lg font-medium text-gray-200 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-3 rounded-lg bg-dark-3 border border-gray-700 focus:outline-none focus:border-purple-500 text-black">
                    </div>

                    <div>
                        <label for="email" class="block text-lg font-medium text-gray-200 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-lg bg-dark-3 border border-gray-700 focus:outline-none focus:border-purple-500 text-black">
                    </div>

                    <div>
                        <label for="phone" class="block text-lg font-medium text-gray-200 mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required class="w-full px-4 py-3 rounded-lg bg-dark-3 border border-gray-700 focus:outline-none focus:border-purple-500 text-black">
                    </div>

                    <div>
                        <label for="cover_letter" class="block text-lg font-medium text-gray-200 mb-2">Cover Letter</label>
                        <textarea id="cover_letter" name="cover_letter" rows="6" required class="w-full px-4 py-3 rounded-lg bg-dark-3 border border-gray-700 focus:outline-none focus:border-purple-500 text-black"></textarea>
                    </div>

                    <div>
                        <label for="portfolio_link" class="block text-lg font-medium text-gray-200 mb-2">Portfolio Link (Optional)</label>
                        <input type="url" id="portfolio_link" name="portfolio_link" class="w-full px-4 py-3 rounded-lg bg-dark-3 border border-gray-700 focus:outline-none focus:border-purple-500 text-white">
                    </div>

                    <div>
                        <label for="cv" class="block text-lg font-medium text-gray-200 mb-2">Upload Your CV (PDF/DOC)</label>
                        <input type="file" id="cv" name="cv" required class="w-full text-white mt-2">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn-glow inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-full font-semibold shadow-lg hover:shadow-xl transition duration-300">
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @include('partials.footer')

</body>
</html>