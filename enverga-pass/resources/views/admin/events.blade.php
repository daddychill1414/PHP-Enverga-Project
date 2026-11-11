@extends('layouts.admin')

@section('title', 'Event Management')
@section('page-title', 'Event Management')
@section('page-subtitle', 'Create new events, configure ticket tiers, and view event capacity')

@section('topbar-actions')
    <button onclick="document.getElementById('createEventModal').style.display='flex'" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Create New Event
    </button>
@endsection

@section('styles')
<style>
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.25rem;
    }

    .event-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .event-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .event-card-img {
        height: 140px;
        width: 100%;
        object-fit: cover;
        background: #2a0000;
    }

    .event-card-body {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .event-meta-tag {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--crimson);
        margin-bottom: 0.35rem;
    }

    .event-card-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .event-card-desc {
        font-size: 0.75rem;
        color: var(--text-muted);
        line-height: 1.4;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .event-tier-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        background: #f3f4f6;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-right: 0.35rem;
        margin-bottom: 0.35rem;
    }

    .event-tier-pill span.price {
        color: var(--crimson);
        font-family: 'JetBrains Mono', monospace;
    }

    .event-card-footer {
        padding: 0.85rem 1.25rem;
        border-top: 1px solid var(--border);
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Modal */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 100;
        padding: 1rem;
    }

    .modal-box {
        background: white;
        border-radius: 16px;
        max-width: 650px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        padding: 1.75rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 0.85rem;
    }

    .form-group {
        margin-bottom: 0.85rem;
    }

    .form-group label {
        display: block;
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.35rem;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.55rem 0.75rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: inherit;
        font-size: 0.8rem;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--crimson);
        outline: none;
    }

    .tier-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 0.5rem;
        align-items: center;
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('content')

@if(session('success'))
    <div style="background: var(--success-bg); border: 1px solid var(--success-border); color: var(--success); padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600; margin-bottom: 1.25rem;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background: var(--error-bg); border: 1px solid var(--error-border); color: var(--error); padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600; margin-bottom: 1.25rem;">
        {{ $errors->first() }}
    </div>
@endif

<div class="events-grid">
    @forelse($events as $event)
        <div class="event-card">
            <img src="{{ $event->banner_image ?: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $event->title }}" class="event-card-img">
            <div class="event-card-body">
                <span class="event-meta-tag">{{ $event->category }} • {{ $event->event_date->format('M d, Y • g:i A') }}</span>
                <h3 class="event-card-title">{{ $event->title }}</h3>
                <p class="event-card-desc">{{ $event->description }}</p>

                <div style="margin-bottom: 0.75rem;">
                    <div style="font-size: 0.65rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.35rem;">Ticket Tiers &amp; Pricing</div>
                    <div>
                        @foreach($event->ticketTypes as $tier)
                            <div class="event-tier-pill">
                                <span>{{ $tier->name }}:</span>
                                <span class="price">{{ $tier->price == 0 ? 'FREE' : '₱' . number_format($tier->price, 2) }}</span>
                                <span style="font-size: 0.65rem; color: #888;">({{ $tier->remaining }}/{{ $tier->quota }})</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: auto;">
                    <strong>Location:</strong> {{ $event->location }}<br>
                    <strong>Clearance Required:</strong> {{ $event->requires_tuition_clearance ? 'Yes (Strict)' : 'No (Open)' }}
                </div>
            </div>

            <div class="event-card-footer">
                <span class="mono" style="font-size: 0.75rem; color: var(--crimson); font-weight: 700;">
                    {{ $event->tickets_count }} Tickets Issued
                </span>

                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="btn btn-outline" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">
                        View Page
                    </a>
                    <form method="POST" action="{{ route('admin.events.delete', $event->id) }}" onsubmit="return confirm('Are you sure you want to remove this event?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; background: white; border: 1px dashed var(--border); border-radius: 14px; padding: 3rem; text-align: center;">
            <h3 style="font-size: 1rem; font-weight: 800; margin-bottom: 0.5rem;">No Events Created Yet</h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.25rem;">Create your first official MSEUF event to start issuing digital passes.</p>
            <button onclick="document.getElementById('createEventModal').style.display='flex'" class="btn btn-primary">
                + Add First Event
            </button>
        </div>
    @endforelse
</div>

