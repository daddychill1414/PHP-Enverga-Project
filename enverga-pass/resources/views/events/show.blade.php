@extends('layouts.app')

@section('title', $event->title . ' — Manuel S. Enverga University Foundation')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-6">
        <a href="{{ route('events.index') }}" class="text-xs font-bold uppercase tracking-wider text-mseuf-crimson hover:underline">
            &larr; Return to Event Catalog
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        <!-- Main Content -->
        <div class="lg:col-span-8 space-y-6">
            
            <div class="bg-white border border-mseuf-border rounded overflow-hidden shadow-sm">
                <!-- Image Header -->
                <div class="relative h-72 sm:h-96 bg-gray-100 border-b border-mseuf-border">
                    <img src="{{ $event->banner_image }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-mseuf-crimson text-white font-bold text-xs uppercase tracking-wider rounded-sm">
                            {{ $event->category }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-mseuf-darkText mb-3">
                        {{ $event->title }}
                    </h1>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-4 border-y border-mseuf-border text-xs text-gray-600 mb-6">
                        <div><strong class="text-gray-900">Date & Time:</strong> {{ $event->event_date->format('F d, Y • g:i A') }}</div>
                        <div><strong class="text-gray-900">Venue:</strong> {{ $event->location }}</div>
                        <div><strong class="text-gray-900">Organized By:</strong> {{ $event->organizer }}</div>
                        <div><strong class="text-gray-900">Tuition Clearance:</strong> {{ $event->requires_tuition_clearance ? 'Required' : 'Not Required' }}</div>
                    </div>

                    <h3 class="font-bold text-sm text-gray-900 uppercase tracking-wider mb-2">Event Description</h3>
                    <p class="text-mseuf-mutedText text-xs leading-relaxed whitespace-pre-line">
                        {{ $event->description }}
                    </p>
                </div>
            </div>

        </div>

        <!-- Sidebar Registration Form -->
        <div class="lg:col-span-4">
            <div class="bg-white border-2 border-mseuf-crimson rounded p-6 shadow-sm sticky top-28">
                
                <div class="border-b border-mseuf-border pb-4 mb-6">
                    <div class="text-xs font-bold text-mseuf-crimson uppercase tracking-wider">Student Registration</div>
                    <h2 class="font-display font-bold text-xl text-mseuf-darkText mt-1">Issue Digital Pass</h2>
                </div>

                <form action="{{ route('tickets.processCheckout', $event->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Student ID Number *</label>
                        <input type="text" name="student_id" value="2022-10482" required placeholder="2022-10482" class="w-full px-3 py-2.5 border border-gray-300 rounded font-mono text-xs focus:ring-1 focus:ring-mseuf-crimson focus:border-mseuf-crimson">
                        <span class="text-[10px] text-gray-500 mt-1 block">Test IDs: <code class="text-mseuf-crimson font-bold">2022-10482</code> (Cleared) | <code class="text-amber-700 font-bold">2023-99812</code> (Uncleared)</span>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Full Name *</label>
                        <input type="text" name="attendee_name" value="Juan Dela Cruz" required placeholder="Juan Dela Cruz" class="w-full px-3 py-2.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-mseuf-crimson focus:border-mseuf-crimson">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Institutional Email *</label>
                        <input type="email" name="attendee_email" value="juan.delacruz@mseuf.edu.ph" required placeholder="juan.delacruz@mseuf.edu.ph" class="w-full px-3 py-2.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-mseuf-crimson focus:border-mseuf-crimson">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Select Pass Tier *</label>
                        <div class="space-y-2">
                            @foreach($event->ticketTypes as $type)
                                <label class="flex items-center justify-between p-3 border border-gray-200 rounded cursor-pointer hover:border-mseuf-crimson">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="ticket_type_id" value="{{ $type->id }}" {{ $loop->first ? 'checked' : '' }} class="text-mseuf-crimson">
                                        <span class="font-medium text-gray-800">{{ $type->name }}</span>
                                    </div>
                                    <span class="font-bold text-mseuf-crimson">
                                        {{ $type->price == 0 ? 'Free' : 'PHP ' . number_format($type->price, 2) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Payment Method *</label>
                        <select name="payment_method" class="w-full px-3 py-2.5 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-mseuf-crimson focus:border-mseuf-crimson">
                            <option value="Tuition Verification / Free Pass">Tuition Verification / Free Pass</option>
                            <option value="GCash">GCash</option>
                            <option value="Maya">Maya</option>
                            <option value="MSEUF Cashier Counter">MSEUF Cashier Counter</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-mseuf-crimson text-white font-bold py-3 rounded uppercase tracking-wider text-xs hover:bg-mseuf-darkcrimson transition mt-2">
                        Verify Clearance & Generate Pass
                    </button>
                </form>

            </div>
        </div>

    </div>

</div>

@endsection
