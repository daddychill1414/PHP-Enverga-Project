# 🎟️ MSEUF Event Ticketing System — Brainstorm & Blueprint

## Project Overview

**System Name:** **EnvergaPass** — MSEUF Event Ticketing & Access Management System  
**Client:** Manuel S. Enverga University Foundation (MSEUF), Lucena City  
**Platforms:** Web (Laravel/PHP via Herd) + Mobile (React Native)  
**Architecture:** MVC (Models, Views, Controllers)  
**Tagline:** *"Pro Deo Et Patria — Every Event, Seamlessly."*

---

## 🎨 MSEUF Brand Identity (Research Summary)

### Official Colors
| Swatch | Name | Hex | RGB | Usage |
|--------|------|-----|-----|-------|
| 🟥 | **Red Berry (Primary)** | `#960000` | 150, 0, 0 | Headers, primary buttons, navbar |
| 🟥 | **Sangria** | `#9A0000` | 154, 0, 0 | Hover states, accents |
| 🩷 | **Cavern Pink** | `#E5BFBF` | 229, 191, 191 | Soft backgrounds, badges |
| ⬜ | **White** | `#FFFFFF` | 255, 255, 255 | Backgrounds, text on dark |
| ⬛ | **Charcoal** | `#1A1A1A` | 26, 26, 26 | Body text, dark sections |

### University Seal Elements
- **Inner Circle:** Two coconut trees, map of Philippines, open book, flaming torch
- **Motto:** "For God and Country" / *"Pro Deo Et Patria"*
- **Outer Circle:** "Manuel S. Enverga University Foundation, Lucena City"

### Website Design Language (from mseuf.edu.ph)
- **Navigation:** Mega-menu with categories: Instruction, Research, Sustainability, Internationalization, About
- **Hero Section:** Full-width image slider/carousel with motivational copy ("Discover more at Enverga University", "LIVE IT ALL")
- **CTA Buttons:** Prominent "APPLY NOW" and "GET HELP" in maroon/red
- **Layout:** Clean, modern, card-based sections with generous white space
- **Typography:** Bold, structured headings with supportive body text
- **Quick Links Bar:** Top utility bar for Students, Alumni, Faculty & Staff, Downloads
- **Footer:** Deep dark footer with organized columns (Quick Links, Affiliate Schools, Contact Us)
- **Content Sections:** Testimonials carousel, News grid, Events calendar, Programs showcase

---

## 💡 INNOVATIVE FEATURE IDEAS

### 🔥 Tier 1 — Core Innovation (Must-Have)

#### 1. **QR-Powered Smart Tickets**
- Every ticket generates a unique, encrypted QR code
- **Rolling QR codes** that refresh every 30 seconds (anti-screenshot/sharing)
- QR encodes an encrypted token (not raw student ID) validated against the database
- Single-scan verification: validates ticket + student identity + event access level
- Works with phone camera OR dedicated scanner devices

#### 2. **Student ID Integration (RFID/NFC Bridge)**
- Link tickets to existing MSEUF student RFID system (like their GSync system)
- Students can tap their physical ID at gates for instant entry — no phone needed
- Faculty/staff can use their own IDs for VIP/authorized access
- Real-time attendance logging synced with university records

#### 3. **Tiered Access Control**
- **Ticket Types:** Student, Faculty, VIP, Alumni, Guest/Public
- Different pricing tiers per event
- Zone-based access (e.g., VIP seating vs. general admission)
- Department-specific early-bird access windows

#### 4. **Real-Time Event Dashboard (Admin)**
- Live headcount vs. venue capacity
- Entry/exit timestamps with heatmap visualization
- Revenue tracking (if paid events)
- Demographics breakdown (by college, year level, etc.)
- Exportable reports for university administration

---

### 🚀 Tier 2 — Innovation Features (Differentiators)

#### 5. **Virtual Queue System ("EnvergaLine")**
- For high-demand events (concerts, graduation ceremonies, foundation day)
- Students join a virtual waiting room via the app
- Real-time position updates with estimated entry time
- Push notifications: "You're next! Proceed to Gate B"
- Eliminates physical crowding and improves safety

#### 6. **Smart Notifications Engine**
- Pre-event reminders (1 day, 1 hour before)
- Weather-aware alerts for outdoor events
- Post-event automated feedback collection
- Schedule change / cancellation push notifications
- "Your friend is attending!" social nudges

#### 7. **Digital Event Wallet ("EnvergaWallet")**
- Pre-load funds for paid events and on-campus purchases
- GCash / Maya / bank transfer integration for Philippine market
- View spending history, remaining balance
- Refund processing for cancelled events
- Cashless food/merch purchases at event venues

#### 8. **Seat Selection & Venue Mapping**
- Interactive SVG/Canvas venue maps
- Drag-to-select seats for performing arts / theater events (AEC Little Theater)
- Color-coded availability (available, reserved, sold out)
- Accessibility-marked seats for PWD students

---

### 🌟 Tier 3 — Advanced Innovation (Wow Factor)

#### 9. **AI-Powered Event Recommendations**
- Based on student's college, year level, past attendance
- "Students in CCMS also attended..." suggestions
- Trending events on campus
- Personalized event feed on mobile app

#### 10. **Social & Community Features**
- "Going" / "Interested" status (Facebook-style)
- Share events to class group chats
- Event photo gallery (post-event)
- Student reviews and ratings
- Leaderboard: "Most Active Event-Goer" badges

#### 11. **Offline Mode (PWA)**
- Downloaded ticket stored locally — works without WiFi
- Offline QR code validation for areas with poor connectivity
- Auto-sync when connection is restored
- Critical for large outdoor events on campus

#### 12. **Analytics & Insights Portal**
- Event organizers see engagement metrics
- Best day/time to host events (historical data)
- Ticket sales velocity graphs
- No-show prediction based on past behavior
- ROI tracking for sponsored/funded events

---

## 🏗️ SYSTEM ARCHITECTURE

### Tech Stack

| Layer | Technology | Purpose |
|-------|-----------|---------|
| **Backend** | Laravel 11 (PHP 8.3) via Herd | API + MVC web app |
| **Frontend (Web)** | Blade Templates + Alpine.js/Livewire | Server-rendered views with interactivity |
| **Mobile** | React Native (Expo) | Cross-platform iOS/Android app |
| **Database** | MySQL 8.0 | Primary data store |
| **Cache** | Redis | Session, queue, real-time |
| **Queue** | Laravel Queue (Redis/Database) | Email, notifications, ticket generation |
| **Real-time** | Laravel Reverb / Pusher | Live dashboard, queue updates |
| **File Storage** | Laravel Storage (local/S3) | Event images, QR codes, exports |
| **Auth** | Laravel Sanctum | API tokens for mobile, web session auth |

### MVC Structure (Laravel)