<!-- Create Event Modal -->
<div class="modal-backdrop" id="createEventModal">
    <div class="modal-box">
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 1rem; margin-bottom: 1.25rem;">
            <h2 style="font-size: 1.1rem; font-weight: 900; color: var(--crimson);">Create New MSEUF Event</h2>
            <button onclick="document.getElementById('createEventModal').style.display='none'" style="background: none; border: none; font-size: 1.4rem; cursor: pointer;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Event Title *</label>
                <input type="text" name="title" required class="form-input" placeholder="e.g. MSEUF University Foundation Week 2026: Grand Concert">
            </div>

            <div class="form-group">
                <label>Event Description *</label>
                <textarea name="description" rows="3" required class="form-textarea" placeholder="Detailed description of the event, itinerary, and guest guidelines..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Event Date &amp; Time *</label>
                    <input type="datetime-local" name="event_date" required class="form-input">
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" id="eventCategorySelect" required class="form-select" onchange="toggleCustomCategory(this.value)">
                        <option value="University Festival">University Festival</option>
                        <option value="Academic & Tech">Academic &amp; Tech</option>
                        <option value="Sports & Athletics">Sports &amp; Athletics</option>
                        <option value="Concert & Cultural">Concert &amp; Cultural</option>
                        <option value="Student Orientation">Student Orientation</option>
                        <option value="Others">Others (Custom Category)</option>
                    </select>
                </div>
            </div>

            <div class="form-group" id="customCategoryGroup" style="display: none;">
                <label>Custom Category Name *</label>
                <input type="text" name="custom_category" id="customCategoryInput" class="form-input" placeholder="e.g. Leadership Workshop, Seminar, Alumni Meet">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Venue / Location *</label>
                    <input type="text" name="location" required class="form-input" placeholder="e.g. MSEUF Gymnasium / AEC Little Theater">
                </div>
                <div class="form-group">
                    <label>Organizer *</label>
                    <input type="text" name="organizer" required class="form-input" placeholder="e.g. Supreme Student Council (SSC) &amp; CCMS">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Total Venue Capacity *</label>
                    <input type="number" name="total_capacity" value="500" min="1" required class="form-input">
                </div>
                <div class="form-group">
                    <label>Upload Event Picture / Banner</label>
                    <input type="file" name="banner_file" id="bannerFileInput" accept="image/*" class="form-input" onchange="previewEventImage(this)">
                    <small style="font-size: 0.7rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">
                        Recommended: PNG, JPG, or WEBP (Max 5MB)
                    </small>
                </div>
            </div>

            <!-- Optional Image URL fallback & Preview -->
            <div class="form-group">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Or paste an Image URL (Optional fallback)</label>
                <input type="url" name="banner_image" id="bannerImageUrlInput" class="form-input" placeholder="https://images.unsplash.com/..." oninput="previewUrlImage(this.value)">
                
                <div id="imagePreviewContainer" style="display: none; margin-top: 0.75rem; border-radius: 8px; overflow: hidden; border: 1px solid var(--border); max-height: 160px; position: relative;">
                    <img id="imagePreview" src="" alt="Banner Preview" style="width: 100%; height: 160px; object-fit: cover;">
                    <button type="button" onclick="clearImagePreview()" style="position: absolute; top: 8px; right: 8px; background: rgba(0,0,0,0.7); color: white; border: none; border-radius: 4px; padding: 0.2rem 0.5rem; font-size: 0.7rem; cursor: pointer;">Remove</button>
                </div>
            </div>

            <div class="form-row" style="background: #fafafa; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border);">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 700; cursor: pointer;">
                    <input type="checkbox" name="requires_tuition_clearance" value="1" checked>
                    Require Student Tuition Clearance (Financial gate)
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 700; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" checked>
                    Feature in Homepage Hero Carousel
                </label>
            </div>

            <!-- Ticket Tiers Config -->
            <div style="margin-top: 1.25rem; border-top: 1px solid var(--border); pt-3;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                    <label style="font-weight: 800; font-size: 0.75rem; color: var(--crimson); text-transform: uppercase;">
                        Ticket Pass Tiers &amp; Pricing *
                    </label>
                    <button type="button" onclick="addTierRow()" style="background: none; border: 1px solid var(--crimson); color: var(--crimson); padding: 0.2rem 0.6rem; border-radius: 6px; font-size: 0.7rem; font-weight: 700; cursor: pointer;">
                        + Add Another Tier
                    </button>
                </div>

                <div id="tiersContainer">
                    <div class="tier-row">
                        <input type="text" name="ticket_name[]" value="Student Free Pass (Clearance Required)" required class="form-input" placeholder="Tier Name (e.g. Student Pass)">
                        <input type="number" step="0.01" name="ticket_price[]" value="0.00" min="0" required class="form-input" placeholder="Price (PHP)">
                        <input type="number" name="ticket_quota[]" value="500" min="1" required class="form-input" placeholder="Quota">
                        <span style="font-size: 0.8rem; color: #aaa;">Default</span>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; border-top: 1px solid var(--border); padding-top: 1rem;">
                <button type="button" onclick="document.getElementById('createEventModal').style.display='none'" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Save &amp; Publish Event</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewEventImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUrlImage(url) {
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');
        const fileInput = document.getElementById('bannerFileInput');
        if (fileInput.files && fileInput.files.length > 0) return; // Don't override uploaded file preview

        if (url && url.trim().length > 0) {
            preview.src = url;
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }

    function clearImagePreview() {
        document.getElementById('bannerFileInput').value = '';
        document.getElementById('bannerImageUrlInput').value = '';
        document.getElementById('imagePreview').src = '';
        document.getElementById('imagePreviewContainer').style.display = 'none';
    }

    function toggleCustomCategory(value) {
        const customGroup = document.getElementById('customCategoryGroup');
        const customInput = document.getElementById('customCategoryInput');
        if (value === 'Others') {
            customGroup.style.display = 'block';
            customInput.required = true;
            customInput.focus();
        } else {
            customGroup.style.display = 'none';
            customInput.required = false;
            customInput.value = '';
        }
    }

    function addTierRow() {
        const container = document.getElementById('tiersContainer');
        const div = document.createElement('div');
        div.className = 'tier-row';
        div.innerHTML = `
            <input type="text" name="ticket_name[]" required class="form-input" placeholder="Tier Name (e.g. VIP Front Stage)">
            <input type="number" step="0.01" name="ticket_price[]" value="100.00" min="0" required class="form-input" placeholder="Price (PHP)">
            <input type="number" name="ticket_quota[]" value="100" min="1" required class="form-input" placeholder="Quota">
            <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:var(--error); font-weight:bold; cursor:pointer;">&times;</button>
        `;
        container.appendChild(div);
    }
</script>

@endsection
