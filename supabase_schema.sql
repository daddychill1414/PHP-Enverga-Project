-- ==============================================================================
-- 🎓 ENVERGA PASS — SUPABASE (POSTGRESQL) COMPLETE DATABASE INITIALIZATION
-- Manuel S. Enverga University Foundation (MSEUF)
--
-- Instructions:
-- 1. Open your Supabase Dashboard: https://supabase.com/dashboard/project/<your-project-id>
-- 2. Go to the "SQL Editor" in the left sidebar
-- 3. Click "New Query", paste this entire file, and click "RUN"
-- ==============================================================================

-- Clean slate (optional reset)
DROP TABLE IF EXISTS payments CASCADE;
DROP TABLE IF EXISTS tickets CASCADE;
DROP TABLE IF EXISTS ticket_types CASCADE;
DROP TABLE IF EXISTS events CASCADE;
DROP TABLE IF EXISTS tuition_clearances CASCADE;
DROP TABLE IF EXISTS password_reset_tokens CASCADE;
DROP TABLE IF EXISTS sessions CASCADE;
DROP TABLE IF EXISTS cache CASCADE;
DROP TABLE IF EXISTS cache_locks CASCADE;
DROP TABLE IF EXISTS jobs CASCADE;
DROP TABLE IF EXISTS job_batches CASCADE;
DROP TABLE IF EXISTS failed_jobs CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- ------------------------------------------------------------------------------
-- 1. USERS TABLE (Authentication & Admin Role)
-- ------------------------------------------------------------------------------
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP WITH TIME ZONE NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------------------------------
-- 2. LARAVEL SESSIONS & AUTH TOKENS
-- ------------------------------------------------------------------------------
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE NULL
);

CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT NULL REFERENCES users(id) ON DELETE CASCADE,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INT NOT NULL
);
CREATE INDEX idx_sessions_user_id ON sessions(user_id);
CREATE INDEX idx_sessions_last_activity ON sessions(last_activity);

