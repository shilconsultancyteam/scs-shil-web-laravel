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

  <section class="relative overflow-hidden pt-28 pb-20">
    <!-- Floating blobs -->
    <div class="absolute -right-32 -top-20 w-96 h-96 rounded-full bg-purple-600 opacity-20 blur-3xl"></div>
    <div class="absolute -left-32 -bottom-20 w-96 h-96 rounded-full bg-cyan-600 opacity-20 blur-3xl"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <!-- Back button -->
      <a href="{{ route('careers') }}" class="inline-flex items-center text-gray-300 hover:text-white transition-colors duration-300 mb-6">
        <i class="fas fa-arrow-left mr-2"></i> Back to Careers
      </a>

      <!-- Job header -->
      <div class="bg-gradient-to-r from-purple-800/60 to-cyan-700/60 rounded-2xl p-10 shadow-xl">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white text-center mb-3">
          {{ $job->post_name }}
        </h1>
        <p class="text-lg md:text-xl text-center text-gray-300 mb-6">
          {{ $job->section }}
        </p>

        <!-- Job metadata -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-center">
          <div class="flex flex-col items-center">
            <i class="fa-solid fa-location-dot text-purple-400 text-2xl mb-2"></i>
            <p class="text-gray-300 text-sm">Location</p>
            <p class="font-semibold text-white">{{ $job->location }}</p>
          </div>
          <div class="flex flex-col items-center">
            <i class="fa-solid fa-clock text-cyan-400 text-2xl mb-2"></i>
            <p class="text-gray-300 text-sm">Time</p>
            <p class="font-semibold text-white">{{ $job->time }}</p>
          </div>
          <div class="flex flex-col items-center">
            <i class="fa-solid fa-briefcase text-pink-400 text-2xl mb-2"></i>
            <p class="text-gray-300 text-sm">Job ID</p>
            <p class="font-semibold text-white">#{{ $job->id }}</p>
          </div>
        </div>
      </div>

      <!-- Job Description -->
      <div class="mt-12 bg-gray-900/60 backdrop-blur-md rounded-xl p-8 shadow-lg">
        <h2 class="text-2xl font-bold mb-4 gradient-text">Job Description</h2>
        <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed">
          {!! nl2br(e($job->job_description)) !!}
        </div>
      </div>

      <!-- Apply Button -->
      <div class="mt-12 text-center">
        <a href="{{ route('careers.apply', ['job_id' => $job->id]) }}"
           class="inline-block px-10 py-4 bg-gradient-to-r from-purple-600 to-cyan-500 
                  text-white rounded-full font-semibold shadow-lg hover:shadow-xl 
                  transform hover:scale-105 transition duration-300">
          Apply Now
        </a>
      </div>
    </div>
  </section>

  @include('partials.footer')

</body>
</html>
