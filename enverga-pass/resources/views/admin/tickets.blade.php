@extends('layouts.admin')

@section('title', 'Ticket Management')
@section('page-title', 'Tickets & Attendance')
@section('page-subtitle', 'View all issued tickets and attendance records')

@section('styles')
<style>
    .filters-bar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .filter-group label {
        font-size: 0.6rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .filter-group select,
    .filter-group input {
        padding: 0.45rem 0.65rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-dark);
        background: white;
        outline: none;
        min-width: 140px;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        border-color: var(--crimson);
    }

    .table-panel {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .table-scroll {
        overflow-x: auto;
    }

    .action-btn {
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 0.65rem;
        font-weight: 700;
        cursor: pointer;
        border: 1.5px solid var(--border);
        background: white;
        color: var(--text-dark);
        transition: all 0.15s;
    }

    .action-btn:hover {
        background: #f3f4f6;
    }

    .action-btn.cancel {
        border-color: var(--error-border);
        color: var(--error);
    }

    .action-btn.cancel:hover {
        background: var(--error-bg);
    }

    .pagination-bar {
        padding: 0.75rem 1.25rem;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .pagination-bar .info {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    .pagination-links {
        display: flex;
        gap: 0.25rem;
    }

    .pagination-links a,
    .pagination-links span {
        padding: 0.35rem 0.65rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid var(--border);
        color: var(--text-dark);
        background: white;
    }

    .pagination-links a:hover {
        background: #f3f4f6;
    }

    .pagination-links .current {
        background: var(--crimson);
        color: white;
        border-color: var(--crimson);
    }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 100;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.open {
        display: flex;
    }

    .modal-box {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .modal-box h3 {
        font-size: 1.1rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
    }

    .modal-box p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    .modal-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .filters-bar {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
@endsection

@section('content')
<!-- Filters -->
<form method="GET" action="{{ route('admin.tickets') }}" class="filters-bar">
    <div class="filter-group">
        <label>Search</label>
        <input type="text" name="search" placeholder="Name or Student ID" value="{{ request('search') }}">
    </div>
    <div class="filter-group">
        <label>Event</label>
        <select name="event_id">
            <option value="">All Events</option>
            @foreach($events as $event)
                <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="filter-group">
        <label>Status</label>
        <select name="status">
            <option value="">All</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="checked_in" {{ request('status') === 'checked_in' ? 'selected' : '' }}>Checked In</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>Reserved</option>
        </select>
    </div>
    <div class="filter-group" style="justify-content: flex-end;">
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-outline" style="padding: 0.45rem 0.9rem;">Filter</button>
    </div>
</form>

<!-- Table -->
<div class="table-panel">
    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Ticket #</th>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Event</th>
                    <th>Tier</th>
                    <th>Status</th>
                    <th>Checked In</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td><span class="mono">{{ $ticket->ticket_number }}</span></td>
                        <td style="font-weight:700;">{{ $ticket->attendee_name }}</td>
                        <td><span class="mono">{{ $ticket->student_id }}</span></td>
                        <td>{{ $ticket->event->title }}</td>
                        <td>{{ $ticket->ticketType->name }}</td>
                        <td>
                            @switch($ticket->status)
                                @case('confirmed')
                                    <span class="badge badge-info">Confirmed</span>
                                    @break
                                @case('checked_in')
                                    <span class="badge badge-success">Checked In</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge badge-error">Cancelled</span>
                                    @break
                                @case('reserved')
                                    <span class="badge badge-warning">Reserved</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @if($ticket->checked_in_at)
                                <span class="mono">{{ $ticket->checked_in_at->format('M d, g:i A') }}</span>
                            @else
                                <span style="color: var(--text-light);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($ticket->status !== 'cancelled')
                                <button class="action-btn cancel" onclick="confirmCancel({{ $ticket->id }}, '{{ $ticket->ticket_number }}', '{{ addslashes($ticket->attendee_name) }}')">✕ Cancel</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:2rem; color:var(--text-light);">No tickets found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
        <div class="pagination-bar">
            <span class="info">Showing {{ $tickets->firstItem() }}–{{ $tickets->lastItem() }} of {{ $tickets->total() }}</span>
            <div class="pagination-links">
                @if($tickets->onFirstPage())
                    <span>←</span>
                @else
                    <a href="{{ $tickets->previousPageUrl() }}">←</a>
                @endif

                @foreach($tickets->getUrlRange(max(1, $tickets->currentPage()-2), min($tickets->lastPage(), $tickets->currentPage()+2)) as $page => $url)
                    @if($page == $tickets->currentPage())
                        <span class="current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($tickets->hasMorePages())
                    <a href="{{ $tickets->nextPageUrl() }}">→</a>
                @else
                    <span>→</span>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Cancel Modal -->
<div class="modal-overlay" id="cancelModal">
    <div class="modal-box">
        <h3>Cancel Ticket</h3>
        <p id="cancelMessage">Are you sure you want to cancel this ticket?</p>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeModal()">Keep Ticket</button>
            <form id="cancelForm" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-danger">✕ Cancel Ticket</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmCancel(ticketId, ticketNumber, name) {
        document.getElementById('cancelForm').action = `/admin/tickets/${ticketId}/cancel`;
        document.getElementById('cancelMessage').textContent = `Cancel ticket ${ticketNumber} for ${name}? This action cannot be undone.`;
        document.getElementById('cancelModal').classList.add('open');
    }

    function closeModal() {
        document.getElementById('cancelModal').classList.remove('open');
    }

    document.getElementById('cancelModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection
