<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manuel S. Enverga University Foundation — Event Pass')</title>

    <!-- Browser Tab Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/eu-logo.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/eu-logo.svg') }}">
    
    <!-- Google Fonts: Inter & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Swiper CSS & JS via CDN for Hero Slider Carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        mseuf: {
                            crimson: '#960000',
                            darkred: '#730000',
                            gold: '#D4AF37',
                            buttonGold: '#D49E00',
                            topBarRed: '#8B0000',
                            bodyBg: '#FFFFFF',
                            cardBg: '#FFFFFF',
                            darkText: '#1C1C1C',
                            mutedText: '#555555'
                        }
                    },
                    fontFamily: {
                        sans: ['"Inter"', 'sans-serif'],
                        heading: ['"Montserrat"', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        .mseuf-top-utility-bar { background-color: #8B0000; }
        .mseuf-apply-btn { background-color: #D49E00; color: #ffffff; }
        .mseuf-apply-btn:hover { background-color: #b88a00; }
        .mseuf-outline-btn { border: 2px solid #960000; color: #960000; }
        .mseuf-outline-btn:hover { background-color: #960000; color: #ffffff; }
        .enverga-brand-text {
            font-family: 'Montserrat', 'Arial Black', sans-serif;
            font-weight: 900;
            color: #960000;
            line-height: 0.82;
            letter-spacing: -0.04em;
        }
        @keyframes toastPopIn {
            0% { transform: translateY(-30px) scale(0.95); opacity: 0; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }
        .toast-animate {
            animation: toastPopIn 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
    </style>
</head>
<body class="bg-white text-mseuf-darkText font-sans antialiased min-h-screen flex flex-col justify-between relative overflow-x-hidden">

    <!-- Official MSEUF Crimson & Gold Floating Toast Notifications Container -->
    <div class="fixed top-24 right-8 z-[99999] max-w-md w-full space-y-3 pointer-events-none">
        @if(session('success'))
            <div id="toast-success" class="pointer-events-auto bg-[#6C0000] text-white border-2 border-[#D4AF37] rounded-xl shadow-2xl p-4 text-sm font-medium flex items-start gap-3.5 toast-animate">
                <div class="w-8 h-8 rounded-full bg-[#D49E00] text-gray-900 flex items-center justify-center font-black text-sm flex-shrink-0 mt-0.5 shadow">
                    ✓
                </div>
                <div class="flex-grow">
                    <div class="font-heading font-black text-[#D4AF37] uppercase text-xs tracking-wider mb-0.5">
                        Tuition Clearance Verified
                    </div>
                    <div class="text-white font-semibold text-xs leading-snug">
                        {{ session('success') }}
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-gray-300 hover:text-white font-bold text-lg leading-none ml-2 p-1">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div id="toast-error" class="pointer-events-auto bg-[#4A0000] text-white border-2 border-rose-400 rounded-xl shadow-2xl p-4 text-sm font-medium flex items-start gap-3.5 toast-animate">
                <div class="w-8 h-8 rounded-full bg-rose-600 text-white flex items-center justify-center font-black text-sm flex-shrink-0 mt-0.5 shadow">
                    !
                </div>
                <div class="flex-grow">
                    <div class="font-heading font-black text-rose-300 uppercase text-xs tracking-wider mb-0.5">
                        Tuition Clearance Verification Failed
                    </div>
                    <div class="text-white font-semibold text-xs leading-relaxed">
                        {{ session('error') }}
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-300 hover:text-white font-bold text-lg leading-none ml-2 p-1">&times;</button>
            </div>
        @endif
    </div>

    <!-- Top Utility Ribbon Container -->
    <div class="w-full bg-white hidden md:block">
        <div class="w-full pr-0 pl-6 flex justify-end">
            <div class="mseuf-top-utility-bar text-white text-[11px] font-semibold py-1.5 px-6 rounded-bl-xl flex items-center gap-4 tracking-wider uppercase">
                <a href="{{ route('events.index') }}" class="hover:underline">Student Pass Portal</a>
                <span>|</span>
                <a href="{{ route('clearance.index') }}" class="hover:underline">Tuition Clearance</a>
                <span>|</span>
                <a href="https://mseuf.edu.ph" target="_blank" class="hover:underline">Faculty & Staff</a>
                <span>|</span>
                <a href="#" class="hover:underline">Downloads</a>
                <span>|</span>
                <a href="#" class="hover:underline">Careers</a>
                <span>|</span>
                <a href="#" class="hover:underline">Library</a>
                <span>|</span>
                <a href="#" class="hover:underline">Sites</a>
                <span>|</span>
                <svg class="w-3.5 h-3.5 text-white inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Main Header Navbar with User SVG Logo + Bold Red ENVERGA UNIVERSITY Typography -->
    <header class="bg-white sticky top-0 z-50 border-b border-gray-200/80 shadow-sm" id="mainHeader">
        <div class="w-full px-6 py-3.5 flex items-center justify-between">
            
            <!-- Logo Icon + Bold Red ENVERGA UNIVERSITY Text -->
            <a href="{{ route('events.index') }}" class="flex items-center gap-3.5 group">
                <img src="{{ asset('images/eu-logo.svg') }}" alt="MSEUF Official Logo" class="h-14 sm:h-16 w-auto object-contain flex-shrink-0">
                
                <div class="flex flex-col justify-center">
                    <span class="enverga-brand-text text-2xl sm:text-3xl uppercase">
                        ENVERGA
                    </span>
                    <span class="enverga-brand-text text-2xl sm:text-3xl uppercase">
                        UNIVERSITY
                    </span>
                </div>
            </a>

            <!-- Center: Official Navigation Items -->
            <nav class="hidden xl:flex items-center text-xs font-bold uppercase tracking-wider text-gray-800">
                <a href="{{ route('events.index') }}" class="px-3.5 py-2 hover:text-mseuf-crimson transition-colors border-b-2 {{ request()->routeIs('events.index') ? 'border-mseuf-crimson text-mseuf-crimson' : 'border-transparent' }}">
                    INSTRUCTION & EVENTS
                </a>
                <span class="text-gray-300 font-light">|</span>
                <a href="{{ route('clearance.index') }}" class="px-3.5 py-2 hover:text-mseuf-crimson transition-colors border-b-2 {{ request()->routeIs('clearance.index') ? 'border-mseuf-crimson text-mseuf-crimson' : 'border-transparent' }}">
                    TUITION CLEARANCE
                </a>
                <span class="text-gray-300 font-light">|</span>
                <a href="#" class="px-3.5 py-2 hover:text-mseuf-crimson transition-colors border-b-2 border-transparent">
                    SUSTAINABILITY
                </a>
                <span class="text-gray-300 font-light">|</span>
                <a href="#" class="px-3.5 py-2 hover:text-mseuf-crimson transition-colors border-b-2 border-transparent">
                    INTERNATIONALIZATION
                </a>
                <span class="text-gray-300 font-light">|</span>
                <a href="#" class="px-3.5 py-2 hover:text-mseuf-crimson transition-colors border-b-2 border-transparent">
                    ABOUT
                </a>
            </nav>

            <!-- Right: Exact MSEUF Action Pill Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('clearance.index') }}" class="mseuf-apply-btn font-heading font-bold text-xs px-6 py-2.5 rounded-full uppercase tracking-wider shadow-sm transition transform hover:scale-105">
                    CHECK BALANCE
                </a>
                <a href="{{ route('events.index') }}" class="mseuf-outline-btn font-heading font-bold text-xs px-5 py-2.5 rounded-full uppercase tracking-wider transition transform hover:scale-105">
                    GET PASS
                </a>
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-mseuf-darkred text-white pt-14 pb-8 mt-20 border-t-4 border-mseuf-buttonGold">
        <div class="w-full px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-10 border-b border-white/20 text-xs">
                
                <div class="md:col-span-5 space-y-3">
                    <div class="flex items-center gap-3.5 mb-2">
                        <img src="{{ asset('images/eu-logo.svg') }}" alt="MSEUF Official Logo" class="h-12 w-auto filter brightness-0 invert object-contain">
                        <div class="flex flex-col justify-center text-white">
                            <span class="font-heading font-black text-xl leading-none uppercase">ENVERGA</span>
                            <span class="font-heading font-black text-xl leading-none uppercase">UNIVERSITY</span>
                        </div>
                    </div>
                    <p class="text-gray-200 text-xs leading-relaxed max-w-md font-normal">
                        Autonomous Status granted by CHED. ISO 9001:2015 Certified. Lucena City, Quezon, Philippines.
                    </p>
                    <div class="text-gray-300 text-[11px] pt-2">
                        Official Event Ticketing & Automated Tuition Clearance System
                    </div>
                </div>

                <div class="md:col-span-3 space-y-2">
                    <div class="font-heading font-bold text-mseuf-buttonGold uppercase tracking-wider text-xs">Navigation</div>
                    <ul class="space-y-2 text-gray-200">
                        <li><a href="{{ route('events.index') }}" class="hover:underline">Events Calendar & Passes</a></li>
                        <li><a href="{{ route('clearance.index') }}" class="hover:underline">Tuition Clearance Verification</a></li>
                        <li><a href="https://mseuf.edu.ph" target="_blank" class="hover:underline">MSEUF Official Portal</a></li>
                    </ul>
                </div>

                <div class="md:col-span-4 space-y-2">
                    <div class="font-heading font-bold text-mseuf-buttonGold uppercase tracking-wider text-xs">Campus Information</div>
                    <div class="bg-white/10 p-4 rounded text-gray-100 text-xs leading-relaxed border border-white/20">
                        University Site, Brgy. Ibabang Dupay, Lucena City, Quezon 4301<br>
                        Tel. No. (042) 710-2541 | Email: info@mseuf.edu.ph
                    </div>
                </div>

            </div>

            <div class="pt-6 flex flex-col md:flex-row items-center justify-between text-[11px] text-gray-300 font-medium">
                <div>
                    Copyright &copy; {{ date('Y') }} Manuel S. Enverga University Foundation. All Rights Reserved.
                </div>
                <div class="mt-2 md:mt-0 font-mono text-gray-200">
                    EnvergaPass Engine
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Auto Dismiss Script -->
    <script>
        setTimeout(() => {
            const successToast = document.getElementById('toast-success');
            const errorToast = document.getElementById('toast-error');
            if (successToast) successToast.style.opacity = '0';
            if (errorToast) errorToast.style.opacity = '0';
        }, 7000);
    </script>

</body>
</html>
