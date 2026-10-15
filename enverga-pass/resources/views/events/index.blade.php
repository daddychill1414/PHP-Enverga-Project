@extends('layouts.app')

@section('title', 'Events — Manuel S. Enverga University Foundation')

@section('content')

<!-- Official MSEUF Animated Slider Carousel (Full Screen Width) -->
<div class="relative bg-black overflow-hidden border-b border-mseuf-crimson w-full">
    <div class="swiper heroSwiper h-[480px] sm:h-[540px]">
        <div class="swiper-wrapper">
            @forelse($featuredEvents->count() > 0 ? $featuredEvents : $events as $slideEvent)
                <div class="swiper-slide relative bg-mseuf-darkred overflow-hidden">
                    <img src="{{ $slideEvent->banner_image ?: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1600&q=80' }}" alt="{{ $slideEvent->title }}" class="w-full h-full object-cover opacity-40 transform scale-105 transition duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#4A0000] via-[#4A0000]/80 to-transparent"></div>
                    
                    <div class="w-full px-6 sm:px-12 h-full flex items-center relative z-10 text-white">
                        <div class="max-w-3xl space-y-3.5">
                            <span class="inline-block px-3.5 py-1 bg-white/10 text-amber-300 font-heading font-bold text-[11px] uppercase tracking-widest rounded border border-white/20">
                                {{ $slideEvent->category }} • {{ $slideEvent->event_date->format('M d, Y') }}
                            </span>
                            <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight leading-tight">
                                {{ $slideEvent->title }}
                            </h1>
                            <p class="text-sm sm:text-base text-gray-100 font-normal leading-relaxed line-clamp-2 max-w-2xl">
                                {{ $slideEvent->description }}
                            </p>
                            <div class="pt-3 flex flex-wrap gap-3">
                                <a href="{{ route('events.show', $slideEvent->slug) }}" class="inline-block px-7 py-3 rounded-full bg-mseuf-buttonGold text-white font-heading font-bold text-xs uppercase tracking-widest hover:bg-amber-600 transition shadow-lg transform hover:-translate-y-0.5">
                                    GET PASS • {{ $slideEvent->ticketTypes->min('price') == 0 ? 'FREE' : 'PHP ' . number_format($slideEvent->ticketTypes->min('price'), 2) }}
                                </a>
                                <a href="#events-catalog" class="inline-block px-6 py-3 rounded-full border-2 border-white/80 text-white font-heading font-bold text-xs uppercase tracking-widest hover:bg-white hover:text-mseuf-crimson transition shadow-lg">
                                    VIEW ALL EVENTS
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide relative bg-mseuf-darkred overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1600&q=80" alt="MSEUF Campus" class="w-full h-full object-cover opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-r from-mseuf-darkred via-mseuf-darkred/80 to-transparent"></div>
                    <div class="w-full px-8 h-full flex items-center relative z-10 text-white">
                        <div class="max-w-2xl space-y-4">
                            <span class="inline-block px-3.5 py-1 bg-white/10 text-amber-300 font-heading font-bold text-xs uppercase tracking-widest rounded border border-white/20">
                                ACADEMIC YEAR 2026-2027
                            </span>
                            <h1 class="font-heading font-black text-4xl sm:text-6xl text-white tracking-tight leading-tight">
                                Enverga University Event Passes
                            </h1>
                            <p class="text-base text-gray-100">
                                Check tuition clearance and claim verified digital event passes with instant QR check-in.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="swiper-pagination bottom-6"></div>
    </div>
</div>

<!-- 3 Clean White Action Cards (Full Bleed Width) -->
<div class="bg-gray-50 border-b border-gray-200 py-10 w-full">
    <div class="w-full px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <a href="#events-catalog" class="bg-white rounded-xl p-6 shadow-md border border-gray-200 flex items-center gap-5 hover:border-mseuf-crimson hover:-translate-y-1 transition duration-300 group">
                <div class="w-12 h-12 rounded-full bg-amber-100 text-mseuf-crimson flex items-center justify-center font-heading font-black text-xs flex-shrink-0 group-hover:bg-mseuf-crimson group-hover:text-white transition">
                    PASS
                </div>
                <div>
                    <div class="font-heading font-black text-sm text-mseuf-crimson uppercase tracking-wide">
                        BROWSE EVENTS & PASSES
                    </div>
                    <div class="text-xs text-gray-500 font-medium mt-0.5">
                        Claim free passes or reserve event tickets
                    </div>
                </div>
            </a>

            <a href="{{ route('clearance.index') }}" class="bg-white rounded-xl p-6 shadow-md border border-gray-200 flex items-center gap-5 hover:border-mseuf-crimson hover:-translate-y-1 transition duration-300 group">
                <div class="w-12 h-12 rounded-full bg-amber-100 text-mseuf-crimson flex items-center justify-center font-heading font-black text-xs flex-shrink-0 group-hover:bg-mseuf-crimson group-hover:text-white transition">
                    BAL
                </div>
                <div>
                    <div class="font-heading font-black text-sm text-mseuf-crimson uppercase tracking-wide">
                        TUITION CLEARANCE CHECK
                    </div>
                    <div class="text-xs text-gray-500 font-medium mt-0.5">
                        Verify student financial eligibility
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.login') }}" class="bg-white rounded-xl p-6 shadow-md border border-gray-200 flex items-center gap-5 hover:border-mseuf-crimson hover:-translate-y-1 transition duration-300 group">
                <div class="w-12 h-12 rounded-full bg-amber-100 text-mseuf-crimson flex items-center justify-center font-heading font-black text-xs flex-shrink-0 group-hover:bg-mseuf-crimson group-hover:text-white transition">
                    GATE
                </div>
                <div>
                    <div class="font-heading font-black text-sm text-mseuf-crimson uppercase tracking-wide">
                        ADMIN GATE SCANNER
                    </div>
                    <div class="text-xs text-gray-500 font-medium mt-0.5">
                        Staff QR check-in & event gate operations
                    </div>
                </div>
            </a>

        </div>
    </div>
