@extends('layouts.app')

@section('title', 'Internationalization & Global Engagement — Manuel S. Enverga University Foundation')

@section('content')

<!-- Hero Header -->
<div class="relative bg-black overflow-hidden border-b-4 border-mseuf-buttonGold">
    <div class="relative h-[360px] sm:h-[400px]">
        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1600&q=80" alt="Global Students" class="w-full h-full object-cover opacity-35">
        <div class="absolute inset-0 bg-gradient-to-r from-[#4A0000] via-[#4A0000]/80 to-transparent"></div>
        <div class="w-full px-6 sm:px-12 h-full flex items-center relative z-10 text-white">
            <div class="max-w-3xl space-y-3">
                <span class="inline-block px-3.5 py-1 bg-white/10 text-amber-300 font-heading font-bold text-xs uppercase tracking-widest rounded border border-white/20">
                    Global Engagement Office &bull; CHED Calabarzon Awardee
                </span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight leading-tight">
                    Internationalization &amp; Global Linkages
                </h1>
                <p class="text-sm sm:text-base text-gray-200 font-normal leading-relaxed max-w-2xl">
                    Connecting MSEUF students and faculty to cross-border academic programs, international research collaborations, and overseas industry immersion across Asia, North America, and Europe.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Main Body -->
<div class="max-w-6xl mx-auto px-6 py-16 space-y-16">

    <!-- Accreditations & Recognitions Highlights -->
    <div class="border-b border-gray-200 pb-10">
        <span class="text-xs font-heading font-bold text-mseuf-crimson uppercase tracking-wider block mb-1">Worldwide Recognition</span>
        <h2 class="font-heading font-black text-2xl sm:text-3xl text-mseuf-darkText uppercase mb-6">
            Global Accreditations &amp; Institutional Rankings
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl text-center">
                <div class="text-2xl font-heading font-black text-mseuf-crimson mb-1">QS Stars</div>
                <div class="text-xs font-bold uppercase text-gray-700">International Rating</div>
                <p class="text-[11px] text-gray-500 mt-2">Recognized for teaching quality, employability, and social responsibility.</p>
            </div>

            <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl text-center">
                <div class="text-2xl font-heading font-black text-mseuf-crimson mb-1">WURI 2024</div>
                <div class="text-xs font-bold uppercase text-gray-700">Ranked Global University</div>
                <p class="text-[11px] text-gray-500 mt-2">World University Rankings for Innovation in student mobility and crisis management.</p>
            </div>

            <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl text-center">
                <div class="text-2xl font-heading font-black text-mseuf-crimson mb-1">CHED</div>
                <div class="text-xs font-bold uppercase text-gray-700">Autonomous Status</div>
                <p class="text-[11px] text-gray-500 mt-2">Highest level of regulatory autonomy granted by the Commission on Higher Education.</p>
            </div>

            <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl text-center">
                <div class="text-2xl font-heading font-black text-mseuf-crimson mb-1">ISO 9001:2015</div>
                <div class="text-xs font-bold uppercase text-gray-700">Certified Management</div>
                <p class="text-[11px] text-gray-500 mt-2">Global standard compliance across institutional academic &amp; administrative processes.</p>
            </div>
        </div>
    </div>

    <!-- Core International Programs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-heading font-bold text-mseuf-crimson uppercase tracking-widest block mb-2">Program Track 01</span>
                <h3 class="font-heading font-black text-lg text-mseuf-darkText mb-3 uppercase">Student Exchange &amp; Cross-Enrollment</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Semester-abroad and summer exchange partnerships with institutions in Japan, South Korea, Taiwan, Malaysia, and the United States, transferring academic credits seamlessly.
                </p>
            </div>
            <div class="pt-6 border-t border-gray-100 mt-6 text-xs text-gray-500 font-medium">
                Managed by: <strong>Global Engagement Office (GEO)</strong>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-heading font-bold text-mseuf-crimson uppercase tracking-widest block mb-2">Program Track 02</span>
                <h3 class="font-heading font-black text-lg text-mseuf-darkText mb-3 uppercase">International Student Hub</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Dedicated support services, student visa coordination, cultural integration workshops, and housing assistance for foreign scholars enrolled in Lucena City.
                </p>
            </div>
            <div class="pt-6 border-t border-gray-100 mt-6 text-xs text-gray-500 font-medium">
                Campus: <strong>AEC Building, Lucena Main Campus</strong>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-heading font-bold text-mseuf-crimson uppercase tracking-widest block mb-2">Program Track 03</span>
                <h3 class="font-heading font-black text-lg text-mseuf-darkText mb-3 uppercase">Faculty Exchange &amp; Research</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Visiting professor exchanges, co-authored cross-border publications, and international conference keynotes organized by academic departments.
                </p>
            </div>
            <div class="pt-6 border-t border-gray-100 mt-6 text-xs text-gray-500 font-medium">
                Affiliation: <strong>DCAV Research Institute</strong>
            </div>
        </div>

    </div>

    <!-- Call to action -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8 sm:p-10 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div>
            <h3 class="font-heading font-black text-xl text-mseuf-darkText uppercase">Participate in University Events</h3>
            <p class="text-xs text-gray-600 mt-1 max-w-xl">
                International symposiums, cultural nights, and tech summits are managed directly through Enverga Pass with instant digital QR verification.
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('events.index') }}" class="mseuf-apply-btn font-heading font-bold text-xs px-6 py-3 rounded-full uppercase tracking-wider shadow">
                View All Events
            </a>
            <a href="{{ route('clearance.index') }}" class="mseuf-outline-btn font-heading font-bold text-xs px-6 py-3 rounded-full uppercase tracking-wider">
                Check Clearance
            </a>
        </div>
    </div>

</div>

@endsection
