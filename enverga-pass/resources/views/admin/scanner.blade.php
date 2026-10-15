@extends('layouts.admin')

@section('title', 'QR Gate Scanner')
@section('page-title', 'QR Gate Scanner')
@section('page-subtitle', 'Scan student QR codes to verify and check in')

@section('styles')
<style>
    .scanner-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    /* ── Scanner Panel ── */
    .scanner-panel {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .scanner-panel-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .scanner-panel-header h3 {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    .scanner-panel-body {
        padding: 1.25rem;
    }

    .event-selector {
        margin-bottom: 1rem;
    }

    .event-selector label {
        display: block;
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.4rem;
    }

    .event-selector select {
        width: 100%;
        padding: 0.55rem 0.75rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-dark);
        background: #fafafa;
        outline: none;
        cursor: pointer;
    }

    .event-selector select:focus {
        border-color: var(--crimson);
    }

    /* Camera viewport */
    .camera-viewport {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / 1;
        max-height: 380px;
        background: #0a0a0a;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid var(--border);
    }

    .camera-viewport #qr-reader {
        width: 100% !important;
        height: 100% !important;
    }

    .camera-viewport #qr-reader video {
        border-radius: 10px;
        object-fit: cover;
    }

    .camera-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: rgba(255,255,255,0.4);
        text-align: center;
        gap: 0.75rem;
    }

    .camera-placeholder svg {
        width: 48px;
        height: 48px;
    }

    .camera-placeholder p {
        font-size: 0.8rem;
        font-weight: 600;
    }

    .scanner-controls {
        margin-top: 1rem;
        display: flex;
        gap: 0.5rem;
    }

    .scanner-controls .btn {
        flex: 1;
        justify-content: center;
        padding: 0.6rem;
    }

    /* ── Manual Entry ── */
    .manual-entry {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }

    .manual-entry label {
        display: block;
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.4rem;
    }

    .manual-entry-row {
        display: flex;
        gap: 0.5rem;
    }

    .manual-entry-row input {
        flex: 1;
        padding: 0.55rem 0.75rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-dark);
        background: #fafafa;
        outline: none;
    }

    .manual-entry-row input:focus {
        border-color: var(--crimson);
    }

    /* ── Result Panel ── */
    .result-panel {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .result-panel-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .result-panel-header h3 {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    .scan-counter {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-muted);
    }

    .scan-counter .dot {
        width: 6px;
        height: 6px;
        background: var(--success);
        border-radius: 50%;
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    .result-panel-body {
        padding: 1.25rem;
    }

    /* Idle state */
    .result-idle {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-light);
    }

    .result-idle svg {
        width: 56px;
        height: 56px;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .result-idle p {
        font-size: 0.85rem;
        font-weight: 600;
    }

    .result-idle small {
        font-size: 0.7rem;
        display: block;
        margin-top: 0.25rem;
        color: var(--text-light);
    }

    /* Scan result */
    .scan-result {
        display: none;
    }

    .scan-result.show {
        display: block;
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .result-status-banner {
        padding: 1.25rem;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 1.25rem;
    }

    .result-status-banner.approved {
        background: var(--success-bg);
        border: 2px solid var(--success-border);
    }

    .result-status-banner.denied {
        background: var(--error-bg);
        border: 2px solid var(--error-border);
    }

    .result-status-banner.already {
        background: var(--warning-bg);
        border: 2px solid var(--warning-border);
    }

    .result-status-banner .status-icon {
        font-size: 2.5rem;
        margin-bottom: 0.25rem;
    }

    .result-status-banner .status-text {
        font-size: 1.1rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .result-status-banner.approved .status-text { color: var(--success); }
    .result-status-banner.denied .status-text { color: var(--error); }
    .result-status-banner.already .status-text { color: var(--warning); }

    .result-status-banner .status-sub {
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 0.15rem;
        color: var(--text-muted);
    }

    /* Attendee info card */
    .attendee-card {
        background: #fafafa;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .attendee-card .attendee-name {
        font-size: 1.15rem;
        font-weight: 900;
        color: var(--text-dark);
        letter-spacing: -0.02em;
    }

    .attendee-card .attendee-id {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--crimson);
        margin-top: 0.15rem;
    }

    .attendee-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border);
    }

    .attendee-meta .meta-item label {
        font-size: 0.6rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        display: block;
    }

    .attendee-meta .meta-item span {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-top: 0.1rem;
        display: block;
    }

    .checkin-btn {
        width: 100%;
        padding: 0.85rem;
        font-size: 0.9rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        justify-content: center;
    }

    /* ── Recent Scans Log ── */
    .recent-scans {
        margin-top: 1.5rem;
    }

    .recent-scans h4 {
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.75rem;
    }

    .scan-log-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid var(--border);
    }

    .scan-log-item:last-child {
        border-bottom: none;
    }

    .scan-log-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .scan-log-dot.success { background: var(--success); }
    .scan-log-dot.error { background: var(--error); }
    .scan-log-dot.warning { background: var(--warning); }

    .scan-log-info {
        flex: 1;
        min-width: 0;
    }

    .scan-log-info .log-name {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--text-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .scan-log-info .log-detail {
        font-size: 0.65rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .scan-log-time {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.65rem;
        color: var(--text-light);
        font-weight: 600;
        flex-shrink: 0;
    }

    .empty-log {
        text-align: center;
        padding: 1.5rem;
        color: var(--text-light);
        font-size: 0.78rem;
        font-weight: 500;
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .scanner-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="scanner-grid">
    <!-- Left: Scanner -->
    <div class="scanner-panel">
        <div class="scanner-panel-header">
            <h3>📷 Camera Scanner</h3>
            <span class="badge badge-success" id="cameraStatus">Ready</span>
        </div>
        <div class="scanner-panel-body">
            <!-- Event selector -->
            <div class="event-selector">
                <label for="eventSelect">Scanning for Event</label>
                <select id="eventSelect">
                    <option value="">— All Events —</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }} ({{ $event->event_date->format('M d, Y') }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Camera viewport -->
            <div class="camera-viewport">
                <div id="qr-reader"></div>
                <div class="camera-placeholder" id="cameraPlaceholder">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="3"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1.5" fill="currentColor"/></svg>
                    <p>Click "Start Scanner" to begin</p>
                </div>
            </div>

            <!-- Controls -->
            <div class="scanner-controls">
                <button class="btn btn-primary" id="startBtn" onclick="startScanner()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Start Scanner
                </button>
                <button class="btn btn-outline" id="stopBtn" onclick="stopScanner()" style="display:none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                    Stop
                </button>
            </div>

            <!-- Manual entry fallback -->
            <div class="manual-entry">
                <label for="manualHash">Manual Ticket Lookup</label>
                <div class="manual-entry-row">
                    <input type="text" id="manualHash" placeholder="Ticket # (e.g., EVG-ABCD-1234)">
                    <button class="btn btn-outline" onclick="manualLookup()">Look Up</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Result -->
    <div>
        <div class="result-panel">
            <div class="result-panel-header">
                <h3>Scan Result</h3>
                <div class="scan-counter">
                    <span class="dot"></span>
                    <span id="checkinCount">{{ $checkedInToday }}</span> / <span>{{ $totalTickets }}</span> checked in
                </div>
            </div>
            <div class="result-panel-body">
                <!-- Idle state -->
                <div class="result-idle" id="resultIdle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="17" y2="12"/><line x1="7" y1="16" x2="13" y2="16"/></svg>
                    <p>Waiting for scan…</p>
                    <small>Point the camera at a student's QR code</small>
                </div>

                <!-- Result display -->
                <div class="scan-result" id="scanResult">
                    <div class="result-status-banner" id="statusBanner">
                        <div class="status-icon" id="statusIcon"></div>
                        <div class="status-text" id="statusText"></div>
                        <div class="status-sub" id="statusSub"></div>
                    </div>

                    <div class="attendee-card" id="attendeeCard" style="display:none;">
                        <div class="attendee-name" id="attendeeName"></div>
                        <div class="attendee-id" id="attendeeStudentId"></div>
                        <div class="attendee-meta">
                            <div class="meta-item">
                                <label>Event</label>
                                <span id="attendeeEvent"></span>
                            </div>
                            <div class="meta-item">
                                <label>Ticket #</label>
                                <span class="mono" id="attendeeTicket"></span>
                            </div>
                            <div class="meta-item">
                                <label>Tier</label>
                                <span id="attendeeTier"></span>
                            </div>
                            <div class="meta-item">
                                <label>Payment</label>
                                <span id="attendeePayment"></span>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-success checkin-btn" id="checkinBtn" style="display:none;" onclick="performCheckIn()">
                        ✅ Confirm Check-In
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent scans log -->
        <div class="recent-scans">
            <h4>Recent Scans</h4>
            <div class="result-panel" style="border-radius: 12px;">
                <div id="scanLog">
                    <div class="empty-log">No scans yet this session</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    let html5QrCode = null;
    let isScanning = false;
    let currentTicketData = null;
    let scanLogEntries = [];

    // Audio context for feedback sounds
    const AudioCtx = window.AudioContext || window.webkitAudioContext;
    let audioCtx = null;

    function playSound(type) {
        if (!audioCtx) audioCtx = new AudioCtx();
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.connect(gain);
        gain.connect(audioCtx.destination);

        if (type === 'success') {
            osc.frequency.setValueAtTime(880, audioCtx.currentTime);
            osc.frequency.setValueAtTime(1100, audioCtx.currentTime + 0.1);
            gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
            osc.start(audioCtx.currentTime);
            osc.stop(audioCtx.currentTime + 0.3);
        } else if (type === 'error') {
            osc.frequency.setValueAtTime(300, audioCtx.currentTime);
            osc.type = 'square';
            gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
            osc.start(audioCtx.currentTime);
            osc.stop(audioCtx.currentTime + 0.5);
        } else if (type === 'warning') {
            osc.frequency.setValueAtTime(600, audioCtx.currentTime);
            osc.frequency.setValueAtTime(400, audioCtx.currentTime + 0.15);
            gain.gain.setValueAtTime(0.25, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.35);
            osc.start(audioCtx.currentTime);
            osc.stop(audioCtx.currentTime + 0.35);
        }
    }

    function startScanner() {
        if (isScanning) return;

        document.getElementById('cameraPlaceholder').style.display = 'none';
        document.getElementById('startBtn').style.display = 'none';
        document.getElementById('stopBtn').style.display = 'flex';
        document.getElementById('cameraStatus').textContent = 'Scanning';
        document.getElementById('cameraStatus').className = 'badge badge-success';

        html5QrCode = new Html5Qrcode("qr-reader");
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 220, height: 220 },
                aspectRatio: 1.0
            },
            onScanSuccess,
            () => {} // ignore scan failures (no QR found in frame)
        ).then(() => {
            isScanning = true;
        }).catch(err => {
            console.error('Camera error:', err);
            document.getElementById('cameraStatus').textContent = 'Camera Error';
            document.getElementById('cameraStatus').className = 'badge badge-error';
            document.getElementById('cameraPlaceholder').style.display = 'flex';
            document.getElementById('cameraPlaceholder').querySelector('p').textContent = 'Camera access denied or unavailable';
            document.getElementById('startBtn').style.display = 'flex';
            document.getElementById('stopBtn').style.display = 'none';
        });
    }

    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => {
                isScanning = false;
                document.getElementById('startBtn').style.display = 'flex';
                document.getElementById('stopBtn').style.display = 'none';
                document.getElementById('cameraStatus').textContent = 'Stopped';
                document.getElementById('cameraStatus').className = 'badge badge-neutral';
            });
        }
    }

    // Debounce scans (prevent rapid-fire from same QR)
    let lastScannedHash = '';
    let lastScanTime = 0;

    function onScanSuccess(decodedText) {
        const now = Date.now();
        if (decodedText === lastScannedHash && (now - lastScanTime) < 5000) {
            return; // Ignore duplicate within 5 seconds
        }
        lastScannedHash = decodedText;
        lastScanTime = now;

        // Extract hash from the scanned URL
        let hash = decodedText;
        try {
            const url = new URL(decodedText);
            hash = url.searchParams.get('hash') || decodedText;
        } catch (e) {
            // Not a URL, use raw text
        }

        verifyTicket(hash);
    }

    function manualLookup() {
        const ticketNumber = document.getElementById('manualHash').value.trim();
        if (!ticketNumber) return;

        verifyTicket(null, ticketNumber);
    }

    function verifyTicket(hash, ticketNumber) {
        const eventId = document.getElementById('eventSelect').value;

        const body = { _token: document.querySelector('meta[name="csrf-token"]').content };
        if (hash) body.hash = hash;
        if (ticketNumber) body.ticket_number = ticketNumber;
        if (eventId) body.event_id = eventId;

        fetch('{{ route("admin.scanner.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify(body),
        })
        .then(res => res.json())
        .then(data => {
            showResult(data);
        })
        .catch(err => {
            console.error('Verify error:', err);
            showResult({ valid: false, message: 'Network error — please try again' });
        });
    }

    function showResult(data) {
        document.getElementById('resultIdle').style.display = 'none';
        const result = document.getElementById('scanResult');
        result.classList.remove('show');
        // Force reflow for re-animation
        void result.offsetWidth;
        result.classList.add('show');

        const banner = document.getElementById('statusBanner');
        const icon = document.getElementById('statusIcon');
        const text = document.getElementById('statusText');
        const sub = document.getElementById('statusSub');
        const card = document.getElementById('attendeeCard');
        const btn = document.getElementById('checkinBtn');

        if (data.valid && data.can_check_in) {
            // APPROVED — ready for check-in
            banner.className = 'result-status-banner approved';
            icon.textContent = 'VALID';
            text.textContent = 'APPROVED';
            sub.textContent = 'Ticket verified — ready for check-in';
            card.style.display = 'block';
            btn.style.display = 'flex';
            currentTicketData = data;
            playSound('success');
        } else if (data.valid && data.already_checked_in) {
            // ALREADY CHECKED IN
            banner.className = 'result-status-banner already';
            icon.textContent = 'ATTENDED';
            text.textContent = 'ALREADY CHECKED IN';
            sub.textContent = 'Checked in at ' + (data.checked_in_at || 'unknown time');
            card.style.display = 'block';
            btn.style.display = 'none';
            currentTicketData = null;
            playSound('warning');
        } else {
            // DENIED
            banner.className = 'result-status-banner denied';
            icon.textContent = 'INVALID';
            text.textContent = 'DENIED';
            sub.textContent = data.message || 'Invalid ticket';
            card.style.display = 'none';
            btn.style.display = 'none';
            currentTicketData = null;
            playSound('error');
        }

        // Populate attendee info if available
        if (data.attendee_name) {
            document.getElementById('attendeeName').textContent = data.attendee_name;
            document.getElementById('attendeeStudentId').textContent = data.student_id || '—';
            document.getElementById('attendeeEvent').textContent = data.event || '—';
            document.getElementById('attendeeTicket').textContent = data.ticket_number || '—';
            document.getElementById('attendeeTier').textContent = data.ticket_type || '—';
            document.getElementById('attendeePayment').textContent = data.payment_status || '—';
        }

        // Log entry
        addScanLog(data);
    }

    function performCheckIn() {
        if (!currentTicketData) return;

        const btn = document.getElementById('checkinBtn');
        btn.disabled = true;
        btn.textContent = 'Processing…';

        fetch('{{ route("admin.scanner.checkin") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                ticket_id: currentTicketData.ticket_id,
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const banner = document.getElementById('statusBanner');
                banner.className = 'result-status-banner approved';
                document.getElementById('statusIcon').textContent = 'CHECKED IN';
                document.getElementById('statusText').textContent = 'CHECKED IN';
                document.getElementById('statusSub').textContent = 'Entry granted at ' + data.checked_in_at;
                btn.style.display = 'none';
                playSound('success');

                // Update counter
                const counter = document.getElementById('checkinCount');
                counter.textContent = parseInt(counter.textContent) + 1;

                // Update log
                updateLastLogEntry('success', 'Checked in');
            } else {
                btn.disabled = false;
                btn.innerHTML = '✅ Confirm Check-In';
                playSound('error');
                alert(data.message || 'Check-in failed');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '✅ Confirm Check-In';
            playSound('error');
            console.error('Check-in error:', err);
        });
    }

    function addScanLog(data) {
        const log = document.getElementById('scanLog');
        const emptyMsg = log.querySelector('.empty-log');
        if (emptyMsg) emptyMsg.remove();

        const time = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        let dotClass = 'error';
        let detail = data.message || 'Invalid';

        if (data.valid && data.can_check_in) {
            dotClass = 'success';
            detail = 'Ready for check-in';
        } else if (data.valid && data.already_checked_in) {
            dotClass = 'warning';
            detail = 'Already checked in';
        }

        const entry = document.createElement('div');
        entry.className = 'scan-log-item';
        entry.id = 'log-' + Date.now();
        entry.innerHTML = `
            <span class="scan-log-dot ${dotClass}"></span>
            <div class="scan-log-info">
                <div class="log-name">${data.attendee_name || 'Unknown'}</div>
                <div class="log-detail">${detail} — ${data.ticket_number || 'N/A'}</div>
            </div>
            <span class="scan-log-time">${time}</span>
        `;

        log.insertBefore(entry, log.firstChild);

        // Keep only last 10
        const items = log.querySelectorAll('.scan-log-item');
        if (items.length > 10) {
            items[items.length - 1].remove();
        }

        scanLogEntries.unshift({ id: entry.id, dotClass, time });
    }

    function updateLastLogEntry(dotClass, detail) {
        if (scanLogEntries.length === 0) return;
        const last = scanLogEntries[0];
        const el = document.getElementById(last.id);
        if (el) {
            el.querySelector('.scan-log-dot').className = 'scan-log-dot ' + dotClass;
            el.querySelector('.log-detail').textContent = detail;
        }
    }
</script>
@endsection
