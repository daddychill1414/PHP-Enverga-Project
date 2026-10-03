# 📋 EnvergaPass — Project Status & TODO List
> **Manuel S. Enverga University Foundation** · Event Ticketing & Digital Pass System

---

## 📊 Overall Completion

```
████████████████████░░░░░░░░░░  ~62% Complete
```

| Layer | Done | Total | % |
|---|---|---|---|
| Database & Migrations | 8 / 8 | 8 | ✅ 100% |
| Models & Relationships | 6 / 6 | 6 | ✅ 100% |
| Seeders / Sample Data | 1 / 1 | 1 | ✅ 100% |
| Core Student-Facing Routes | 5 / 6 | 6 | 🟡 83% |
| Core Student-Facing Views | 4 / 5 | 5 | 🟡 80% |
| Controllers (Student) | 3 / 3 | 3 | ✅ 100% |
| Admin Panel | 0 / 1 | 1 | ❌ 0% |
| Authentication | 0 / 1 | 1 | ❌ 0% |
| QR Scanner / Check-in UI | 0 / 1 | 1 | ❌ 0% |
| Bug Fixes | 0 / 3 | 3 | ❌ 0% |
| Tests | 0 / 5 | 5 | ❌ 0% |
| Email Notifications | 0 / 1 | 1 | ❌ 0% |

---

## ✅ What's Already Done (Solid Foundation)

### Database
- [x] `users` table migration
- [x] `events` table migration (slug, banner, capacity, tuition flag, status)
- [x] `tickets` table migration (ticket number, QR hash, check-in timestamp)
- [x] `ticket_types` table migration (price, quota, remaining)
- [x] `payments` table migration (reference number, amount, method, status)
- [x] `tuition_clearances` table migration (student ID, department, balance, cleared flag)
- [x] `cache` and `jobs` tables (Laravel defaults)

### Models
- [x] `Event` — relationships to `TicketType`, `Ticket`; casts for datetime + booleans
- [x] `Ticket` — relationships to `Event`, `TicketType`, `User`, `Payment`
- [x] `TicketType` — belongs to `Event`
- [x] `Payment` — belongs to `Ticket`
- [x] `TuitionClearance` — belongs to `User`
- [x] `User` — default Laravel model

### Seeder
- [x] 3 seeded MSEUF events with realistic data (Foundation Week, Tech Summit, Sports Fest)
- [x] Ticket types per event (Free pass, VIP, General, Bleacher)
- [x] 2 tuition clearance records (`2022-10482` cleared, `2023-99812` pending)

### Controllers
- [x] `EventController::index()` — lists upcoming events with category & search filter
- [x] `EventController::show()` — event detail page
- [x] `TicketController::checkout()` — shows checkout form (uses `events/show` sidebar form)
- [x] `TicketController::processCheckout()` — tuition check → ticket generation → QR hash → payment record
- [x] `TicketController::show()` — displays digital pass with QR code
- [x] `TicketController::verify()` — JSON API endpoint for QR hash lookup
- [x] `TuitionClearanceController::index()` + `check()` — student balance lookup

### Views (Student-Facing)
- [x] `layouts/app.blade.php` — Full layout with MSEUF branding, sticky navbar, footer, toast alerts
- [x] `events/index.blade.php` — Swiper carousel hero + event cards grid with category filters
- [x] `events/show.blade.php` — Event detail + inline checkout form (registration sidebar)
- [x] `tickets/show.blade.php` — Digital pass with live QR code (via `api.qrserver.com`)
- [x] `clearance/index.blade.php` — Student ID lookup with clearance result card

### Routes
- [x] `GET /` → events listing
- [x] `GET /events/{slug}` → event detail
- [x] `GET /events/{id}/checkout` → checkout (currently mapped to `events/show`)
- [x] `POST /events/{id}/checkout` → process checkout
- [x] `GET /tickets/pass/{ticketNumber}` → digital pass
- [x] `GET /clearance` → clearance checker
- [x] `POST /clearance/check` → search clearance
- [x] `GET /api/verify-ticket?hash=...` → JSON ticket verification

---

## ❌ What Needs To Be Done

### 🔴 CRITICAL — App-Breaking

- [ ] **`tickets/checkout.blade.php` is missing**
  - The route `GET /events/{id}/checkout` calls `view('tickets.checkout')` in the controller, but no such file exists
  - The checkout form is currently embedded inside `events/show.blade.php` as a sidebar, which is a workaround
  - A dedicated checkout page should be created or the route should be cleaned up

- [ ] **Navbar dead links**
  - `SUSTAINABILITY`, `INTERNATIONALIZATION`, `ABOUT` all point to `#` — they do nothing
  - Top utility bar links for `Downloads`, `Careers`, `Library`, `Sites` are all `href="#"`

- [ ] **`tickets/show.blade.php` — "Tuition Status" is hardcoded**
  - Line 66: `Cleared ✓` is hardcoded HTML — it never shows the actual student's tuition status
  - Should dynamically read from the ticket's related clearance record

---

### 🟠 HIGH PRIORITY — Core Missing Features

- [ ] **Admin Panel** — `AdminController` is completely empty
  - [ ] Admin dashboard (stats: total tickets sold, revenue, capacity)
  - [ ] Create / Edit / Delete events
  - [ ] View all issued tickets per event
  - [ ] Upload or manually manage tuition clearance CSV records
  - [ ] Bulk check-in tool