-- ------------------------------------------------------------------------------
-- 3. TUITION CLEARANCES (Student Financial Gate)
-- Format: A20-30518
-- Only mock data included as requested (external student tuition fees)
-- ------------------------------------------------------------------------------
CREATE TABLE tuition_clearances (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    student_name VARCHAR(255) NOT NULL,
    department VARCHAR(255) NOT NULL,
    tuition_balance NUMERIC(10, 2) NOT NULL DEFAULT 0.00,
    is_cleared BOOLEAN NOT NULL DEFAULT TRUE,
    cleared_semester VARCHAR(100) NOT NULL DEFAULT '1st Semester 2026-2027',
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_tuition_student_id ON tuition_clearances(student_id);

-- ------------------------------------------------------------------------------
-- 4. EVENTS TABLE (University Events managed by Admin)
-- ------------------------------------------------------------------------------
CREATE TABLE events (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL DEFAULT 'MSEUF Gymnasium / Main Campus',
    organizer VARCHAR(255) NOT NULL DEFAULT 'MSEUF Supreme Student Council',
    category VARCHAR(100) NOT NULL DEFAULT 'University Festival',
    event_date TIMESTAMP WITH TIME ZONE NOT NULL,
    banner_image VARCHAR(1024) NULL,
    total_capacity INT NOT NULL DEFAULT 500,
    requires_tuition_clearance BOOLEAN NOT NULL DEFAULT TRUE,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    status VARCHAR(50) NOT NULL DEFAULT 'upcoming' CHECK (status IN ('upcoming', 'ongoing', 'completed', 'cancelled')),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_events_slug ON events(slug);
CREATE INDEX idx_events_status ON events(status);

-- ------------------------------------------------------------------------------
-- 5. TICKET TYPES (Pricing & Capacity Tiers per Event)
-- ------------------------------------------------------------------------------
CREATE TABLE ticket_types (
    id BIGSERIAL PRIMARY KEY,
    event_id BIGINT NOT NULL REFERENCES events(id) ON DELETE CASCADE,
    name VARCHAR(255) NOT NULL,
    price NUMERIC(8, 2) NOT NULL DEFAULT 0.00,
    quota INT NOT NULL DEFAULT 100,
    remaining INT NOT NULL DEFAULT 100,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_ticket_types_event_id ON ticket_types(event_id);

-- ------------------------------------------------------------------------------
-- 6. TICKETS (Issued Passes with QR Hash & Attendance Check-in)
-- ------------------------------------------------------------------------------
CREATE TABLE tickets (
    id BIGSERIAL PRIMARY KEY,
    ticket_number VARCHAR(100) NOT NULL UNIQUE,
    event_id BIGINT NOT NULL REFERENCES events(id) ON DELETE CASCADE,
    ticket_type_id BIGINT NOT NULL REFERENCES ticket_types(id) ON DELETE CASCADE,
    user_id BIGINT NULL REFERENCES users(id) ON DELETE CASCADE,
    attendee_name VARCHAR(255) NOT NULL,
    attendee_email VARCHAR(255) NOT NULL,
    student_id VARCHAR(50) NULL,
    qr_code_hash TEXT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'confirmed' CHECK (status IN ('reserved', 'confirmed', 'checked_in', 'cancelled')),
    checked_in_at TIMESTAMP WITH TIME ZONE NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_tickets_qr_code_hash ON tickets(qr_code_hash);
CREATE INDEX idx_tickets_student_id ON tickets(student_id);
CREATE INDEX idx_tickets_event_id ON tickets(event_id);

-- ------------------------------------------------------------------------------
-- 7. PAYMENTS TABLE (GCash / Maya / Cashier receipts)
-- ------------------------------------------------------------------------------
CREATE TABLE payments (
    id BIGSERIAL PRIMARY KEY,
    ticket_id BIGINT NOT NULL REFERENCES tickets(id) ON DELETE CASCADE,
    reference_number VARCHAR(100) NOT NULL UNIQUE,
    amount NUMERIC(8, 2) NOT NULL,
    payment_method VARCHAR(100) NOT NULL DEFAULT 'GCash',
    status VARCHAR(50) NOT NULL DEFAULT 'completed' CHECK (status IN ('pending', 'completed', 'failed', 'refunded')),
    paid_at TIMESTAMP WITH TIME ZONE NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_payments_ticket_id ON payments(ticket_id);
CREATE INDEX idx_payments_status ON payments(status);

-- ==============================================================================
-- INITIAL SEED DATA
-- ==============================================================================

-- 1. Default Administrator Account
-- Email: admin@mseuf.edu.ph
-- Password: enverga2026 (bcrypt hash)
INSERT INTO users (name, email, password, is_admin, created_at, updated_at)
VALUES (
    'MSEUF Administrator',
    'admin@mseuf.edu.ph',
    '$2y$12$Z0H3rTz19g5lM/b8X5O8Qe0YnN6i9lW6fR1t2U4iP8Yv7Jq6GZt7u', -- bcrypt('enverga2026')
    TRUE,
    NOW(),
    NOW()
) ON CONFLICT (email) DO NOTHING;

-- 2. Mock Tuition Clearance Records
-- Only mock data included in the database as requested
INSERT INTO tuition_clearances (student_id, student_name, department, tuition_balance, is_cleared, cleared_semester, created_at, updated_at)
VALUES 
    ('A20-30518', 'Ranie C. Enverga', 'College of Computing and Multimedia Studies (CCMS)', 0.00, TRUE, '1st Semester 2026-2027', NOW(), NOW()),
    ('A21-10492', 'Juan Miguel Dela Cruz', 'College of Engineering', 0.00, TRUE, '1st Semester 2026-2027', NOW(), NOW()),
    ('A22-20831', 'Maria Sophia Santos', 'College of Business and Accountancy (CBA)', 4850.00, FALSE, '1st Semester 2026-2027', NOW(), NOW()),
    ('A23-40119', 'Christian Mark Perez', 'College of Education, Arts and Sciences (CEAS)', 0.00, TRUE, '1st Semester 2026-2027', NOW(), NOW()),
    ('A24-50220', 'Alyssa Nicole Reyes', 'College of Nursing and Allied Health Sciences', 8200.00, FALSE, '1st Semester 2026-2027', NOW(), NOW())
ON CONFLICT (student_id) DO NOTHING;
