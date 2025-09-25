<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO Services - Search Engine Experts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #1a73e8 }
        }
        .typing-animation {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            border-right: 2px solid #1a73e8;
            animation: 
                typing 3.5s steps(40, end),
                blink-caret .75s step-end infinite;
        }
        .search-box {
            box-shadow: 0 2px 5px 1px rgba(64,60,67,.16);
        }
        .search-box:focus-within {
            box-shadow: 0 2px 8px 1px rgba(64,60,67,.24);
        }
        .result-card:hover {
            box-shadow: 0 1px 6px rgba(32,33,36,.28);
        }
        .nav-item:hover {
            color: #1a73e8;
            border-bottom: 3px solid #1a73e8;
        }
        .nav-item.active {
            color: #1a73e8;
            border-bottom: 3px solid #1a73e8;
        }
        .pagination-btn:hover {
            background-color: #f8f9fa;
        }
        @media (max-width: 640px) {
            .search-container {
                width: 90%;
            }
        }
        section {
            padding-top: 80px; 
            margin-top: -80px;
        }
    </style>
</head>
<body class="bg-white min-h-screen font-sans">
    
    <nav class="fixed w-full z-50 bg-black bg-opacity-100 backdrop-filter backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{url('/')}}">
                            <h1 class="text-2xl font-bold" style="color: #fff; font-family: 'Orbitron', sans-serif;">SHIL CONSULTANCY</h1>
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="https://shilconsultancy.com/#services" class="text-white px-3 py-2 rounded-md text-sm font-medium">Services</a>
                        <a href="https://shilconsultancy.com/#about" class="text-white px-3 py-2 rounded-md text-sm font-medium">About</a>
                        <a href="https://shilconsultancy.com/#work" class="text-white px-3 py-2 rounded-md text-sm font-medium">Work</a>
                        <a href="https://shilconsultancy.com/#contact" class="text-white px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                    </div>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                 <a href="#home" class="text-white block px-3 py-2 rounded-md text-base font-medium">Home</a>
                 <a href="#services" class="text-white block px-3 py-2 rounded-md text-base font-medium">Services</a>
                 <a href="#about" class="text-white block px-3 py-2 rounded-md text-base font-medium">About</a>
                 <a href="#work" class="text-white block px-3 py-2 rounded-md text-base font-medium">Work</a>
                 <a href="#contact" class="text-white block px-3 py-2 rounded-md text-base font-medium">Contact</a>
            </div>
        </div>
    </nav>
    
    <header class="sticky top-0 bg-white shadow-sm z-10" style="padding-top: 80px;"> <div class="container mx-auto px-4 py-3">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center justify-between mb-4 md:mb-0">
                    <div class="flex items-center">
                        <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="SEO Services" class="h-8 w-auto">
                        <span class="ml-2 text-gray-600 text-lg">SEO</span>
                    </div>
                </div>
                
                <div class="search-container mx-auto md:mx-0 md:w-1/2 lg:w-2/5">
                    <div class="search-box flex items-center w-full rounded-full border border-gray-200 px-4 py-3 transition-all duration-200">
                        <i class="fas fa-search text-gray-400 mr-3"></i>
                        <input type="text" placeholder="Search for SEO services..." class="w-full focus:outline-none text-gray-800" id="searchInput">
                        <div class="flex space-x-2">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-microphone"></i>
                            </button>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-4">
                    <button class="text-gray-600 hover:text-blue-600">
                        <i class="fas fa-th"></i>
                    </button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Sign In
                    </button>
                </div>
            </div>
            
            <div class="flex overflow-x-auto mt-4 pb-2 hide-scrollbar">
                <div class="flex space-x-8">
                    <a href="#all" class="nav-item active text-sm pb-2 px-1 whitespace-nowrap">All</a>
                    <a href="#about-us" class="nav-item text-sm pb-2 px-1 whitespace-nowrap">About Us</a>
                    <a href="#services" class="nav-item text-sm pb-2 px-1 whitespace-nowrap">Services</a>
                    <a href="#pricing" class="nav-item text-sm pb-2 px-1 whitespace-nowrap">Pricing</a>
                    <a href="#contact" class="nav-item text-sm pb-2 px-1 whitespace-nowrap">Contact</a>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6 max-w-4xl">
        <section id="all">
            <div class="text-sm text-gray-600 mb-6">
                About 127,000,000 results (0.39 seconds)
            </div>
        </section>

        <section id="what-is-seo">
            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <div class="mr-4 text-blue-500">
                        <i class="fas fa-lightbulb text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-medium text-gray-900 mb-2">What is SEO?</h2>
                        <p class="text-gray-700 mb-3">
                            SEO, or Search Engine Optimization, is a strategic digital marketing discipline that enhances website visibility in organic search results through technical optimizations, content excellence, and authoritative link acquisition. A holistic approach combines cutting-edge techniques with white-hat principles to drive sustainable, high-converting traffic.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded">On-page SEO</span>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded">Off-page SEO</span>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded">Technical SEO</span>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded">Local SEO</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="about-us">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">About Shil Consultancy</h2>
            <div class="result-card p-4 rounded-lg transition duration-150">
                 <div class="flex items-center text-sm text-gray-500 mb-1">
                    <span class="text-green-700">www.shilconsultancy.com</span>
                    <span class="mx-1">›</span>
                    <span>about-us</span>
                </div>
                <h3 class="text-xl text-blue-700 hover:underline mb-1">
                    <a href="#">Your Digital Growth Partner in Chittagong</a>
                </h3>
                <p class="text-gray-700 mb-2">
                    Shil Consultancy is a premier digital marketing agency based in the heart of Chittagong, Bangladesh. We are passionate about helping local and national businesses thrive in the digital landscape. Our team of certified experts specializes in creating data-driven SEO strategies that deliver not just rankings, but real, measurable results and sustainable growth for our clients.
                </p>
                 <div class="flex items-center text-sm text-gray-600 mt-2">
                    <span class="mr-4"><i class="fas fa-users text-blue-500 mr-1"></i> Certified Experts</span>
                    <span><i class="fas fa-bullseye text-red-500 mr-1"></i> Results-Driven Approach</span>
                </div>
            </div>
        </section>

        <section id="services">
            <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">Our Services</h2>
            <div class="space-y-6">
                <div class="result-card p-4 rounded-lg transition duration-150">
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <span class="text-green-700">www.shilconsultancy.com</span>
                        <span class="mx-1">›</span>
                        <span>premium-seo</span>
                    </div>
                    <h3 class="text-xl text-blue-700 hover:underline mb-1">
                        <a href="#">Premium SEO Services - Get First Page Rankings</a>
                    </h3>
                    <p class="text-gray-700 mb-2">
                        Our premium SEO services deliver measurable results through data-driven strategies. Our certified experts optimize every aspect of your online presence, from technical SEO audits to content optimization and authoritative link building.
                    </p>
                </div>
                <div class="result-card p-4 rounded-lg transition duration-150">
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <span class="text-green-700">www.shilconsultancy.com</span>
                        <span class="mx-1">›</span>
                        <span>local-seo</span>
                    </div>
                    <h3 class="text-xl text-blue-700 hover:underline mb-1">
                        <a href="#">Local SEO Services - Get Found in Your Area</a>
                    </h3>
                    <p class="text-gray-700 mb-2">
                        We help businesses dominate their geographic markets. We implement hyper-local strategies including Google Business Profile optimization, localized content creation, citation building, and reputation management.
                    </p>
                </div>
            </div>
        </section>
        
        <section id="pricing">
            <h2 class="text-2xl font-semibold text-gray-800 my-4">Pricing</h2>
            <div class="result-card p-4 rounded-lg transition duration-150">
                <div class="flex items-center text-sm text-gray-500 mb-1">
                    <span class="text-green-700">www.shilconsultancy.com</span>
                    <span class="mx-1">›</span>
                    <span>pricing</span>
                </div>
                <h3 class="text-xl text-blue-700 hover:underline mb-1">
                    <a href="#">Affordable SEO Packages - Starting at $299/month</a>
                </h3>
                <p class="text-gray-700 mb-2">
                    We offer transparent, performance-based SEO packages with flexible monthly engagements, backed by detailed monthly performance reports and ROI analysis.
                </p>
            </div>
        </section>

        <section id="contact">
            <h2 class="text-2xl font-semibold text-gray-800 my-4">Contact Us</h2>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                <p class="text-gray-700 mb-4">Ready to boost your rankings? Get in touch with our team in Chittagong for a free consultation.</p>
                <a href=" https://shilconsultancy.com/#contact">
                    <button class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition font-semibold">
                    Request a Free SEO Audit
                    </button>
                </a>
            </div>
        </section>
    </main>

    <footer class="py-12 bg-black bg-opacity-100 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-2xl font-bold mb-4" style="font-family: 'Orbitron', sans-serif;">SHIL CONSULTANCY</h3>
                    <p class="text-gray-400">Innovative digital solutions for forward-thinking businesses.</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#services" class="text-gray-400 hover:text-white">Web Development</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white">E-Commerce</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white">Digital Marketing</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white">Content Creation</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#about" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="#work" class="text-gray-400 hover:text-white">Our Work</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Blog</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">© 2025 Shil Consultancy Services. All rights reserved.</p>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/shilconsultancyukltd" class="w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-full flex items-center justify-center">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/shilconsultancy/" class="w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-full flex items-center justify-center">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://x.com/shilconsultancy" class="w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-full flex items-center justify-center">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/shilconsultancy/" class="w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-full flex items-center justify-center">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>


    <script>
        // --- SCRIPT FOR ORIGINAL SEO PAGE ---
        const navLinks = document.querySelectorAll('.nav-item');
        const sections = document.querySelectorAll('main section'); 

        function changeActiveLink() {
            let index = sections.length;
            while(--index && window.scrollY + 100 < sections[index].offsetTop) {}
            navLinks.forEach((link) => link.classList.remove('active'));
            if(navLinks[index]) {
               navLinks[index].classList.add('active');
            }
        }
        window.addEventListener('scroll', changeActiveLink);
        changeActiveLink();

        const searchInput = document.getElementById('searchInput');
        const keywords = [
            "best SEO agency in Chittagong",
            "best SEO agency in Bangladesh", 
            "best SEO agency near me",
            "top SEO services in Chittagong"
        ];
        let currentKeyword = 0;
        let charIndex = 0;
        let isDeleting = false;

        function type() {
            const fullKeyword = keywords[currentKeyword];
            
            if (isDeleting) {
                searchInput.placeholder = fullKeyword.substring(0, charIndex - 1);
                charIndex--;
            } else {
                searchInput.placeholder = fullKeyword.substring(0, charIndex + 1);
                charIndex++;
            }

            if (!isDeleting && charIndex === fullKeyword.length) {
                isDeleting = true;
                setTimeout(type, 2000);
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                currentKeyword = (currentKeyword + 1) % keywords.length;
                setTimeout(type, 500);
            } else {
                const typingSpeed = isDeleting ? 100 : 150;
                setTimeout(type, typingSpeed);
            }
        }
        setTimeout(type, 1000);

        // --- SCRIPT FOR NEWLY ADDED HEADER ---
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
</body>
</html>