```
app/
├── Models/
│   ├── User.php              # Students, Faculty, Admin, Organizers
│   ├── Event.php             # Events with dates, venues, capacity
│   ├── Ticket.php            # Individual ticket instances
│   ├── TicketType.php        # Student, VIP, Faculty, Guest tiers
│   ├── Venue.php             # AEC Theater, Gymnasium, Open Field
│   ├── Booking.php           # User-Event-Ticket pivot with status
│   ├── Payment.php           # Transaction records
│   ├── QrCode.php            # Rolling QR code management
│   ├── EventCategory.php     # Academic, Cultural, Sports, etc.
│   ├── Notification.php      # Push/email notification log
│   ├── Feedback.php          # Post-event ratings & reviews
│   └── Attendance.php        # Check-in/check-out timestamps
│
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   └── ForgotPasswordController.php
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── EventManagementController.php
│   │   │   ├── UserManagementController.php
│   │   │   ├── ReportController.php
│   │   │   └── SettingsController.php
│   │   ├── Organizer/
│   │   │   ├── EventController.php       # CRUD events
│   │   │   ├── TicketController.php      # Manage ticket types & pricing
│   │   │   ├── ScannerController.php     # QR/RFID verification
│   │   │   ├── AttendanceController.php  # Check-in management
│   │   │   └── AnalyticsController.php   # Event-specific reports
│   │   ├── Student/
│   │   │   ├── EventBrowseController.php # Discover & search events
│   │   │   ├── BookingController.php     # Reserve/purchase tickets
│   │   │   ├── MyTicketsController.php   # View owned tickets & QR
│   │   │   ├── WalletController.php      # Digital wallet management
│   │   │   └── FeedbackController.php    # Post-event reviews
│   │   └── Api/
│   │       ├── AuthController.php        # Mobile auth (Sanctum)
│   │       ├── EventApiController.php    # REST endpoints for RN app
│   │       ├── TicketApiController.php   # Ticket operations
│   │       └── NotificationController.php
│   │
│   ├── Middleware/
│   │   ├── RoleMiddleware.php            # admin, organizer, student
│   │   ├── TicketValidationMiddleware.php
│   │   └── EnsureEventActive.php
│   │
│   └── Requests/
│       ├── StoreEventRequest.php
│       ├── BookTicketRequest.php
│       └── ProcessPaymentRequest.php
│
├── Views/ (Blade Templates)
│   ├── layouts/
│   │   ├── app.blade.php         # Main layout (MSEUF-branded)
│   │   ├── admin.blade.php       # Admin dashboard layout
│   │   └── auth.blade.php        # Login/register layout
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── events/
│   │   ├── index.blade.php       # Event listing/discovery
│   │   ├── show.blade.php        # Event detail + booking
│   │   ├── create.blade.php      # Create event form
│   │   └── edit.blade.php        # Edit event form
│   ├── tickets/
│   │   ├── my-tickets.blade.php  # Student's ticket dashboard
│   │   ├── show.blade.php        # Single ticket with QR
│   │   └── scanner.blade.php     # QR scanning interface
│   ├── admin/
│   │   ├── dashboard.blade.php   # Analytics overview
│   │   ├── events.blade.php      # All events management
│   │   ├── users.blade.php       # User management
│   │   └── reports.blade.php     # Export reports
│   └── components/
│       ├── navbar.blade.php      # MSEUF-branded navigation
│       ├── footer.blade.php      # University footer
│       ├── event-card.blade.php  # Reusable event card
│       └── qr-display.blade.php  # QR code component
│
├── Services/
│   ├── TicketService.php         # Ticket generation logic
│   ├── QrCodeService.php         # QR generation & validation
│   ├── PaymentService.php        # Payment gateway integration
│   └── NotificationService.php   # Push/email dispatching
│
└── Policies/
    ├── EventPolicy.php           # Who can create/edit/delete events
    ├── TicketPolicy.php          # Who can view/transfer tickets
    └── BookingPolicy.php         # Booking authorization rules
```

---

## 👤 USER ROLES & FLOWS

### Role Matrix

| Role | Can Create Events | Can Book Tickets | Can Scan | Can View Reports | Admin Panel |
|------|:-:|:-:|:-:|:-:|:-:|
| **Super Admin** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Event Organizer** | ✅ (own) | ✅ | ✅ (own events) | ✅ (own events) | Limited |
| **Faculty/Staff** | ❌ | ✅ | ❌ | ❌ | ❌ |
| **Student** | ❌ | ✅ | ❌ | ❌ | ❌ |
| **Guest/Alumni** | ❌ | ✅ (public only) | ❌ | ❌ | ❌ |

### Key User Flows

**Student Flow:**
```
Login → Browse Events → View Details → Select Ticket Type → 
Pay (GCash/Wallet/Free) → Receive QR Ticket → 
Get Reminders → Arrive at Event → Scan QR at Gate → 
Attend → Receive Feedback Form → Rate Event
```

**Organizer Flow:**
```
Login → Create Event (details, venue, dates, capacity) →
Set Ticket Types & Pricing → Publish Event →
Monitor Sales Dashboard → Event Day: Open Scanner →
Scan Attendees In → View Live Headcount →
Post-Event: Review Analytics & Feedback → Export Report
```

---

## 🎨 UI/UX DESIGN DIRECTION

### Design Principles (Inspired by mseuf.edu.ph)

