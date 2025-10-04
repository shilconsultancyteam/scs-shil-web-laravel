@extends('layouts.template')

@section('title', 'Our Team')

@section('content')
<main id="team" class="py-20 relative overflow-hidden pt-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 gradient-text">Meet Our Team</h1>
            <p class="text-xl text-gray-300 max-w-4xl mx-auto">
                The architects of your digital success. A blend of creativity, technology, and strategy.
            </p>
        </div>

        <!-- Leadership: CEO + Manager -->
        <section class="mb-20">
            {{-- <h2 class="text-3xl md:text-4xl font-bold text-center mb-10 text-white orbitron">Leadership</h2> --}}
            <div class="flex flex-col md:flex-row justify-center items-start gap-10">
                <!-- CEO -->
                <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
                    <img src="{{asset('images/ceo.png')}}" alt="Photo of CEO" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="text-2xl font-bold text-white">Saikat Kumer Shill</h3>
                    <p class="gradient-text font-semibold">Chief Executive Officer</p>
                    <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                        <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                        <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                    </div>
                </div>
                <!-- Manager -->
                <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
                    <img src="{{asset('images/niaz.png')}}" alt="Photo of Manager" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover object-top">
                    <h3 class="text-2xl font-bold text-white">Niaz Morshed</h3>
                    <p class="gradient-text font-semibold">Brand Manager</p>
                    <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                        <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                        <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                    </div>
                </div>
            </div>
        </section>

       
<section class="mb-20">
     <h2 class="text-3xl md:text-4xl font-bold text-center mb-20  orbitron  gradient-text">Behind the Desks, Ahead in Dedication</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 justify-items-center">
       
        <!-- Tech Team Member 1 -->
        <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
            <img src="{{asset('images/pritom.jpeg')}}" alt="Pritom Paul" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
            <h3 class="text-2xl font-bold text-white">Pritom Paul</h3>
            <p class="gradient-text font-semibold">Senior Web Developer</p>
            <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
            </div>
        </div>

        <!-- Tech Team Member 2 -->
        <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
            <img src="{{asset('images/sadman.png')}}" alt="Sadman Mohammad" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover object-top">
            <h3 class="text-2xl font-bold text-white">Sadman Mohammad Yusuf</h3>
            <p class="gradient-text font-semibold">Frontend Specialist & WordPress Developer</p>
            <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
            </div>
        </div>

        <!-- Marketing Team Member 1 -->
        <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
            <img src="https://placehold.co/160x160/6e45e2/ffffff?text=TK" alt="Tania Khanam" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
            <h3 class="text-2xl font-bold text-white">Tania Khanam</h3>
            <p class="gradient-text font-semibold">Marketer</p>
            <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
            </div>
        </div>

        <!-- Marketing Team Member 2 -->
        <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
            <img src="https://placehold.co/160x160/6e45e2/ffffff?text=CF" alt="Chloe Foster" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
            <h3 class="text-2xl font-bold text-white">Chloe Foster</h3>
            <p class="gradient-text font-semibold">Social Media Manager</p>
            <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
            </div>
        </div>

        <!-- Graphics Team -->
        <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
            <img src="{{asset('images/arif.png')}}" alt="Ariful Islam Shawon" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
            <h3 class="text-2xl font-bold text-white">Ariful Islam Shawon</h3>
            <p class="gradient-text font-semibold">Graphics Designer</p>
            <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
            </div>
        </div>

        <!-- Admin Team -->
        <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
            <img src="https://placehold.co/160x160/6e45e2/ffffff?text=OH" alt="Olivia Harris" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
            <h3 class="text-2xl font-bold text-white">Olivia Harris</h3>
            <p class="gradient-text font-semibold">Office Manager</p>
            <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
            </div>
        </div>
    </div>
</section>


  
</main>
@endsection
