# 🎓 Enverga Pass — Admin Panel Implementation Plan
## QR Code Verification Gate & Payment Management

---

> **Innovation Focus:** A **real-time QR Gate Scanner** — an admin-facing page that acts as a live event entrance gate. The admin (SSC officer or guard) opens the page on a tablet/phone at the venue door, scans a student's QR code with the device camera, and instantly sees verification status + payment confirmation. One scan = one check-in. Simple, fast, university-practical.

---

## 📊 What Already Exists

| Layer | Status |
|---|---|
| **Tickets** table with `qr_code_hash`, `status` (reserved/confirmed/checked_in/cancelled), `checked_in_at` | ✅ Ready |
| **Payments** table with `status` (pending/completed/failed/refunded), `reference_number` | ✅ Ready |
| **`/api/verify-ticket?hash=`** endpoint (returns ticket JSON) | ✅ Ready |
| **QR codes** generated via external API on ticket show page | ✅ Ready |
| **Users** table (standard Laravel auth, no `role` column yet) | ⚠️ Needs `role` |
| **AdminController** | ⚠️ Empty shell |
| **Admin routes, views, middleware** | ❌ Missing |

---

## 🏗️ The Plan — 7 Phases

### Phase 1: Database — Add Admin Role to Users
**What:** Add an `is_admin` boolean column to the `users` table so we can gate admin pages.

**Files to create/modify:**
- `database/migrations/xxxx_add_is_admin_to_users_table.php` — new migration adding `is_admin` boolean (default `false`)
- `app/Models/User.php` — add `is_admin` to fillable/casts

**Why `is_admin` boolean instead of a full roles system:** This is a university event app, not a SaaS. You only need two levels: regular users and admin (SSC officers). A boolean keeps it dead simple and avoids over-engineering.

---

### Phase 2: Authentication — Admin Login
**What:** Set up basic login/logout so admins can authenticate. No registration page — admin accounts are seeded or created via `tinker`.

**Files to create/modify:**
- `app/Http/Controllers/Auth/LoginController.php` — handle login form, authenticate, redirect to admin dashboard
- `resources/views/auth/login.blade.php` — clean login page (MSEUF branding, crimson/gold theme matching existing design)
- `routes/web.php` — add `GET /admin/login`, `POST /admin/login`, `POST /admin/logout`
- `database/seeders/AdminSeeder.php` — seed a default admin account (e.g., `admin@mseuf.edu.ph` / `password`)

---

### Phase 3: Admin Middleware
**What:** Create middleware that checks `auth` + `is_admin` so only admins can access `/admin/*` routes.

**Files to create/modify:**
- `app/Http/Middleware/AdminMiddleware.php` — check `auth()->check() && auth()->user()->is_admin`, redirect to login otherwise
- `bootstrap/app.php` — register the middleware alias

---

### Phase 4: Admin Dashboard (Home Page)
**What:** A summary dashboard showing event stats at a glance.

**What it shows:**
- Total tickets issued (all events)
- Total checked-in today
- Total revenue collected
- Tickets by status breakdown (confirmed / checked_in / cancelled)
- Recent 10 check-ins (live feed style)
- Quick link buttons to "Scan QR" and "Manage Payments"

**Files to create/modify:**
- `app/Http/Controllers/AdminController.php` — `dashboard()` method with stats queries
- `resources/views/admin/dashboard.blade.php` — the dashboard view
- `resources/views/layouts/admin.blade.php` — admin layout (sidebar nav, MSEUF branding)
- `routes/web.php` — `GET /admin` → dashboard

---

### Phase 5: QR Code Scanner & Verification Gate ⭐ (Core Feature)
**What:** A live camera-based QR scanner page. The admin points their device at a student's QR code → the system decodes it → verifies the ticket → shows status → allows check-in.

