# 📂 EnvergaPass — Project File Directory & Architecture Guide

A quick reference explaining the role and purpose of key files and directories across the **EnvergaPass** project.

---

## 📑 Root Planning & Documentation Files

| File                            | Purpose                                                                                         |
| ------------------------------- | ----------------------------------------------------------------------------------------------- |
| `mseuf_ticketing_brainstorm.md` | Core blueprint, branding research (colors, seals), feature brainstorms, and architecture ideas. |
| `mseuf_innovation_catalog.md`   | Catalog of innovative features (RFID/NFC gate sync, clearance integration, seat maps, etc.).    |
| `enverga_pass_next_steps.md`    | Action items, immediate roadmap, and development progression.                                   |
| `enverga-pass-todo.md`          | Task checklist tracking completed and pending milestones.                                       |
| `content.md`                    | Raw copy, marketing text, and reference text material for the platform.                         |

---

## 🌐 Laravel Web Application (`enverga-pass/`)

### 1. Application Controllers (`app/Http/Controllers/`)

Handles HTTP requests and passes data to views.

- `EventController.php`: Manages event listings, filtering, details page, and event capacity.
- `TicketController.php`: Handles ticket reservations, issuance, validation, and viewing student passes.
- `AdminController.php`: Administrative management, analytics, attendee check-in controls.
- `TuitionClearanceController.php`: Validates whether a student has financial/accounting clearance before allowing ticket claims.

### 2. Data Models (`app/Models/`)

Eloquent ORM definitions representing database tables and relationships.

- `Event.php`: Event entities (title, venue, dates, capacity, banner image).
- `Ticket.php`: Individual issued ticket instances with student ID, QR code token, and check-in status.
- `TicketType.php`: Ticket tiers/categories per event (VIP, General Admission, Participant, Faculty).
- `Payment.php`: Payment transactions for paid ticket tiers.
- `TuitionClearance.php`: Student clearance status records used for access control gates.
- `User.php`: Authentication model for students, staff, and system administrators.

### 3. Database (`database/`)

- `migrations/2026_09_28_070908_create_events_table.php`: Schema definition for events.
- `migrations/2026_09_28_070909_create_tickets_table.php`: Schema definition for tickets & QR verification codes.
- `migrations/2026_09_28_070910_create_ticket_types_table.php`: Schema definition for ticket categories & prices.
- `migrations/2026_09_28_070911_create_payments_table.php`: Schema definition for payment logs.
- `migrations/2026_09_28_070912_create_tuition_clearances_table.php`: Schema definition for financial clearance rules.
- `seeders/DatabaseSeeder.php`: Populates dummy events, ticket types, and demo accounts for testing.
- `database.sqlite`: Local SQLite database file for rapid development.

### 4. User Interface & Views (`resources/views/`)

Blade templates styled with Tailwind CSS and university branding (`#960000` Crimson).

- `layouts/app.blade.php`: Master template with responsive navbar, official MSEUF header, fonts, and footer.
- `welcome.blade.php`: Landing homepage with hero slider, featured events, and university announcement banner.
- `events/index.blade.php`: Event catalog with search and category filters.
- `events/show.blade.php`: Detailed event overview, venue info, ticket tier selection, and booking modal.
- `tickets/show.blade.php`: Digital event pass display (QR code, student info, seat allocation, save/print button).
- `clearance/index.blade.php`: Student clearance status check tool before booking.

### 5. Routing & Configuration

- `routes/web.php`: Defines all browser URL endpoints (events, checkout, ticket inspection, admin).
- `routes/console.php`: Artisan CLI command definitions.
- `config/`: App settings (`database.php`, `auth.php`, `app.php`, etc.).
- `.env`: Environment variables (database connection, application key, local URL).

### 6. Public Assets (`public/images/`)

- `banner.jpg`, `hero-1.jpg`: High-resolution event headers and carousel imagery.
- `eu-logo.svg`, `mseuf-logo.png`, `seal.png`, `seal-clean.png`: Official university badges, crests, and branding marks.
