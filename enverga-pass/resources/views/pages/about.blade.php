@extends('layouts.app')

@section('title', 'About Manuel S. Enverga University Foundation — Lucena City')

@section('content')

<!-- Hero Header -->
<div class="relative bg-black overflow-hidden border-b-4 border-mseuf-buttonGold">
    <div class="relative h-[360px] sm:h-[400px]">
        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1600&q=80" alt="MSEUF Campus" class="w-full h-full object-cover opacity-35">
        <div class="absolute inset-0 bg-gradient-to-r from-[#4A0000] via-[#4A0000]/80 to-transparent"></div>
        <div class="w-full px-6 sm:px-12 h-full flex items-center relative z-10 text-white">
            <div class="max-w-3xl space-y-3">
                <span class="inline-block px-3.5 py-1 bg-white/10 text-amber-300 font-heading font-bold text-xs uppercase tracking-widest rounded border border-white/20">
                    Autonomous Status &bull; CHED Recognized &bull; ISO 9001:2015
                </span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight leading-tight">
                    About Manuel S. Enverga University Foundation
                </h1>
                <p class="text-sm sm:text-base text-gray-200 font-normal leading-relaxed max-w-2xl">
                    Founded in 1947 by Dr. Manuel S. Enverga, MSEUF is the premier university in Region IV-A (CALABARZON), committed to building a community of scholars, professionals, and nation-builders.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Main Body -->
<div class="max-w-6xl mx-auto px-6 py-16 space-y-16">

    <!-- Trifocal Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm hover:border-mseuf-crimson transition">
            <div class="w-12 h-12 rounded-lg bg-red-100 text-mseuf-crimson flex items-center justify-center font-heading font-black text-sm mb-4">
                01
            </div>
            <h3 class="font-heading font-black text-lg text-mseuf-darkText mb-2 uppercase">Instruction</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Producing globally competitive graduates through accredited undergraduate, graduate, and basic education programs guided by distinguished faculty and industry partnerships.
            </p>
        </div>

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm hover:border-mseuf-crimson transition">
            <div class="w-12 h-12 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center font-heading font-black text-sm mb-4">
                02
            </div>
            <h3 class="font-heading font-black text-lg text-mseuf-darkText mb-2 uppercase">Research</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Fostering an active research culture led by the DCAV Research &amp; Knowledge Management Institute, driving publications, patents, and community-centered innovations.
            </p>
        </div>

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm hover:border-mseuf-crimson transition">
            <div class="w-12 h-12 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center font-heading font-black text-sm mb-4">
                03
            </div>
            <h3 class="font-heading font-black text-lg text-mseuf-darkText mb-2 uppercase">Community Extension</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Empowering partner communities in Quezon Province and across Southern Tagalog through sustainable social enterprise, literacy, and environmental stewardship.
            </p>
        </div>
    </div>

    <!-- Vision, Mission, Goal & Core Values -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <div class="bg-[#fafafa] border border-gray-200 p-8 rounded-2xl space-y-6">
            <div>
                <span class="text-xs font-heading font-bold text-mseuf-crimson uppercase tracking-wider block mb-1">Our North Star</span>
                <h2 class="font-heading font-black text-2xl text-mseuf-darkText uppercase">Vision</h2>
                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed mt-2">
                    In 2030, Manuel S. Enverga University Foundation is a globally competitive university characterized by academic excellence, innovative research, and responsive community extension services.
                </p>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <span class="text-xs font-heading font-bold text-mseuf-crimson uppercase tracking-wider block mb-1">Our Purpose</span>
                <h2 class="font-heading font-black text-2xl text-mseuf-darkText uppercase">Mission</h2>
                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed mt-2">
                    Manuel S. Enverga University Foundation is a non-stock, non-profit educational foundation committed to produce holistic graduates who are globally competent, research-oriented, and socially responsible.
                </p>
            </div>
        </div>

        <div class="bg-white border-2 border-mseuf-crimson p-8 rounded-2xl flex flex-col justify-between">
            <div>
                <span class="text-xs font-heading font-bold text-mseuf-crimson uppercase tracking-wider block mb-1">Foundational Pillars</span>
                <h2 class="font-heading font-black text-2xl text-mseuf-darkText uppercase mb-4">Core Values</h2>
                
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <h4 class="font-heading font-bold text-sm text-mseuf-crimson uppercase">Excellence</h4>
                        <p class="text-xs text-gray-600 mt-1">Pursuing the highest standards in academics, governance, and professional practice.</p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <h4 class="font-heading font-bold text-mseuf-crimson uppercase text-sm">Resilience</h4>
                        <p class="text-xs text-gray-600 mt-1">Adapting with strength and agility to educational disruption and technological evolution.</p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <h4 class="font-heading font-bold text-mseuf-crimson uppercase text-sm">Service</h4>
                        <p class="text-xs text-gray-600 mt-1">Dedication to the welfare of the student body, the local community, and the nation.</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-200 mt-6 text-xs text-gray-500">
                <strong>Campus:</strong> University Site, Brgy. Ibabang Dupay, Lucena City, Quezon 4301 &bull; Tel: (042) 710-2541
            </div>
        </div>

    </div>

    <!-- Founder Recognition -->
    <div class="bg-mseuf-darkred text-white p-8 sm:p-12 rounded-2xl flex flex-col md:flex-row items-center gap-8 shadow-lg">
        <div class="flex-1 space-y-3">
            <span class="text-amber-300 font-heading font-bold text-xs uppercase tracking-widest">Historical Milestone &bull; 1947</span>
            <h3 class="font-heading font-black text-2xl sm:text-3xl">Dr. Manuel Sarmiento Enverga (1909–1981)</h3>
            <p class="text-xs sm:text-sm text-gray-200 leading-relaxed font-normal">
                Statesman, educator, and Congressman from Quezon Province who envisioned quality higher education accessible to youth in Southern Luzon. Today, Enverga Pass digital platform carries that legacy into modern digital student services.
            </p>
        </div>
        <div>
            <a href="{{ route('events.index') }}" class="inline-block bg-mseuf-buttonGold text-gray-900 font-heading font-black text-xs uppercase tracking-wider px-8 py-3.5 rounded-full hover:bg-amber-300 transition shadow">
                Explore Event Passes
            </a>
        </div>
    </div>

</div>

@endsection
