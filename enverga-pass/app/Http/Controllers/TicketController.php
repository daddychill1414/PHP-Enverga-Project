<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\TuitionClearance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function checkout(Request $request, $eventId)
    {
        $event = Event::with('ticketTypes')->findOrFail($eventId);
        $ticketTypes = $event->ticketTypes;
        
        return view('tickets.checkout', compact('event', 'ticketTypes'));
    }

    public function processCheckout(Request $request, $eventId)
    {
        $request->validate([
            'student_id' => 'required|string',
            'attendee_name' => 'required|string',
            'attendee_email' => 'required|email',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'payment_method' => 'required|string',
        ]);

        $event = Event::findOrFail($eventId);

        // Check Tuition Clearance if required
        if ($event->requires_tuition_clearance) {
            $clearance = TuitionClearance::where('student_id', $request->student_id)->first();
            if (!$clearance || !$clearance->is_cleared) {
                $balance = $clearance ? number_format($clearance->tuition_balance, 2) : 'Unregistered';
                return back()->withInput()->with('error', "Tuition Clearance Failed: Student ID {$request->student_id} has an outstanding tuition balance of ₱{$balance}. Please clear your balance at the Treasurer's Office before claiming event tickets.");
            }
        }

        $ticketType = TicketType::findOrFail($request->ticket_type_id);
        if ($ticketType->remaining <= 0) {
            return back()->with('error', 'Sorry, this ticket tier is sold out!');
        }

        // Generate Ticket
        $ticketNumber = 'EVG-' . strtoupper(Str::random(4)) . '-' . rand(1000, 9999);
        $qrHash = hash('sha256', $ticketNumber . '|' . $request->student_id);

        $ticket = Ticket::create([
            'ticket_number' => $ticketNumber,
            'event_id' => $event->id,
            'ticket_type_id' => $ticketType->id,
            'attendee_name' => $request->attendee_name,
            'attendee_email' => $request->attendee_email,
            'student_id' => $request->student_id,
            'qr_code_hash' => $qrHash,
            'status' => 'confirmed',
        ]);

        // Decrement ticket quota
        $ticketType->decrement('remaining');

        // Create Payment record
        $ticket->payment()->create([
            'reference_number' => 'PAY-' . strtoupper(Str::random(6)),
            'amount' => $ticketType->price,
            'payment_method' => $request->payment_method,
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        return redirect()->route('tickets.show', $ticket->ticket_number)->with('success', 'Pass Issued Successfully!');
    }

    public function show($ticketNumber)
    {
        $ticket = Ticket::with(['event', 'ticketType', 'payment'])->where('ticket_number', $ticketNumber)->firstOrFail();
        return view('tickets.show', compact('ticket'));
    }

    public function verify(Request $request)
    {
        $hash = $request->query('hash');
        $ticket = Ticket::with(['event', 'ticketType'])->where('qr_code_hash', $hash)->first();

        if (!$ticket) {
            return response()->json(['valid' => false, 'message' => 'Invalid Ticket QR Code']);
        }

        return response()->json([
            'valid' => true,
            'ticket_number' => $ticket->ticket_number,
            'attendee_name' => $ticket->attendee_name,
            'student_id' => $ticket->student_id,
            'event' => $ticket->event->title,
            'status' => $ticket->status,
        ]);
    }
}