**How it works:**
1. Page loads with a live camera feed using **[html5-qrcode](https://github.com/mebjas/html5-qrcode)** JS library (CDN, no npm needed)
2. Camera decodes the QR → extracts the verification URL containing the `hash`
3. JS sends an AJAX request to a new admin verification endpoint
4. Backend checks:
   - ✅ Is the ticket valid? (hash exists)
   - ✅ Is payment completed?
   - ✅ Is the ticket already checked in? (prevent double entry)
   - ✅ Is this the right event? (admin selects active event)
5. Returns a clear **APPROVED** (green) or **DENIED** (red) response with details
6. If approved → admin clicks "Check In" → backend updates `status` → `checked_in`, sets `checked_in_at`
7. Audio feedback: success beep or error buzz (using Web Audio API)

**Files to create/modify:**
- `app/Http/Controllers/AdminController.php` — add methods:
  - `scanner()` — return the scanner view
  - `verifyAndCheckIn(Request $request)` — verify hash + perform check-in (AJAX endpoint)
- `resources/views/admin/scanner.blade.php` — the scanner page with:
  - Camera feed area
  - Event selector dropdown (which event are you scanning for?)
  - Result display area (student name, ID, ticket type, payment status)
  - Check-in confirmation button
  - Recent scans log (last 10, live updated)
- `routes/web.php` — add:
  - `GET /admin/scanner` → scanner page
  - `POST /admin/scanner/verify` → AJAX verify + check-in endpoint

**UI/UX Details:**
- Full-screen scanner mode for tablets
- Large, bold APPROVED/DENIED feedback (impossible to miss)
- Student photo placeholder with name + ID displayed prominently
- Sound effects for scan results
- Running count: "47 / 500 checked in"

---

### Phase 6: Payment Management
**What:** A table view where admins can see all payments, filter by status, and manually update payment status (e.g., mark an over-the-counter payment as `completed`, or issue a `refund`).

**Files to create/modify:**
- `app/Http/Controllers/AdminController.php` — add methods:
  - `payments()` — list all payments with filters
  - `updatePaymentStatus(Request $request, $id)` — update payment status
- `resources/views/admin/payments.blade.php` — payments table with:
  - Search by reference number, student name, or student ID
  - Filter by status (pending / completed / failed / refunded)
  - Filter by payment method (GCash / Maya / Over-The-Counter / Cashier)
  - Filter by event
  - Each row shows: reference #, student name, student ID, event, amount, method, status, paid_at
  - Action buttons: "Mark Completed", "Mark Refunded" (with confirmation modal)
- `routes/web.php` — add:
  - `GET /admin/payments` → payments list
  - `PATCH /admin/payments/{id}/status` → update payment status

---

### Phase 7: Ticket Management (Attendance List)
**What:** A simple attendee list per event, showing who bought tickets and who checked in.

**Files to create/modify:**
- `app/Http/Controllers/AdminController.php` — add method:
  - `tickets()` — list all tickets with filters
- `resources/views/admin/tickets.blade.php` — tickets table with:
  - Filter by event
  - Filter by status (confirmed / checked_in / cancelled)
  - Search by name or student ID
  - Each row: ticket #, student name, student ID, event, tier, status, checked_in_at
  - Action: manually cancel a ticket
- `routes/web.php` — add:
  - `GET /admin/tickets` → tickets list
  - `PATCH /admin/tickets/{id}/cancel` → cancel a ticket

---

## 📁 Full File Summary

### New Files to Create (13 files)
```
database/migrations/xxxx_add_is_admin_to_users_table.php
database/seeders/AdminSeeder.php
app/Http/Middleware/AdminMiddleware.php
app/Http/Controllers/Auth/LoginController.php
resources/views/auth/login.blade.php
resources/views/layouts/admin.blade.php
resources/views/admin/dashboard.blade.php
resources/views/admin/scanner.blade.php
resources/views/admin/payments.blade.php
resources/views/admin/tickets.blade.php
```

### Existing Files to Modify (4 files)
```
app/Models/User.php                    → add is_admin
app/Http/Controllers/AdminController.php → all admin logic
bootstrap/app.php                      → register middleware
routes/web.php                         → all admin routes
```

---

## 🛣️ Route Map (Final)

| Method | URI | Controller | Purpose |
|--------|-----|------------|---------|
| `GET` | `/admin/login` | LoginController@showLogin | Login form |
| `POST` | `/admin/login` | LoginController@login | Authenticate |
| `POST` | `/admin/logout` | LoginController@logout | Logout |
| `GET` | `/admin` | AdminController@dashboard | Dashboard |
| `GET` | `/admin/scanner` | AdminController@scanner | QR Scanner page |
| `POST` | `/admin/scanner/verify` | AdminController@verifyAndCheckIn | AJAX verify |
| `GET` | `/admin/payments` | AdminController@payments | Payments list |
| `PATCH` | `/admin/payments/{id}/status` | AdminController@updatePaymentStatus | Update payment |
| `GET` | `/admin/tickets` | AdminController@tickets | Tickets list |
| `PATCH` | `/admin/tickets/{id}/cancel` | AdminController@cancelTicket | Cancel ticket |

---

## ⚡ Build Order (Recommended)

```
Phase 1 → Phase 2 → Phase 3 → Phase 5 → Phase 4 → Phase 6 → Phase 7
  DB        Auth      Guard     SCANNER    Dashboard  Payments  Tickets
  (5 min)   (20 min)  (10 min)  (45 min)   (30 min)   (30 min)  (20 min)
```

> **Phase 5 (Scanner) before Phase 4 (Dashboard)** because the scanner is the core feature and the dashboard stats depend on check-in data existing.

---

## 🎯 Why This Innovation Fits Enverga

- **Real problem:** MSEUF events currently use paper-based check-in or manual ID checking — slow, error-prone, no attendance data
- **Practical:** Works on any phone/tablet with a camera — no special hardware needed
- **Fast:** Scan → verify → check-in in under 2 seconds
- **Prevents fraud:** QR hash verification + duplicate check-in prevention
- **Data-driven:** Dashboard gives SSC officers real-time attendance numbers for reporting to the Office of Student Affairs
- **Payment transparency:** Admins can track which students have actually paid vs. pending — critical for over-the-counter payments that need manual confirmation
