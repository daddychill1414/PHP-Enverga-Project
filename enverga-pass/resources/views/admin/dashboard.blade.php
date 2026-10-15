@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Real-time overview of events, tickets, and check-ins')

@section('topbar-actions')
    <a href="{{ route('admin.events') }}" class="btn btn-outline" style="margin-right: 0.5rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Manage Events
    </a>
    <a href="{{ route('admin.scanner') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="17" y2="12"/><line x1="7" y1="16" x2="13" y2="16"/></svg>
        Open Scanner
    </a>
@endsection

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
    }

    .stat-card .stat-icon svg {
        width: 18px;
        height: 18px;
    }

    .stat-icon.crimson { background: rgba(115, 0, 0, 0.08); }
    .stat-icon.crimson svg { stroke: var(--crimson); }
    .stat-icon.green { background: rgba(5, 150, 105, 0.08); }
    .stat-icon.green svg { stroke: var(--success); }
    .stat-icon.gold { background: rgba(212, 175, 55, 0.08); }
    .stat-icon.gold svg { stroke: #b8960f; }
    .stat-icon.blue { background: rgba(37, 99, 235, 0.08); }
    .stat-icon.blue svg { stroke: var(--info); }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 1.5rem;
    }

    .panel {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .panel-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .panel-header h3 {
        font-size: 0.85rem;
        font-weight: 800;
    }

    .panel-body {
        padding: 0;
    }

    /* Status breakdown bars */
    .status-bars {
        padding: 1.25rem;
    }

    .status-bar-item {
        margin-bottom: 1rem;
    }

    .status-bar-item:last-child {
        margin-bottom: 0;
    }

    .status-bar-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.35rem;
    }

    .status-bar-label span {
        font-size: 0.75rem;
        font-weight: 700;
    }

    .status-bar-label .count {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-muted);
    }

    .status-bar-track {
        height: 8px;
        background: #f3f4f6;
        border-radius: 4px;
        overflow: hidden;
    }

    .status-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    .status-bar-fill.confirmed { background: var(--info); }
    .status-bar-fill.checked-in { background: var(--success); }
    .status-bar-fill.cancelled { background: var(--error); }
    .status-bar-fill.reserved { background: var(--warning); }

    /* Event list */
    .event-list-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid var(--border);
        transition: background 0.1s;
    }

    .event-list-item:last-child {
        border-bottom: none;
    }

    .event-list-item:hover {
        background: #fafafa;
    }

    .event-list-date {
        width: 44px;
        height: 44px;
        background: rgba(115, 0, 0, 0.06);
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .event-list-date .day {
        font-size: 1rem;
        font-weight: 900;
        color: var(--crimson);
        line-height: 1;
    }

    .event-list-date .month {
        font-size: 0.5rem;
        font-weight: 800;
        color: var(--crimson);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .event-list-info {
        flex: 1;
        min-width: 0;
    }

    .event-list-info h4 {
        font-size: 0.8rem;
        font-weight: 800;
        color: var(--text-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .event-list-info p {
        font-size: 0.65rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-top: 0.1rem;
    }

    .event-list-tickets {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-muted);
        flex-shrink: 0;
    }

    .empty-state {
        padding: 2rem;
        text-align: center;
        color: var(--text-light);
        font-size: 0.8rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Stats Row -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon crimson">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12h6a2 2 0 0 1 2 2v6"/><path d="M22 12h-6a2 2 0 0 0-2 2v6"/><path d="M12 2v6a2 2 0 0 1-2 2H4"/><path d="M12 2v6a2 2 0 0 0 2 2h6"/></svg>
        </div>
        <div class="stat-label">Total Tickets Issued</div>
        <div class="stat-value">{{ number_format($totalTickets) }}</div>
        <div class="stat-sub">Across all events</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div class="stat-label">Checked In Today</div>
        <div class="stat-value">{{ number_format($checkedInToday) }}</div>
        <div class="stat-sub">{{ now()->format('F d, Y') }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value">₱{{ number_format($totalRevenue, 2) }}</div>
        <div class="stat-sub">Completed payments</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div class="stat-label">Active Events</div>
        <div class="stat-value">{{ $activeEvents }}</div>
        <div class="stat-sub">Upcoming &amp; ongoing</div>
    </div>
</div>

<!-- Main grid -->
<div class="dashboard-grid">
    <!-- Recent Check-ins -->
    <div class="panel">
        <div class="panel-header">
            <h3>Recent Check-ins</h3>
            <a href="{{ route('admin.tickets') }}" class="btn btn-outline" style="font-size:0.7rem; padding:0.35rem 0.75rem;">View All</a>
        </div>
        <div class="panel-body">
            @forelse($recentCheckins as $checkin)
                <div class="event-list-item">
                    <div class="event-list-date" style="background: rgba(5, 150, 105, 0.06);">
                        <span class="day" style="color: var(--success);">✓</span>
                    </div>
                    <div class="event-list-info">
                        <h4>{{ $checkin->attendee_name }}</h4>
                        <p>{{ $checkin->student_id }} · {{ $checkin->event->title }} · {{ $checkin->ticketType->name }}</p>
                    </div>
                    <span class="event-list-tickets">{{ $checkin->checked_in_at?->format('g:i A') }}</span>
                </div>
            @empty
                <div class="empty-state">No check-ins recorded yet</div>
            @endforelse
        </div>
    </div>

    <!-- Right column -->
    <div>
        <!-- Ticket Status Breakdown -->
        <div class="panel" style="margin-bottom: 1.5rem;">
            <div class="panel-header">
                <h3>Ticket Status Breakdown</h3>
            </div>
            <div class="panel-body">
                <div class="status-bars">
                    @php
                        $total = max($statusBreakdown->sum(), 1);
                    @endphp
                    @foreach(['confirmed' => 'Confirmed', 'checked_in' => 'Checked In', 'cancelled' => 'Cancelled', 'reserved' => 'Reserved'] as $key => $label)
                        <div class="status-bar-item">
                            <div class="status-bar-label">
                                <span>{{ $label }}</span>
                                <span class="count">{{ $statusBreakdown[$key] ?? 0 }}</span>
                            </div>
                            <div class="status-bar-track">
                                <div class="status-bar-fill {{ str_replace('_', '-', $key) }}" style="width: {{ (($statusBreakdown[$key] ?? 0) / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Events List -->
        <div class="panel">
            <div class="panel-header">
                <h3>Events</h3>
            </div>
            <div class="panel-body">
                @forelse($events as $event)
                    <div class="event-list-item">
                        <div class="event-list-date">
                            <span class="day">{{ $event->event_date->format('d') }}</span>
                            <span class="month">{{ $event->event_date->format('M') }}</span>
                        </div>
                        <div class="event-list-info">
                            <h4>{{ $event->title }}</h4>
                            <p>{{ $event->location }}</p>
                        </div>
                        <span class="event-list-tickets">{{ $event->tickets_count }} tix</span>
                    </div>
                @empty
                    <div class="empty-state">No events created yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
