@extends('layouts.admin')

@section('title', 'Payment Management')
@section('page-title', 'Payments')
@section('page-subtitle', 'Track and manage all ticket payments')

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

    .action-btn.complete {
        border-color: var(--success-border);
        color: var(--success);
    }

    .action-btn.complete:hover {
        background: var(--success-bg);
    }

    .action-btn.refund {
        border-color: var(--warning-border);
        color: var(--warning);
    }

    .action-btn.refund:hover {
        background: var(--warning-bg);
    }

    .actions-cell {
        display: flex;
        gap: 0.35rem;
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

    /* Confirmation modal */
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
<form method="GET" action="{{ route('admin.payments') }}" class="filters-bar">
    <div class="filter-group">
        <label>Search</label>
        <input type="text" name="search" placeholder="Ref #, name, or ID" value="{{ request('search') }}">
    </div>
    <div class="filter-group">
        <label>Status</label>
        <select name="status">
            <option value="">All</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
            <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Method</label>
        <select name="method">
            <option value="">All</option>
            <option value="GCash" {{ request('method') === 'GCash' ? 'selected' : '' }}>GCash</option>
            <option value="Maya" {{ request('method') === 'Maya' ? 'selected' : '' }}>Maya</option>
            <option value="Over-The-Counter" {{ request('method') === 'Over-The-Counter' ? 'selected' : '' }}>Over-The-Counter</option>
            <option value="Cashier" {{ request('method') === 'Cashier' ? 'selected' : '' }}>Cashier</option>
        </select>
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
                    <th>Reference #</th>
                    <th>Student</th>
                    <th>Student ID</th>
                    <th>Event</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td><span class="mono">{{ $payment->reference_number }}</span></td>
                        <td style="font-weight:700;">{{ $payment->ticket->attendee_name }}</td>
                        <td><span class="mono">{{ $payment->ticket->student_id }}</span></td>
                        <td>{{ $payment->ticket->event->title }}</td>
                        <td><span class="mono">₱{{ number_format($payment->amount, 2) }}</span></td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>
                            @switch($payment->status)
                                @case('completed')
                                    <span class="badge badge-success">Completed</span>
                                    @break
                                @case('pending')
                                    <span class="badge badge-warning">Pending</span>
                                    @break
                                @case('failed')
                                    <span class="badge badge-error">Failed</span>
                                    @break
                                @case('refunded')
                                    <span class="badge badge-info">Refunded</span>
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $payment->paid_at?->format('M d, g:i A') ?? '—' }}</td>
                        <td>
                            <div class="actions-cell">
                                @if($payment->status === 'pending')
                                    <button class="action-btn complete" onclick="confirmAction({{ $payment->id }}, 'completed', '{{ $payment->reference_number }}')">✓ Complete</button>
                                @endif
                                @if($payment->status === 'completed')
                                    <button class="action-btn refund" onclick="confirmAction({{ $payment->id }}, 'refunded', '{{ $payment->reference_number }}')">↩ Refund</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:2rem; color:var(--text-light);">No payments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
        <div class="pagination-bar">
            <span class="info">Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }}</span>
            <div class="pagination-links">
                @if($payments->onFirstPage())
                    <span>←</span>
                @else
                    <a href="{{ $payments->previousPageUrl() }}">←</a>
                @endif

                @foreach($payments->getUrlRange(max(1, $payments->currentPage()-2), min($payments->lastPage(), $payments->currentPage()+2)) as $page => $url)
                    @if($page == $payments->currentPage())
                        <span class="current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($payments->hasMorePages())
                    <a href="{{ $payments->nextPageUrl() }}">→</a>
                @else
                    <span>→</span>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Confirmation Modal -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <h3 id="modalTitle">Confirm Action</h3>
        <p id="modalMessage">Are you sure?</p>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeModal()">Cancel</button>
            <form id="modalForm" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" id="modalStatus">
                <button type="submit" class="btn btn-primary" id="modalSubmit">Confirm</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmAction(paymentId, newStatus, refNumber) {
        const modal = document.getElementById('confirmModal');
        const form = document.getElementById('modalForm');
        const title = document.getElementById('modalTitle');
        const message = document.getElementById('modalMessage');
        const statusInput = document.getElementById('modalStatus');
        const submitBtn = document.getElementById('modalSubmit');

        form.action = `/admin/payments/${paymentId}/status`;
        statusInput.value = newStatus;

        if (newStatus === 'completed') {
            title.textContent = 'Mark as Completed';
            message.textContent = `Confirm that payment ${refNumber} has been received?`;
            submitBtn.className = 'btn btn-success';
            submitBtn.textContent = '✓ Mark Completed';
        } else if (newStatus === 'refunded') {
            title.textContent = 'Issue Refund';
            message.textContent = `Are you sure you want to mark ${refNumber} as refunded? This should reflect an actual refund processed.`;
            submitBtn.className = 'btn btn-danger';
            submitBtn.textContent = '↩ Confirm Refund';
        }

        modal.classList.add('open');
    }

    function closeModal() {
        document.getElementById('confirmModal').classList.remove('open');
    }

    // Close on overlay click
    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection
