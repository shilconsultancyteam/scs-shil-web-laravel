@extends('layouts.template')

@section('title', 'Our Team')

@section('content')
<main id="team" class="py-20 relative overflow-hidden pt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 gradient-text">Meet Our Team</h1>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">The architects of your digital success. A blend of creativity, technology, and strategy.</p>
            </div>

            <!-- CEO Section -->
            <section class="mb-20">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-10 text-white orbitron">Leadership</h2>
                <div class="flex justify-center">
                    <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
                        <img src="{{asset('images/ceo.png')}}" alt="Photo of John Doe" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
                        <h3 class="text-2xl font-bold text-white">Saikat Kumer Shill</h3>
                        <p class="gradient-text font-semibold">Chief Executive Officer</p>
                        <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                            <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                            <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Managers Section -->
        <section class="mb-20">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-10 text-white orbitron"> Manager</h2>
                <div class="flex justify-center">
                    <div class="team-card rounded-xl p-6 w-full max-w-sm text-center">
                        <img src="{{asset('images/niaz.png')}}" alt="Photo of Niaz Morshed" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover object-top">
                        <h3 class="text-2xl font-bold text-white">Niaz Morshed</h3>
                        <p class="gradient-text font-semibold">Brand Manager</p>
                        <div class="mt-4 flex justify-center space-x-4 text-gray-400">
                            <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in text-xl"></i></a>
                            <a href="#" class="hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Department Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-16 ">
                <!-- Tech Team -->
                <section>
                    <h2 class="text-3xl font-bold mb-8 text-white orbitron">Tech Team</h2>
                    <div class="space-y-6">
                        <div class="team-card rounded-lg p-4 flex items-center space-x-4">
                           <img src="{{asset('images/pritom.jpeg')}}" alt="Photo of Alex Lee" class="w-16 h-16 rounded-full flex-shrink-0 object-cover">
                           <div>
                               <h3 class="font-bold text-white">Pritom Paul</h3>
                               <p class="text-sm text-gray-400">Senior Web Developer</p>
                           </div>
                        </div>
                         <div class="team-card rounded-lg p-4 flex items-center space-x-4">
                           <img src="{{asset('images/sadman.png')}}" alt="Photo of Samantha Kim" class="w-16 h-16 rounded-full flex-shrink-0 object-cover object-top">
                           <div>
                               <h3 class="font-bold text-white">Sadman Bin Yusuf</h3>
                               <p class="text-sm text-gray-400">Frontend Specialist & wordpress devloper</p>
                           </div>
                        </div>
                    </div>
                </section>
                <!-- Marketing Team -->
                <section>
                    <h2 class="text-3xl font-bold mb-8 text-white orbitron">Marketing Team</h2>
                     <div class="space-y-6">
                        <div class="team-card rounded-lg p-4 flex items-center space-x-4">
                           <img src="https://placehold.co/64x64/6e45e2/ffffff?text=TK" alt="Photo of Ben Williams" class="w-16 h-16 rounded-full flex-shrink-0 object-cover">
                           <div>
                               <h3 class="font-bold text-white">Tania Khanam</h3>
                               <p class="text-sm text-gray-400">Marketter</p>
                           </div>
                        </div>
                         <div class="team-card rounded-lg p-4 flex items-center space-x-4">
                           <img src="https://placehold.co/64x64/6e45e2/ffffff?text=CF" alt="Photo of Chloe Foster" class="w-16 h-16 rounded-full flex-shrink-0 object-cover">
                           <div>
                               <h3 class="font-bold text-white">Chloe Foster</h3>
                               <p class="text-sm text-gray-400">Social Media Manager</p>
                           </div>
                        </div>
                    </div>
                </section>
                <!-- Creative Team -->
                 <section>
                    <h2 class="text-3xl font-bold mb-8 text-white orbitron">Graphics Team</h2>
                     <div class="space-y-6">
                        <div class="team-card rounded-lg p-4 flex items-center space-x-4">
                           <img src="https://placehold.co/64x64/6e45e2/ffffff?text=DG" alt="Photo of David Garcia" class="w-16 h-16 rounded-full flex-shrink-0 object-cover">
                           <div>
                               <h3 class="font-bold text-white">Ariful Islam Shawon</h3>
                               <p class="text-sm text-gray-400">Graphics Designer</p>
                           </div>
                        </div>
                    </div>
                </section>
                <!-- Admin Team -->
                 <section>
                    <h2 class="text-3xl font-bold mb-8 text-white orbitron">Admin Team</h2>
                     <div class="space-y-6">
                        <div class="team-card rounded-lg p-4 flex items-center space-x-4">
                           <img src="https://placehold.co/64x64/6e45e2/ffffff?text=OH" alt="Photo of Olivia Harris" class="w-16 h-16 rounded-full flex-shrink-0 object-cover">
                           <div>
                               <h3 class="font-bold text-white">Olivia Harris</h3>
                               <p class="text-sm text-gray-400">Office Manager</p>
                           </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

@endsection

@push('scripts')
<script>
  
</script>
@endpush