</div>

<!-- Events Catalog Section (Full Bleed Width) -->
<div id="events-catalog" class="w-full px-8 py-16">
    
    <div class="border-b border-gray-200 pb-6 mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <span class="text-xs font-heading font-bold text-mseuf-crimson uppercase tracking-widest">
                Manuel S. Enverga University Foundation
            </span>
            <h2 class="font-heading font-black text-3xl sm:text-4xl text-mseuf-darkText uppercase tracking-tight mt-1">
                UPCOMING UNIVERSITY EVENTS
            </h2>
        </div>

        <!-- Category Filters -->
        <div class="flex flex-wrap gap-2 text-xs font-heading font-bold uppercase tracking-wider">
            <a href="{{ route('events.index') }}" class="px-4 py-2 rounded-full border {{ !$category ? 'bg-mseuf-crimson text-white border-mseuf-crimson' : 'bg-white text-gray-700 border-gray-300 hover:border-gray-400' }}">
                ALL EVENTS
            </a>
            <a href="{{ route('events.index', ['category' => 'University Festival']) }}" class="px-4 py-2 rounded-full border {{ $category == 'University Festival' ? 'bg-mseuf-crimson text-white border-mseuf-crimson' : 'bg-white text-gray-700 border-gray-300 hover:border-gray-400' }}">
                FESTIVALS
            </a>
            <a href="{{ route('events.index', ['category' => 'Academic & Tech']) }}" class="px-4 py-2 rounded-full border {{ $category == 'Academic & Tech' ? 'bg-mseuf-crimson text-white border-mseuf-crimson' : 'bg-white text-gray-700 border-gray-300 hover:border-gray-400' }}">
                ACADEMIC
            </a>
            <a href="{{ route('events.index', ['category' => 'Sports & Athletics']) }}" class="px-4 py-2 rounded-full border {{ $category == 'Sports & Athletics' ? 'bg-mseuf-crimson text-white border-mseuf-crimson' : 'bg-white text-gray-700 border-gray-300 hover:border-gray-400' }}">
                SPORTS
            </a>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($events as $event)
            <div class="reveal-card bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition duration-300">
                
                <div>
                    <!-- Image Banner -->
                    <div class="relative h-48 bg-gray-100 border-b border-gray-200 overflow-hidden">
                        <img src="{{ $event->banner_image }}" alt="{{ $event->title }}" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                        
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 bg-mseuf-crimson text-white font-heading font-bold text-[10px] uppercase tracking-wider rounded">
                                {{ $event->category }}
                            </span>
                        </div>

                        <div class="absolute top-3 right-3">
                            @if($event->requires_tuition_clearance)
                                <span class="px-2.5 py-1 bg-amber-800 text-white font-heading font-bold text-[10px] uppercase tracking-wider rounded">
                                    TUITION CLEARANCE REQUIRED
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-emerald-800 text-white font-heading font-bold text-[10px] uppercase tracking-wider rounded">
                                    OPEN PASS
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <div class="text-[11px] font-heading font-bold text-mseuf-crimson uppercase tracking-wider mb-2">
                            {{ $event->event_date->format('F d, Y • g:i A') }}
                        </div>

                        <h3 class="font-heading font-bold text-lg text-mseuf-darkText mb-3 leading-snug hover:text-mseuf-crimson transition-colors">
                            <a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a>
                        </h3>

                        <p class="text-gray-600 text-xs leading-relaxed line-clamp-3 mb-4 font-normal">
                            {{ $event->description }}
                        </p>

                        <div class="border-t border-gray-100 pt-3 text-xs text-gray-500 space-y-1 font-medium">
                            <div><strong class="text-gray-800">Venue:</strong> {{ $event->location }}</div>
                            <div><strong class="text-gray-800">Organizer:</strong> {{ $event->organizer }}</div>
                        </div>
                    </div>
                </div>

                <!-- Footer Card Action -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-heading font-bold uppercase text-gray-400">Pass Price</div>
                        <div class="font-heading font-extrabold text-sm text-mseuf-crimson">
                            @if($event->ticketTypes->min('price') == 0)
                                FREE PASS
                            @else
                                PHP {{ number_format($event->ticketTypes->min('price'), 2) }}
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('events.show', $event->slug) }}" class="mseuf-apply-btn font-heading font-bold text-xs px-5 py-2.5 rounded-full uppercase tracking-wider shadow-sm transition transform hover:scale-105">
                        RESERVE PASS
                    </a>
                </div>

            </div>
        @endforeach
    </div>

</div>

<!-- Initialize Swiper Carousel -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
</script>

@endsection
