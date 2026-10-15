<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Payment;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard — overview stats and recent activity.
     */
    public function dashboard()
    {
        $totalTickets = Ticket::count();
        $checkedInToday = Ticket::where('status', 'checked_in')
            ->whereDate('checked_in_at', Carbon::today())
            ->count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $activeEvents = Event::whereIn('status', ['upcoming', 'ongoing'])->count();

        $statusBreakdown = Ticket::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $recentCheckins = Ticket::with(['event', 'ticketType'])
            ->where('status', 'checked_in')
            ->orderByDesc('checked_in_at')
            ->limit(10)
            ->get();

        $events = Event::withCount('tickets')
            ->orderByDesc('event_date')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalTickets',
            'checkedInToday',
            'totalRevenue',
            'activeEvents',
            'statusBreakdown',
            'recentCheckins',
            'events'
        ));
    }

    /**
     * QR Scanner page.
     */
    public function scanner()
    {
        $events = Event::whereIn('status', ['upcoming', 'ongoing'])
            ->orderByDesc('event_date')
            ->get();

        $checkedInToday = Ticket::where('status', 'checked_in')
            ->whereDate('checked_in_at', Carbon::today())
            ->count();

        $totalTickets = Ticket::whereIn('status', ['confirmed', 'checked_in'])->count();

        return view('admin.scanner', compact('events', 'checkedInToday', 'totalTickets'));
    }

    /**
     * Verify a ticket via QR hash or ticket number (AJAX).
     */
    public function verifyTicket(Request $request)
    {
        $hash = $request->input('hash');
        $ticketNumber = $request->input('ticket_number');
        $eventId = $request->input('event_id');

        $query = Ticket::with(['event', 'ticketType', 'payment']);

        if ($hash) {
            // Extract hash from URL if a full URL was scanned
            if (str_contains($hash, 'hash=')) {
                parse_str(parse_url($hash, PHP_URL_QUERY) ?? '', $params);
                $hash = $params['hash'] ?? $hash;
            }
            $query->where('qr_code_hash', $hash);
        } elseif ($ticketNumber) {
            $query->where('ticket_number', $ticketNumber);
        } else {
            return response()->json(['valid' => false, 'message' => 'No ticket identifier provided']);
        }

        $ticket = $query->first();

        if (!$ticket) {
            return response()->json(['valid' => false, 'message' => 'Invalid QR Code — ticket not found']);
        }

        // Check event match if filter is set
        if ($eventId && $ticket->event_id != $eventId) {
            return response()->json([
                'valid' => false,
                'message' => 'Wrong event — this ticket is for "' . $ticket->event->title . '"',
                'attendee_name' => $ticket->attendee_name,
                'student_id' => $ticket->student_id,
                'ticket_number' => $ticket->ticket_number,
            ]);
        }

        // Check if cancelled
        if ($ticket->status === 'cancelled') {
            return response()->json([
                'valid' => false,
                'message' => 'This ticket has been cancelled',
                'attendee_name' => $ticket->attendee_name,
                'student_id' => $ticket->student_id,
                'ticket_number' => $ticket->ticket_number,
            ]);
        }

        // Check if already checked in
        if ($ticket->status === 'checked_in') {
            return response()->json([
                'valid' => true,
                'already_checked_in' => true,
                'can_check_in' => false,
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'attendee_name' => $ticket->attendee_name,
                'student_id' => $ticket->student_id,
                'event' => $ticket->event->title,
                'ticket_type' => $ticket->ticketType->name,
                'payment_status' => $ticket->payment?->status ?? 'N/A',
                'checked_in_at' => $ticket->checked_in_at?->format('g:i A, M d'),
            ]);
        }

        // Check payment status
        $paymentOk = !$ticket->payment || $ticket->payment->status === 'completed';
        $paymentWarning = '';
        if ($ticket->payment && $ticket->payment->status === 'pending') {
            $paymentWarning = ' (Payment pending)';
        }

        // ✅ Valid and ready for check-in
        return response()->json([
            'valid' => true,
            'can_check_in' => true,
            'already_checked_in' => false,
            'ticket_id' => $ticket->id,
            'ticket_number' => $ticket->ticket_number,
            'attendee_name' => $ticket->attendee_name,
            'student_id' => $ticket->student_id,
            'event' => $ticket->event->title,
            'ticket_type' => $ticket->ticketType->name,
            'payment_status' => ($ticket->payment?->status ?? 'Free') . $paymentWarning,
        ]);
    }

    /**
     * Perform check-in (AJAX).
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        if ($ticket->status === 'checked_in') {
            return response()->json([
                'success' => false,
                'message' => 'Already checked in at ' . $ticket->checked_in_at?->format('g:i A'),
            ]);
        }

        if ($ticket->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot check in a cancelled ticket',
            ]);
        }

        $ticket->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);

        // Send Email Verification confirming Paid & Validated Check-In
        try {
            if ($ticket->attendee_email) {
                $ticket->load(['event', 'ticketType', 'payment']);
                \Illuminate\Support\Facades\Mail::to($ticket->attendee_email)
                    ->send(new \App\Mail\TicketPaidAndCheckedInMail($ticket));
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("Check-in confirmation email could not be sent: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Checked in successfully — verification email sent to student',
            'checked_in_at' => now()->format('g:i A, M d'),
        ]);
    }

    /**
     * Payments list with filters.
     */
    public function payments(Request $request)
    {
        $query = Payment::with(['ticket.event', 'ticket.ticketType']);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('ticket', function ($tq) use ($search) {
                        $tq->where('attendee_name', 'like', "%{$search}%")
                            ->orWhere('student_id', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Method filter
        if ($method = $request->input('method')) {
            $query->where('payment_method', $method);
        }

        // Event filter
        if ($eventId = $request->input('event_id')) {
            $query->whereHas('ticket', fn($q) => $q->where('event_id', $eventId));
        }

        $payments = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        $events = Event::orderByDesc('event_date')->get();

        return view('admin.payments', compact('payments', 'events'));
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => $request->status,
            'paid_at' => $request->status === 'completed' ? now() : $payment->paid_at,
        ]);

        return redirect()->route('admin.payments')->with('success', "Payment {$payment->reference_number} updated to {$request->status}.");
    }

    /**
     * Tickets list with filters.
     */
    public function tickets(Request $request)
    {
        $query = Ticket::with(['event', 'ticketType']);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('attendee_name', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('ticket_number', 'like', "%{$search}%");
            });
        }

        // Event filter
        if ($eventId = $request->input('event_id')) {
            $query->where('event_id', $eventId);
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $tickets = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        $events = Event::orderByDesc('event_date')->get();

        return view('admin.tickets', compact('tickets', 'events'));
    }

    /**
     * Cancel a ticket.
     */
    public function cancelTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update(['status' => 'cancelled']);

        // Restore ticket quota
        $ticket->ticketType?->increment('remaining');

        return redirect()->route('admin.tickets')->with('success', "Ticket {$ticket->ticket_number} has been cancelled.");
    }

    /**
     * Events list with creation support.
     */
    public function events()
    {
        $events = Event::with('ticketTypes')->withCount('tickets')->orderByDesc('event_date')->paginate(15);
        return view('admin.events', compact('events'));
    }

    /**
     * Store newly created event.
     */
    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'category' => 'required|string',
            'event_date' => 'required|date',
            'banner_image' => 'nullable|url',
            'total_capacity' => 'required|integer|min:1',
            'requires_tuition_clearance' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'ticket_name' => 'required|array|min:1',
            'ticket_name.*' => 'required|string|max:255',
            'ticket_price' => 'required|array|min:1',
            'ticket_price.*' => 'required|numeric|min:0',
            'ticket_quota' => 'required|array|min:1',
            'ticket_quota.*' => 'required|integer|min:1',
        ]);

        $slug = \Illuminate\Support\Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $event = Event::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'location' => $request->location,
            'organizer' => $request->organizer,
            'category' => $request->category,
            'event_date' => $request->event_date,
            'banner_image' => $request->banner_image ?: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80',
            'total_capacity' => $request->total_capacity,
            'requires_tuition_clearance' => $request->boolean('requires_tuition_clearance'),
            'is_featured' => $request->boolean('is_featured'),
            'status' => 'upcoming',
        ]);

        foreach ($request->ticket_name as $index => $name) {
            $price = $request->ticket_price[$index] ?? 0;
            $quota = $request->ticket_quota[$index] ?? 100;

            $event->ticketTypes()->create([
                'name' => $name,
                'price' => $price,
                'quota' => $quota,
                'remaining' => $quota,
            ]);
        }

        return redirect()->route('admin.events')->with('success', "Event '{$event->title}' and ticket tiers created successfully!");
    }

    /**
     * Delete an event.
     */
    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $title = $event->title;
        $event->delete();

        return redirect()->route('admin.events')->with('success', "Event '{$title}' removed successfully.");
    }
}
