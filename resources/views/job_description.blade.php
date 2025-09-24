<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->post_name }} - Job Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="grid-bg">

    @include('partials.header')

    <section class=" items-center relative overflow-hidden">
        <!-- Floating gradient blobs for visual interest -->
        <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full bg-purple-600 opacity-20 blur-3xl"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 rounded-full bg-blue-600 opacity-20 blur-3xl"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Back button -->
            <a href="{{ route('careers') }}" class="text-white hover:text-purple-400 transition-colors duration-300 flex items-center mb-6">
                <i class="fas fa-arrow-left mr-2"></i> Back to Careers
            </a>
            
            <!-- Main job details card -->
            <div class="service-card rounded-xl p-8 md:p-12 text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-3 gradient-text text-center">{{ $job->post_name }}</h1>
                <p class="text-lg md:text-xl text-center text-gray-400 mb-8">{{ $job->section }}</p>

                <!-- Job metadata -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <p class="text-lg"><strong class="text-gray-300">Location:</strong> <span class="text-gray-400">{{ $job->location }}</span></p>
                    <p class="text-lg"><strong class="text-gray-300">Time:</strong> <span class="text-gray-400">{{ $job->time }}</span></p>
                </div>

                <!-- Job Description section -->
                <div class="card-bg rounded-lg p-6">
                    <h2 class="text-2xl font-bold mb-4 gradient-text">Job Description</h2>
                    <div class="prose prose-invert max-w-none text-gray-300">
                        <p>{{ $job->job_description }}</p>
                    </div>
                </div>

                <!-- Apply Now button -->
                <div class="mt-8 text-center">
                    <a href="{{ route('careers.apply', ['job_id' => $job->id]) }}" class="btn-glow inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-full font-semibold shadow-lg hover:shadow-xl transition duration-300">
                        Apply Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

</body>
</html>