1. **MSEUF Brand Faithful** — Maroon (#960000) primary, clean whites, professional feel
2. **Card-Based Layout** — Events displayed as rich media cards with hover effects
3. **Mobile-First** — 80%+ of students will use the mobile app
4. **Accessibility** — PWD-friendly, Filipino/English bilingual support
5. **Clean & Institutional** — Professional enough for administration, engaging for students

### Web UI Components (MSEUF-Styled)

```
┌──────────────────────────────────────────────────────────┐
│ 🔴 ENVERGA UNIVERSITY    [Events] [My Tickets] [👤 Juan] │  ← Maroon navbar
├──────────────────────────────────────────────────────────┤
│                                                          │
│  ╔══════════════════════════════════════════════╗         │
│  ║  🎉 Foundation Day 2026                      ║         │  ← Hero banner
│  ║  "Celebrating Excellence — LIVE IT ALL"      ║         │
│  ║  📅 Oct 15, 2026 │ 📍 University Gymnasium  ║         │
│  ║  [🎟️ Get Your Ticket]                        ║         │
│  ╚══════════════════════════════════════════════╝         │
│                                                          │
│  ┌─── Upcoming Events ────────────────────────────┐      │
│  │ ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐  │      │
│  │ │🎵 Event│ │🏀 Event│ │📚 Event│ │🎨 Event│  │      │  ← Event cards grid
│  │ │  Card  │ │  Card  │ │  Card  │ │  Card  │  │      │
│  │ │ [Book] │ │ [Book] │ │ [Free] │ │ [Book] │  │      │
│  │ └────────┘ └────────┘ └────────┘ └────────┘  │      │
│  └────────────────────────────────────────────────┘      │
│                                                          │
│  ┌─── My Active Tickets ──────────────────────────┐      │
│  │ 🎫 Foundation Day Concert │ Gate A │ [View QR] │      │  ← Quick ticket access
│  │ 🎫 CCMS TechFest 2026    │ Free   │ [View QR] │      │
│  └────────────────────────────────────────────────┘      │
│                                                          │
├──────────────────────────────────────────────────────────┤
│ © 2026 MSEUF │ Pro Deo Et Patria │ [FB] [IG] [YT]      │  ← Dark footer
└──────────────────────────────────────────────────────────┘
```

### Mobile App Screens (React Native)

1. **Splash Screen** — MSEUF seal animation
2. **Login** — Student ID + password (matches university portal auth)
3. **Home Feed** — Scrollable event cards, "For You" recommendations
4. **Event Detail** — Banner image, details, ticket selection, seat map
5. **My Tickets** — List view with QR code access, status indicators
6. **QR Ticket** — Full-screen QR display with student info, brightness boost
7. **Scanner** — Camera-based QR reader for organizers/staff
8. **Profile** — Student info, booking history, wallet balance
9. **Notifications** — Event reminders, updates, feedback requests

---

## 🗄️ DATABASE SCHEMA (Key Tables)

```sql
-- Core tables
users (id, name, email, student_id, role, college, year_level, avatar, ...)
events (id, organizer_id, title, description, venue_id, category_id, 
        start_date, end_date, capacity, status, banner_image, ...)
venues (id, name, location, capacity, map_svg, ...)
event_categories (id, name, icon, color)

-- Ticketing
ticket_types (id, event_id, name, price, quantity, max_per_user, ...)
bookings (id, user_id, event_id, ticket_type_id, status, 
          booking_code, qr_hash, checked_in_at, ...)
payments (id, booking_id, amount, method, reference_no, status, ...)

-- Engagement
feedback (id, user_id, event_id, rating, comment, ...)
notifications (id, user_id, type, title, body, read_at, ...)
attendance_logs (id, booking_id, gate, action, scanned_by, timestamp)

-- Wallet (optional)
wallets (id, user_id, balance, ...)
wallet_transactions (id, wallet_id, type, amount, reference, ...)
```

---

## 📱 REACT NATIVE MOBILE APP STRUCTURE

```
mobile/
├── src/
│   ├── screens/
│   │   ├── Auth/          # Login, Register, ForgotPassword
│   │   ├── Home/          # Event feed, search, categories
│   │   ├── EventDetail/   # Full event view + booking
│   │   ├── MyTickets/     # Ticket list + QR display
│   │   ├── Scanner/       # QR code scanner (organizer)
│   │   ├── Profile/       # User info, history, settings
│   │   └── Notifications/ # Push notification center
│   ├── components/
│   │   ├── EventCard.jsx
│   │   ├── TicketCard.jsx
│   │   ├── QRDisplay.jsx
│   │   ├── SeatMap.jsx
│   │   └── Header.jsx     # MSEUF-branded header
│   ├── navigation/
│   │   └── AppNavigator.jsx
│   ├── services/
│   │   └── api.js          # Axios/fetch to Laravel API
│   ├── store/              # State management (Zustand/Redux)
│   └── theme/
│       └── mseuf.js        # Brand colors, fonts, spacing
```

---

## 🔐 SECURITY CONSIDERATIONS

1. **Encrypted QR payloads** — Never expose raw student IDs
2. **Single-use ticket validation** — `is_checked_in` flag prevents re-entry
3. **Laravel Sanctum** — Token-based API authentication for mobile
4. **RBAC (Role-Based Access Control)** — Gates & Policies per role
5. **Rate limiting** — Prevent ticket scalping/bot purchasing
6. **HTTPS everywhere** — SSL for all API and web endpoints
7. **Data Privacy Act (RA 10173)** — Compliance with Philippine data privacy law
8. **CSRF protection** — Laravel's built-in middleware for web forms

---

## 📋 DEVELOPMENT PHASES

### Phase 1 — Foundation (Weeks 1-3)
- [ ] Laravel project setup via Herd
- [ ] Database migrations & seeders
- [ ] User authentication (multi-role)
- [ ] Basic Event CRUD (create, read, update, delete)
- [ ] MSEUF-branded Blade layout & components

### Phase 2 — Ticketing Core (Weeks 4-6)
- [ ] Ticket type management
- [ ] Booking flow (free + paid)
- [ ] QR code generation (simple-qrcode package)
- [ ] QR scanning interface (html5-qrcode JS)
- [ ] Attendance logging

### Phase 3 — Mobile App (Weeks 7-10)
- [ ] React Native project setup (Expo)
- [ ] Auth screens + Sanctum integration
- [ ] Event browsing & detail screens
- [ ] My Tickets + QR display
- [ ] Push notifications (Expo Notifications)

### Phase 4 — Innovation Layer (Weeks 11-14)
- [ ] Virtual queue system
- [ ] Real-time dashboard (Livewire/Pusher)
- [ ] Digital wallet integration
- [ ] Seat selection (interactive maps)
- [ ] Analytics & reporting

### Phase 5 — Polish & Deploy (Weeks 15-16)
- [ ] Performance optimization
- [ ] Security audit
- [ ] User acceptance testing
- [ ] Documentation
- [ ] Deployment to production server

---

## 🎯 WHAT MAKES THIS DIFFERENT FROM EXISTING SYSTEMS?

| Existing at MSEUF | EnvergaPass Innovation |
|---|---|
| Manual event attendance (paper sign-up) | QR/RFID automated check-in |
| No unified event discovery | Centralized event marketplace |
| Separate payment portals | Integrated digital wallet |
| Physical queuing at gates | Virtual queue with live position tracking |
| No post-event analytics | Real-time dashboards + exportable reports |
| ICTD Online (IT support tickets) | Purpose-built EVENT ticketing system |
| Facebook-based event promotion | In-app discovery + smart recommendations |
| No mobile experience | Native React Native app with offline support |

---

> [!IMPORTANT]
> This system bridges the gap between MSEUF's existing digital infrastructure (ICTD Online, GSync, Payment Portal) and the missing piece — a dedicated, modern event management & ticketing platform built with the university's brand identity at its core.

> [!TIP]
> **Quick Win:** Even before the mobile app is ready, the web version alone (accessible via phone browser) provides immediate value. The mobile app adds convenience features like push notifications, offline QR, and camera scanning.
