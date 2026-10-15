<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — MSEUF Enverga Pass</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --crimson: #730000;
            --crimson-dark: #5a0000;
            --crimson-light: #8b1a1a;
            --gold: #D4AF37;
            --gold-light: #f0e2a0;
            --bg: #f3f4f6;
            --sidebar-bg: #111111;
            --card-bg: #ffffff;
            --text-dark: #111827;
            --text-muted: #6b7280;
            --text-light: #9ca3af;
            --border: #e5e7eb;
            --success: #059669;
            --success-bg: #ecfdf5;
            --success-border: #a7f3d0;
            --error: #dc2626;
            --error-bg: #fef2f2;
            --error-border: #fecaca;
            --warning: #d97706;
            --warning-bg: #fffbeb;
            --warning-border: #fde68a;
            --info: #2563eb;
            --info-bg: #eff6ff;
            --info-border: #bfdbfe;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 50;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-header {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .sidebar-logo {
            width: 36px;
            height: 36px;
            background: var(--crimson);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-logo svg {
            width: 18px;
            height: 18px;
            fill: white;
        }

        .sidebar-brand-text h2 {
            font-size: 0.85rem;
            font-weight: 900;
            color: white;
            letter-spacing: -0.02em;
        }

        .sidebar-brand-text p {
            font-size: 0.6rem;
            color: rgba(255,255,255,0.4);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .nav-section-label {
            font-size: 0.6rem;
            font-weight: 800;
            color: rgba(255,255,255,0.25);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0.75rem 0.5rem 0.35rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.55);
            transition: all 0.15s;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.9);
        }

        .nav-link.active {
            background: var(--crimson);
            color: white;
            box-shadow: 0 2px 8px rgba(115, 0, 0, 0.3);
        }

        .nav-link svg {
            width: 18px;
            height: 18px;
            opacity: 0.7;
            flex-shrink: 0;
        }

        .nav-link.active svg {
            opacity: 1;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--crimson);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 900;
            color: white;
        }

        .user-meta h4 {
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
        }

        .user-meta p {
            font-size: 0.6rem;
            color: rgba(255,255,255,0.4);
            font-weight: 500;
        }

        .logout-btn {
            display: block;
            width: 100%;
            margin-top: 0.75rem;
            padding: 0.45rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 6px;
            color: rgba(255,255,255,0.5);
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
            text-align: center;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: rgba(220, 38, 38, 0.15);
            border-color: rgba(220, 38, 38, 0.3);
            color: #fca5a5;
        }

        /* ── Main Content ── */
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            background: rgba(243, 244, 246, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 40;
        }

        .topbar-title h1 {
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--text-dark);
            letter-spacing: -0.02em;
        }

        .topbar-title p {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 0.1rem;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-content {
            padding: 2rem;
        }

        /* ── Mobile toggle ── */
        .mobile-toggle {
            display: none;
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            width: 48px;
            height: 48px;
            background: var(--crimson);
            border: none;
            border-radius: 14px;
            color: white;
            cursor: pointer;
            z-index: 60;
            box-shadow: 0 4px 14px rgba(115, 0, 0, 0.3);
            align-items: center;
            justify-content: center;
        }

        .mobile-toggle svg {
            width: 22px;
            height: 22px;
            fill: white;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 45;
        }

        /* ── Utility classes ── */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .stat-card .stat-label {
            font-size: 0.65rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--text-dark);
            margin-top: 0.25rem;
            letter-spacing: -0.03em;
            font-family: 'JetBrains Mono', monospace;
        }

        .stat-card .stat-sub {
            font-size: 0.7rem;
            color: var(--text-light);
            font-weight: 600;
            margin-top: 0.2rem;
        }

        .badge {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .badge-success { background: var(--success-bg); color: var(--success); border: 1px solid var(--success-border); }
        .badge-error { background: var(--error-bg); color: var(--error); border: 1px solid var(--error-border); }
        .badge-warning { background: var(--warning-bg); color: var(--warning); border: 1px solid var(--warning-border); }
        .badge-info { background: var(--info-bg); color: var(--info); border: 1px solid var(--info-border); }
        .badge-neutral { background: #f3f4f6; color: var(--text-muted); border: 1px solid var(--border); }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--crimson);
            color: white;
            box-shadow: 0 2px 6px rgba(115, 0, 0, 0.15);
        }

        .btn-primary:hover {
            background: var(--crimson-dark);
            box-shadow: 0 4px 12px rgba(115, 0, 0, 0.25);
        }

        .btn-outline {
            background: white;
            color: var(--text-dark);
            border: 1.5px solid var(--border);
        }

        .btn-outline:hover {
            border-color: #d1d5db;
            background: #f9fafb;
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--error);
            color: white;
        }

        .btn svg {
            width: 16px;
            height: 16px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead th {
            text-align: left;
            font-size: 0.65rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
        }

        .data-table tbody td {
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border);
        }

        .data-table tbody tr:hover {
            background: #f9fafb;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }

            .mobile-toggle {
                display: flex;
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                padding: 1rem 1.25rem;
            }

            .page-content {
                padding: 1.25rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Mobile overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <div class="sidebar-logo">
                    <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-1 6h2v2h-2V7zm0 4h2v6h-2v-6z"/></svg>
                </div>
                <div class="sidebar-brand-text">
                    <h2>Enverga Pass</h2>
                    <p>Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section-label">Overview</span>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            <span class="nav-section-label">Operations</span>
            <a href="{{ route('admin.scanner') }}" class="nav-link {{ request()->routeIs('admin.scanner') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="17" y2="12"/><line x1="7" y1="16" x2="13" y2="16"/></svg>
                QR Scanner
            </a>
            <a href="{{ route('admin.payments') }}" class="nav-link {{ request()->routeIs('admin.payments') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Payments
            </a>
            <a href="{{ route('admin.tickets') }}" class="nav-link {{ request()->routeIs('admin.tickets') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h6a2 2 0 0 1 2 2v6"/><path d="M22 12h-6a2 2 0 0 0-2 2v6"/><path d="M12 2v6a2 2 0 0 1-2 2H4"/><path d="M12 2v6a2 2 0 0 0 2 2h6"/></svg>
                Tickets
            </a>
            <a href="{{ route('admin.events') }}" class="nav-link {{ request()->routeIs('admin.events') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Manage Events
            </a>

            <span class="nav-section-label">Quick Links</span>
            <a href="{{ route('events.index') }}" class="nav-link" target="_blank">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Public Site
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="user-meta">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Sign Out</button>
            </form>
        </div>
    </aside>

    <!-- Mobile toggle -->
    <button class="mobile-toggle" onclick="toggleSidebar()">
        <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
    </button>

    <!-- Main -->
    <main class="main-content">
        <div class="topbar">
            <div class="topbar-title">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', 'MSEUF Event Management')</p>
            </div>
            <div class="topbar-actions">
                @yield('topbar-actions')
            </div>
        </div>

        <div class="page-content">
            @yield('content')
        </div>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }
    </script>
    @yield('scripts')
</body>
</html>
