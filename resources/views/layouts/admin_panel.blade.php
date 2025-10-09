<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Shil Consultancy Services</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="icon" type="image/png" href="/Media/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/Media/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/Media/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/Media/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/Media/favicon/site.webmanifest" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #6e45e2;
            --secondary: #88d3ce;
            --accent: #ff7e5f;
            --dark: #0f0e17;
            --light: #fffffe;
            --dark-2: #1a1a2e;
            --dark-3: #24243e;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark);
            color: var(--light);
        }

        h1,
        h2,
        h3,
        h4,
        .orbitron {
            font-family: 'Orbitron', sans-serif;
        }

        .gradient-text {
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradient 8s ease infinite;
            background-size: 400% 400%;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .card-bg {
            background: var(--dark-2);
            border: 1px solid var(--dark-3);
        }

        .sidebar-link {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: var(--dark-3);
            color: var(--light);
            border-left-color: var(--primary);
        }

        .table-custom th {
            background-color: var(--dark-3);
        }

        .table-custom tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-2);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--dark-3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
    </style>
</head>

<body class="text-gray-300">

    <div class="flex h-screen bg-dark">
        <aside class="w-64 flex-shrink-0 hidden md:block bg-dark-2 border-r border-dark-3">
            <div class="flex flex-col h-full">
                <div class="h-20 flex items-center justify-center border-b border-dark-3">
                    <h1 class="text-2xl font-bold gradient-text">SCS ADMIN</h1>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt w-6 text-center mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    {{-- pages section --}}
                    <div class="relative">
                        <button onclick="togglePagesDropdown()"
                            class="sidebar-link flex items-center justify-between w-full px-4 py-3 rounded-lg {{ request()->routeIs('analytics.*') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt w-6 text-center mr-3"></i>
                                <span>Pages</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                id="pages-chevron"></i>
                        </button>

                        <div id="pages-dropdown" class="ml-6 mt-1 space-y-1 hidden">
                            <a href="{{ route('analytics.popular') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('analytics.popular') ? 'active' : '' }}">
                                <i class="fas fa-chart-line w-4 text-center mr-3"></i>
                                <span>Popular Pages</span>
                            </a>

                            <a href="{{ route('analytics.live-stats') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm">
                                <i class="fas fa-user-clock w-4 text-center mr-3"></i>
                                <span>Live Stats</span>
                            </a>

                            <a href="{{ route('analytics.top-referrals') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm">
                                <i class="fas fa-link w-4 text-center mr-3"></i>
                                <span>Top Referrals</span>
                            </a>
                        </div>
                    </div>


                    {{-- blog section - UPDATED WITH DROPDOWN --}}
                    <div class="relative">
                        <button onclick="toggleBlogsDropdown()"
                            class="sidebar-link flex items-center justify-between w-full px-4 py-3 rounded-lg 
                                {{ request()->routeIs('dashboard.blogs.*') || request()->routeIs('dashboard.comments.*') || request()->routeIs('dashboard.categories.*') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <i class="fas fa-pen-nib w-6 text-center mr-3"></i>
                                <span>Blogs</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                id="blogs-chevron"></i>
                        </button>

                        <div id="blogs-dropdown" class="ml-6 mt-1 space-y-1 hidden">
                            <a href="{{ route('dashboard.blogs.create') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.blogs.create') ? 'active' : '' }}">
                                <i class="fas fa-plus w-4 text-center mr-3"></i>
                                <span>Add Blogs</span>
                            </a>
                            <a href="{{ route('dashboard.blogs.index') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.blogs.index') && !request()->routeIs('dashboard.blogs.create') ? 'active' : '' }}">
                                <i class="fas fa-list-alt w-4 text-center mr-3"></i>
                                <span>Existing Blogs</span>
                            </a>
                            <a href="{{ route('dashboard.comments.index') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.comments.*') ? 'active' : '' }}">
                                <i class="fas fa-comment-dots w-4 text-center mr-3"></i>
                                <span>View Comments</span>
                            </a>
                            <a href="{{ route('dashboard.categories.index') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.categories.*') ? 'active' : '' }}">
                                <i class="fas fa-tags w-4 text-center mr-3"></i>
                                <span>Add Categories</span>
                            </a>
                        </div>
                    </div>

                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('access_control') }}"
                                class="sidebar-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('access_control') ? 'active' : '' }}">
                                <i class="fas fa-users-cog w-6 text-center mr-3"></i>
                                <span>Access Control</span>
                            </a>
                        @else
                            <a href="{{ route('unauthorized.access') }}"
                                class="sidebar-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('unauthorized.access') ? 'active' : '' }}">
                                <i class="fas fa-users-cog w-6 text-center mr-3"></i>
                                <span>Access Control</span>
                            </a>
                        @endif
                    @endauth
                    
                    <div class="relative">
                        <button onclick="toggleJobsDropdown()"
                            class="sidebar-link flex items-center justify-between w-full px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.jobs.*') || request()->routeIs('dashboard.applicants.*') ? 'active' : '' }}">
                            <div class="flex items-center gap-{-20px}">
                                <i class="fas fa-briefcase w-6 text-center mr-3"></i>
                                <span>Jobs</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                id="jobs-chevron"></i>
                        </button>

                        <div id="jobs-dropdown" class="ml-6 mt-1 space-y-1 hidden">
                            <a href="{{ route('dashboard.jobs.index') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.jobs.*') ? 'active' : '' }}">
                                <i class="fas fa-list-alt w-4 text-center mr-3"></i>
                                <span>Job Circular</span>
                            </a>
                            <a href="{{ route('dashboard.applicants') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.applicants') ? 'active' : '' }}">
                                <i class="fas fa-users w-4 text-center mr-3"></i>
                                <span>Job Applicants</span>
                            </a>
                        </div>
                    </div>

                    {{-- SEO section --}}
                    <div class="relative">
                        <button onclick="toggleSeoDropdown()"
                            class="sidebar-link flex items-center justify-between w-full px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.seo.*') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <i class="fas fa-chart-line w-6 text-center mr-3"></i>
                                <span>SEO</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                id="seo-chevron"></i>
                        </button>

                        <div id="seo-dropdown" class="ml-6 mt-1 space-y-1 hidden">
                            <a href="{{ route('dashboard.seo.meta-tags') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.seo.meta-tags') ? 'active' : '' }}">
                                <i class="fas fa-tags w-4 text-center mr-3"></i>
                                <span>Meta Tags</span>
                            </a>
                            <a href="{{ route('dashboard.seo.blog-meta-tags') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.seo.meta-tags') ? 'active' : '' }}">
                                <i class="fas fa-tags w-4 text-center mr-3"></i>
                                <span>Blog Meta Tags</span>
                            </a>
                            <a href="{{ route('dashboard.seo.blog-keywords') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.seo.meta-tags') ? 'active' : '' }}">
                                <i class="fas fa-tags w-4 text-center mr-3"></i>
                                <span>Blog Keywords</span>
                            </a>
                            <a href="{{ route('dashboard.seo.analytics') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.seo.analytics') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar w-4 text-center mr-3"></i>
                                <span>Analytics</span>
                            </a>
                            <a href="{{ route('dashboard.seo.keywords') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.seo.keywords') ? 'active' : '' }}">
                                <i class="fas fa-key w-4 text-center mr-3"></i>
                                <span>Keywords</span>
                            </a>
                            <a href="{{ route('dashboard.seo.sitemap') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.seo.sitemap') ? 'active' : '' }}">
                                <i class="fas fa-sitemap w-4 text-center mr-3"></i>
                                <span>Sitemap</span>
                            </a>
                            <a href="{{ route('dashboard.seo.robots') }}"
                                class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard.seo.robots') ? 'active' : '' }}">
                                <i class="fas fa-robot w-4 text-center mr-3"></i>
                                <span>Robots.txt</span>
                            </a>
                        </div>
                    </div>
                    
                    <a href="#"
                        class="sidebar-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cogs w-6 text-center mr-3"></i>
                        <span>Global Settings</span>
                    </a>
                </nav>
                <div class="px-4 py-6 border-t border-dark-3">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="sidebar-link flex items-center px-4 py-3 rounded-lg text-red-400 hover:bg-red-500/10 hover:border-red-500">
                        <i class="fas fa-sign-out-alt w-6 text-center mr-3"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-20 flex items-center justify-between px-6 bg-dark-2 border-b border-dark-3">
                <div class="flex items-center">
                    <button class="md:hidden mr-4 text-gray-400">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="w-full bg-dark-3 border border-gray-700 rounded-lg px-4 py-2 pl-10 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <button class="text-gray-400 hover:text-white relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span
                            class="absolute -top-1 -right-1 w-3 h-3 bg-accent rounded-full border-2 border-dark-2"></span>
                    </button>
                    <div class="relative flex items-center space-x-2">
                        {{-- User Avatar --}}
                        @if (Auth::user()->image)
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}"
                                class="w-10 h-10 rounded-full object-cover border border-gray-300">
                        @else
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold border border-gray-300">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif

                        {{-- User Name & Role --}}
                        <div class="flex flex-col">
                            <span class="font-medium gradient-text">{{ Auth::user()->name }}</span>
                            <span class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>

                        {{-- Optional dropdown icon --}}
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-dark p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        // Dropdown toggle functions
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }

        function toggleJobsDropdown() {
            const dropdown = document.getElementById('jobs-dropdown');
            const chevron = document.getElementById('jobs-chevron');
            dropdown.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }

        function togglePagesDropdown() {
            const dropdown = document.getElementById("pages-dropdown");
            const chevron = document.getElementById("pages-chevron");
            dropdown.classList.toggle("hidden");
            chevron.classList.toggle("rotate-180");
        }

        function toggleBlogsDropdown() {
            const dropdown = document.getElementById("blogs-dropdown");
            const chevron = document.getElementById("blogs-chevron");
            dropdown.classList.toggle("hidden");
            chevron.classList.toggle("rotate-180");
        }

        // SEO Dropdown Function
        function toggleSeoDropdown() {
            const dropdown = document.getElementById("seo-dropdown");
            const chevron = document.getElementById("seo-chevron");
            dropdown.classList.toggle("hidden");
            chevron.classList.toggle("rotate-180");
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            // Jobs Dropdown
            const jobsDropdown = document.getElementById('jobs-dropdown');
            const jobsButton = document.querySelector('[onclick="toggleJobsDropdown()"]');
            if (jobsButton && jobsDropdown && !jobsButton.contains(event.target) && !jobsDropdown.contains(event.target)) {
                jobsDropdown.classList.add('hidden');
                document.getElementById('jobs-chevron').classList.remove('rotate-180');
            }

            // Pages Dropdown
            const pagesDropdown = document.getElementById('pages-dropdown');
            const pagesButton = document.querySelector('[onclick="togglePagesDropdown()"]');
            if (pagesButton && pagesDropdown && !pagesButton.contains(event.target) && !pagesDropdown.contains(event.target)) {
                pagesDropdown.classList.add('hidden');
                document.getElementById('pages-chevron').classList.remove('rotate-180');
            }

            // Blogs Dropdown
            const blogsDropdown = document.getElementById('blogs-dropdown');
            const blogsButton = document.querySelector('[onclick="toggleBlogsDropdown()"]');
            if (blogsButton && blogsDropdown && !blogsButton.contains(event.target) && !blogsDropdown.contains(event.target)) {
                blogsDropdown.classList.add('hidden');
                document.getElementById('blogs-chevron').classList.remove('rotate-180');
            }

            // SEO Dropdown
            const seoDropdown = document.getElementById('seo-dropdown');
            const seoButton = document.querySelector('[onclick="toggleSeoDropdown()"]');
            if (seoButton && seoDropdown && !seoButton.contains(event.target) && !seoDropdown.contains(event.target)) {
                seoDropdown.classList.add('hidden');
                document.getElementById('seo-chevron').classList.remove('rotate-180');
            }
        });

        // SEO Specific JavaScript Functions
        function updateCharacterCounts() {
            // Meta title counter
            const metaTitle = document.getElementById('meta_title');
            const titleCount = document.getElementById('titleCount');
            if (metaTitle && titleCount) {
                titleCount.textContent = metaTitle.value.length;
                if (metaTitle.value.length > 60) {
                    titleCount.classList.add('text-red-400');
                } else {
                    titleCount.classList.remove('text-red-400');
                }
            }

            // Meta description counter
            const metaDescription = document.getElementById('meta_description');
            const descCount = document.getElementById('descCount');
            if (metaDescription && descCount) {
                descCount.textContent = metaDescription.value.length;
                if (metaDescription.value.length > 160) {
                    descCount.classList.add('text-red-400');
                } else {
                    descCount.classList.remove('text-red-400');
                }
            }
        }

        // Keyword suggestion function
        function suggestKeywords() {
            const primaryInput = document.getElementById('primary_keywords');
            const secondaryInput = document.getElementById('secondary_keywords');
            
            if (primaryInput) {
                const consultancyKeywords = [
                    'business consulting', 'management consultancy', 'corporate strategy',
                    'process improvement', 'digital transformation', 'business optimization',
                    'operational efficiency', 'strategic planning', 'business development',
                    'performance management', 'organizational development', 'change management'
                ];
                
                primaryInput.placeholder = `e.g., ${consultancyKeywords.slice(0, 3).join(', ')}...`;
            }
            
            if (secondaryInput) {
                const locationKeywords = [
                    'consultancy services in [city]', 'business consultants near me',
                    'management consulting firms', 'corporate advisory services',
                    'business process optimization', 'strategic business consulting'
                ];
                
                secondaryInput.placeholder = `e.g., ${locationKeywords.slice(0, 2).join(', ')}...`;
            }
        }

        // Sitemap generation status
        function checkSitemapStatus() {
            const generateBtn = document.getElementById('generateSitemapBtn');
            const statusElement = document.getElementById('sitemapStatus');
            
            if (generateBtn) {
                generateBtn.addEventListener('click', function() {
                    const originalText = generateBtn.innerHTML;
                    generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generating...';
                    generateBtn.disabled = true;
                    
                    // Simulate processing
                    setTimeout(() => {
                        generateBtn.innerHTML = originalText;
                        generateBtn.disabled = false;
                        if (statusElement) {
                            statusElement.innerHTML = '<span class="text-green-400">Sitemap generated successfully!</span>';
                        }
                    }, 2000);
                });
            }
        }

        // Robots.txt validation
        function validateRobotsContent() {
            const robotsTextarea = document.getElementById('robots_content');
            const submitBtn = document.querySelector('button[type="submit"]');
            
            if (robotsTextarea && submitBtn) {
                robotsTextarea.addEventListener('input', function() {
                    const content = this.value;
                    const hasUserAgent = content.includes('User-agent:');
                    const hasDisallow = content.includes('Disallow:');
                    const hasAllow = content.includes('Allow:');
                    
                    if (!hasUserAgent) {
                        this.classList.add('border-yellow-400');
                    } else {
                        this.classList.remove('border-yellow-400');
                    }
                });
            }
        }

        // Analytics code validation
        function validateAnalyticsCode() {
            const analyticsTextarea = document.getElementById('analytics_code');
            
            if (analyticsTextarea) {
                analyticsTextarea.addEventListener('input', function() {
                    const code = this.value;
                    const hasGtag = code.includes('gtag(') || code.includes('ga(');
                    const hasGoogleAnalytics = code.includes('google-analytics');
                    const hasScriptTag = code.includes('<script>');
                    
                    if ((hasGtag || hasGoogleAnalytics) && hasScriptTag) {
                        this.classList.remove('border-red-400');
                        this.classList.add('border-green-400');
                    } else {
                        this.classList.remove('border-green-400');
                        this.classList.add('border-red-400');
                    }
                });
            }
        }

        // Initialize SEO functions when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            updateCharacterCounts();
            suggestKeywords();
            checkSitemapStatus();
            validateRobotsContent();
            validateAnalyticsCode();
            
            // Add event listeners for character counts
            const metaTitle = document.getElementById('meta_title');
            const metaDescription = document.getElementById('meta_description');
            
            if (metaTitle) {
                metaTitle.addEventListener('input', updateCharacterCounts);
            }
            if (metaDescription) {
                metaDescription.addEventListener('input', updateCharacterCounts);
            }
            
            // Auto-save functionality for SEO settings
            const seoForms = document.querySelectorAll('form');
            seoForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
                        submitBtn.disabled = true;
                    }
                });
            });
            
            // Preview functionality for meta tags
            const previewBtn = document.getElementById('previewMeta');
            if (previewBtn) {
                previewBtn.addEventListener('click', function() {
                    const title = document.getElementById('meta_title')?.value || 'No title';
                    const description = document.getElementById('meta_description')?.value || 'No description';
                    
                    // Show preview in alert (you can enhance this with a modal)
                    alert(`Search Result Preview:\n\nTitle: ${title}\nDescription: ${description.substring(0, 100)}...`);
                });
            }
        });

        // Mobile menu toggle (if needed)
        function toggleMobileMenu() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('md:block');
        }

        // Search functionality
        function handleSearch() {
            const searchInput = document.querySelector('input[type="text"][placeholder="Search..."]');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const searchTerm = this.value.trim();
                        if (searchTerm) {
                            // Implement search functionality here
                            console.log('Searching for:', searchTerm);
                            alert(`Search functionality would look for: ${searchTerm}`);
                        }
                    }
                });
            }
        }

        // Initialize search on load
        document.addEventListener('DOMContentLoaded', handleSearch);
    </script>
    
    <style>
        .sidebar-link {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: var(--dark-3);
            color: var(--light);
            border-left-color: var(--primary);
        }

        /* Smooth rotation for chevron */
        .fa-chevron-down {
            transition: transform 0.3s ease;
        }
        
        /* SEO specific styles */
        .character-count {
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .seo-preview {
            background: var(--dark-3);
            border: 1px solid var(--dark-2);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .validation-success {
            border-color: #10B981 !important;
        }
        
        .validation-warning {
            border-color: #F59E0B !important;
        }
        
        .validation-error {
            border-color: #EF4444 !important;
        }
    </style>
</body>

</html>