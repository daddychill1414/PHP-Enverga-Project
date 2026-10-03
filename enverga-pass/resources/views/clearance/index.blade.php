@extends('layouts.app')

@section('title', 'Tuition Clearance Verification — Manuel S. Enverga University Foundation')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-12">
    
    <div class="text-center mb-8">
        <div class="text-xs font-bold uppercase tracking-widest text-mseuf-crimson mb-1">
            Student Financial Verification Portal
        </div>
        <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-mseuf-darkText">
            Tuition Clearance Checker
        </h1>
        <p class="text-gray-500 text-xs max-w-lg mx-auto mt-2">
            Verify student financial eligibility for official university event passes. Students must have settled tuition balances to issue free or reserved passes.
        </p>
    </div>

    <!-- Form Box -->
    <div class="bg-white border border-mseuf-border rounded p-6 sm:p-8 shadow-sm mb-8">
        <form action="{{ route('clearance.check') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <input type="text" name="student_id" value="{{ request('student_id') ?? '2022-10482' }}" required placeholder="Student ID Number (e.g. 2022-10482)" class="flex-grow px-4 py-3 border border-gray-300 rounded font-mono text-xs focus:ring-1 focus:ring-mseuf-crimson focus:border-mseuf-crimson">
            
            <button type="submit" class="bg-mseuf-crimson text-white font-bold px-6 py-3 rounded text-xs uppercase tracking-wider hover:bg-mseuf-darkcrimson transition">
                Search Clearance Status
            </button>
        </form>

        <div class="mt-4 text-[11px] text-gray-500 flex items-center justify-between border-t border-gray-100 pt-3">
            <span>Demo Test Student IDs:</span>
            <div class="space-x-2">
                <code class="bg-gray-100 px-2 py-0.5 rounded font-mono text-emerald-800 font-bold">2022-10482 (Cleared)</code>
                <code class="bg-gray-100 px-2 py-0.5 rounded font-mono text-rose-800 font-bold">2023-99812 (Pending)</code>
            </div>
        </div>
    </div>

    @if(isset($clearance))
        <!-- Verification Record Card -->
        <div class="bg-white border-2 {{ $clearance->is_cleared ? 'border-emerald-600' : 'border-rose-600' }} rounded p-6 sm:p-8 shadow-sm">
            
            <div class="flex items-center justify-between pb-4 border-b border-mseuf-border">
                <div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Student Name</div>
                    <div class="font-display font-bold text-xl text-mseuf-darkText">{{ $clearance->student_name }}</div>
                    <div class="text-xs font-mono text-gray-500 mt-0.5">ID: {{ $clearance->student_id }} &bull; {{ $clearance->department }}</div>
                </div>

                <div>
                    @if($clearance->is_cleared)
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 font-bold text-xs uppercase tracking-wider rounded border border-emerald-300">
                            Cleared
                        </span>
                    @else
                        <span class="px-3 py-1 bg-rose-100 text-rose-800 font-bold text-xs uppercase tracking-wider rounded border border-rose-300">
                            Pending Balance
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 text-xs">
                
                <div class="bg-gray-50 p-4 rounded border border-gray-200">
                    <div class="text-gray-500 font-bold uppercase text-[10px]">Tuition Outstanding Balance</div>
                    <div class="font-display font-bold text-2xl mt-1 {{ $clearance->tuition_balance == 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                        PHP {{ number_format($clearance->tuition_balance, 2) }}
                    </div>
                    <div class="text-[11px] text-gray-500 mt-2">
                        @if($clearance->tuition_balance == 0)
                            Eligible for all university event passes.
                        @else
                            Please visit the MSEUF Treasurer's Office to settle balance.
                        @endif
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded border border-gray-200 flex flex-col justify-between">
                    <div>
                        <div class="text-gray-500 font-bold uppercase text-[10px]">Academic Period</div>
                        <div class="font-bold text-gray-800 mt-1">{{ $clearance->cleared_semester }}</div>
                    </div>

                    @if($clearance->is_cleared)
                        <div class="mt-4">
                            <a href="{{ route('events.index') }}" class="block text-center bg-mseuf-crimson text-white font-bold py-2.5 rounded text-xs uppercase tracking-wider hover:bg-mseuf-darkcrimson transition">
                                Browse Available Passes &rarr;
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    @endif

</div>

@endsection
