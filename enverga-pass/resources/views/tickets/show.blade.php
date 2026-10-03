@extends('layouts.app')

@section('title', 'Official Digital Event Pass — Manuel S. Enverga University Foundation')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-12">
    
    <div class="text-center mb-8">
        <div class="inline-block px-4 py-1.5 bg-emerald-100 text-emerald-800 font-heading font-extrabold text-xs uppercase tracking-wider rounded-full mb-3 border border-emerald-300 shadow-sm">
            PASS ISSUED & ACTIVE
        </div>
        <h1 class="font-heading font-black text-3xl sm:text-4xl text-mseuf-darkText uppercase tracking-tight">
            Official Event Access Pass
        </h1>
        <p class="text-gray-600 text-xs sm:text-sm mt-2 font-medium">Present this digital verification pass upon entry at the MSEUF venue</p>
    </div>

    <!-- Official High-Contrast Document Style Ticket -->
    <div class="bg-white border-2 border-mseuf-crimson rounded-2xl overflow-hidden shadow-2xl">
        
        <!-- Header with Transparent SVG Logo -->
        <div class="bg-[#730000] text-white p-6 sm:p-8 border-b-4 border-[#D4AF37] flex items-center justify-between">
            <div>
                <div class="text-xs font-heading font-black text-amber-300 uppercase tracking-widest">Manuel S. Enverga University Foundation</div>
                <h2 class="font-heading font-black text-2xl sm:text-3xl text-white mt-1 leading-tight">{{ $ticket->event->title }}</h2>
                <div class="text-xs text-gray-200 mt-2 font-medium">Location: <strong class="text-white">{{ $ticket->event->location }}</strong></div>
            </div>
            <div class="flex-shrink-0">
                <img src="{{ asset('images/eu-logo.svg') }}" alt="MSEUF Logo" class="h-16 w-auto object-contain filter brightness-0 invert">
            </div>
        </div>

        <!-- Body with Crisp Dark Labels & Pure White Cards -->
        <div class="p-6 sm:p-8 space-y-6 bg-white">
            
            <div class="flex flex-col sm:flex-row items-center gap-8 p-6 bg-gray-50 border-2 border-gray-200 rounded-xl">
                <div class="bg-white p-3 border-2 border-gray-300 rounded-xl shadow-md flex-shrink-0">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('tickets.verify', ['hash' => $ticket->qr_code_hash])) }}" alt="QR Code" class="w-44 h-44">
                </div>
                
                <div class="space-y-4 text-xs w-full">
                    <div>
                        <div class="text-gray-700 font-heading font-black uppercase text-xs tracking-wider">Pass Number</div>
                        <div class="font-mono font-black text-xl text-mseuf-crimson mt-0.5 tracking-wider">{{ $ticket->ticket_number }}</div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-t border-gray-200 pt-3">
                        <div>
                            <div class="text-gray-700 font-heading font-black uppercase text-[11px] tracking-wider">Student Name</div>
                            <div class="font-bold text-gray-900 text-sm mt-0.5">{{ $ticket->attendee_name }}</div>
                        </div>
                        <div>
                            <div class="text-gray-700 font-heading font-black uppercase text-[11px] tracking-wider">Student ID</div>
                            <div class="font-mono font-bold text-gray-900 text-sm mt-0.5">{{ $ticket->student_id }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-t border-gray-200 pt-3">
                        <div>
                            <div class="text-gray-700 font-heading font-black uppercase text-[11px] tracking-wider">Pass Tier</div>
                            <div class="font-bold text-gray-900 text-sm mt-0.5">{{ $ticket->ticketType->name }}</div>
                        </div>
                        <div>
                            <div class="text-gray-700 font-heading font-black uppercase text-[11px] tracking-wider">Tuition Status</div>
                            <div class="font-heading font-black text-emerald-700 text-sm mt-0.5 uppercase">Cleared ✓</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crisp Event Schedule Grid -->
            <div class="border-t border-gray-200 pt-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <div class="text-gray-700 font-heading font-black uppercase text-[11px]">Date & Schedule</div>
                    <div class="font-bold text-gray-900 text-sm mt-1">{{ $ticket->event->event_date->format('F d, Y • g:i A') }}</div>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <div class="text-gray-700 font-heading font-black uppercase text-[11px]">Payment Reference</div>
                    <div class="font-mono font-bold text-gray-900 text-sm mt-1">{{ $ticket->payment->reference_number ?? 'N/A' }}</div>
                </div>
            </div>

        </div>

        <div class="bg-gray-100 px-6 py-4 text-center text-xs text-gray-700 border-t border-gray-200 font-semibold">
            Authorized by MSEUF Office of Student Affairs & Supreme Student Council
        </div>

    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('events.index') }}" class="font-heading font-bold text-xs uppercase tracking-wider text-mseuf-crimson hover:underline border border-mseuf-crimson px-5 py-2.5 rounded-full inline-block">
            &larr; Return to Event Catalog
        </a>
    </div>

</div>

@endsection