- [ ] **Authentication**
  - [ ] Admin login (`/admin/login`) — only admins should access the admin panel
  - [ ] Route middleware to protect all `/admin/*` routes
  - [ ] Optional: student login to view their own issued passes

- [ ] **Admin Routes** — none exist in `web.php`
  - [ ] `GET /admin` → dashboard
  - [ ] `GET /admin/events` → event list
  - [ ] `GET /admin/events/create` → create event form
  - [ ] `POST /admin/events` → store event
  - [ ] `GET /admin/events/{id}/edit` → edit event
  - [ ] `PUT /admin/events/{id}` → update event
  - [ ] `DELETE /admin/events/{id}` → delete event
  - [ ] `GET /admin/tickets` → all tickets
  - [ ] `POST /admin/tickets/{id}/check-in` → mark ticket as checked-in

---

### 🟡 MEDIUM PRIORITY — Logic Bugs & Gaps

- [ ] **`EventController::index()` search + category scope bug**
  - The `orWhere` on search runs outside the category `where()`, so a search can return events from other categories
  - Fix: wrap the search in a nested closure
  ```php
  // Current (buggy):
  $query->where('title', 'like', "%{$search}%")
        ->orWhere('description', 'like', "%{$search}%");

  // Fixed:
  $query->where(function($q) use ($search) {
      $q->where('title', 'like', "%{$search}%")
        ->orWhere('description', 'like', "%{$search}%");
  });
  ```

- [ ] **No duplicate ticket prevention**
  - A student can register for the same event unlimited times using the same Student ID
  - Should check: `Ticket::where('event_id', $eventId)->where('student_id', $studentId)->exists()`

- [ ] **Ticket check-in is never recorded**
  - `TicketController::verify()` returns ticket info but never updates `checked_in_at` or `status`
  - Should mark ticket as `used` and record `checked_in_at = now()` when scanned

- [ ] **Event status filter in `EventController::index()`**
  - Only shows `upcoming` events — no way to view `ongoing` or `past` events
  - Events don't automatically change status when `event_date` passes

- [ ] **No sold-out guard on `events/show` checkout form**
  - If a ticket type's `remaining` hits 0, the radio button is still shown and clickable
  - Should be visually disabled and marked "SOLD OUT"

---

### 🟢 NICE TO HAVE — Polish & Production Readiness

- [ ] **Email notification after ticket issuance**
  - Send a confirmation email with the digital pass link to `attendee_email`
  - Use Laravel's built-in `Mail::to()->send()` with a `Mailable` class

- [ ] **QR Scanner / Check-in UI page**
  - A dedicated page (`/admin/scan`) for event staff
  - Uses device camera (via JavaScript `jsQR` or `Html5Qrcode`) to scan QR codes
  - Calls `/api/verify-ticket?hash=...` and displays result on screen

- [ ] **`welcome.blade.php` — 72KB dead file**
  - This is the default Laravel welcome page, still sitting in views
  - Should be deleted or replaced with a redirect to `/`

- [ ] **Factories for testing**
  - [ ] `EventFactory.php`
  - [ ] `TicketFactory.php`
  - [ ] `TicketTypeFactory.php`
  - [ ] `TuitionClearanceFactory.php`

- [ ] **Feature Tests**
  - [ ] `EventListingTest` — homepage returns 200, events are listed
  - [ ] `TicketCheckoutTest` — cleared student gets ticket, uncleared gets blocked
  - [ ] `TuitionClearanceTest` — known IDs return correct clearance status
  - [ ] `QrVerificationTest` — valid hash returns ticket data, invalid returns error
  - [ ] `DuplicateTicketTest` — same student can't buy twice for the same event

- [ ] **Responsive mobile nav**
  - Navbar only shows full menu on `xl` screens (`hidden xl:flex`)
  - No hamburger menu / drawer exists for mobile users

- [ ] **Tailwind CSS via Vite (not CDN)**
  - Currently loads Tailwind via CDN in every page (`<script src="https://cdn.tailwindcss.com">`)
  - For production, should compile via Vite (`npm run build`)
  - `vite.config.js` already exists — just needs to be wired up

- [ ] **`AGENTS.md` / `CLAUDE.md`** — still has generic Laravel Boost boilerplate
  - Should be updated with project-specific agent instructions

---

## 🗺️ Suggested Build Order

```
1. Fix hardcoded "Tuition Status" on ticket pass view          [30 min]
2. Fix EventController search scope bug                        [10 min]
3. Add duplicate ticket prevention                             [15 min]
4. Mark ticket as used on verify endpoint                      [15 min]
5. Add sold-out UI on checkout form                            [20 min]
6. Set up Laravel auth (php artisan make:auth or Breeze)       [1 hr]
7. Build AdminController + routes + views                      [3–5 hrs]
8. Build QR scanner UI for event staff                         [2 hrs]
9. Add email notification on ticket issuance                   [1 hr]
10. Write feature tests                                        [2 hrs]
11. Replace CDN Tailwind with compiled Vite build              [30 min]
12. Mobile hamburger menu                                      [1 hr]
```

---

> **Last audited:** October 1, 2026  
> **Stack:** Laravel 11 · SQLite · Tailwind CSS (CDN) · Swiper.js · QR Server API
