@extends('layouts.app')

@section('title', 'Sustainability & SDG Initiatives — Manuel S. Enverga University Foundation')

@section('content')

<!-- Hero Header -->
<div class="relative bg-black overflow-hidden border-b-4 border-mseuf-buttonGold">
    <div class="relative h-[360px] sm:h-[400px]">
        <img src="https://images.unsplash.com/photo-1497435334941-8c899ee9e8e9?auto=format&fit=crop&w=1600&q=80" alt="Sustainability Campus" class="w-full h-full object-cover opacity-35">
        <div class="absolute inset-0 bg-gradient-to-r from-[#4A0000] via-[#4A0000]/80 to-transparent"></div>
        <div class="w-full px-6 sm:px-12 h-full flex items-center relative z-10 text-white">
            <div class="max-w-3xl space-y-3">
                <span class="inline-block px-3.5 py-1 bg-white/10 text-emerald-300 font-heading font-bold text-xs uppercase tracking-widest rounded border border-white/20">
                    Sustainable Development Goals (SDGs) &bull; Green Campus
                </span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight leading-tight">
                    Sustainability &amp; Community Stewardship
                </h1>
                <p class="text-sm sm:text-base text-gray-200 font-normal leading-relaxed max-w-2xl">
                    Advancing sustainable operations across our campuses, from zero-paper digital ticketing with Enverga Pass to coastal conservation and community renewable initiatives across Quezon.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Main Body -->
<div class="max-w-6xl mx-auto px-6 py-16 space-y-16">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
            <div class="text-2xl font-heading font-black text-emerald-700 mb-2">Paperless Campus</div>
            <h4 class="font-heading font-bold text-sm uppercase text-gray-900 mb-2">Digital Event Passes</h4>
            <p class="text-xs text-gray-600 leading-relaxed">
                By replacing printed paper passes with cryptographic QR codes on Enverga Pass, the university saves thousands of sheets of paper per semester.
            </p>
        </div>

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
            <div class="text-2xl font-heading font-black text-emerald-700 mb-2">Community Extension</div>
            <h4 class="font-heading font-bold text-sm uppercase text-gray-900 mb-2">Flagship CES Programs</h4>
            <p class="text-xs text-gray-600 leading-relaxed">
                Empowering partner coastal and agricultural municipalities in Quezon with digital literacy and sustainable livelihood development.
            </p>
        </div>

        <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
            <div class="text-2xl font-heading font-black text-emerald-700 mb-2">SDG Alignment</div>
            <h4 class="font-heading font-bold text-sm uppercase text-gray-900 mb-2">UN Goals 4, 11 &amp; 13</h4>
            <p class="text-xs text-gray-600 leading-relaxed">
                Committed to Quality Education (SDG 4), Sustainable Cities and Communities (SDG 11), and proactive Climate Action (SDG 13).
            </p>
        </div>
    </div>

</div>

@endsection
