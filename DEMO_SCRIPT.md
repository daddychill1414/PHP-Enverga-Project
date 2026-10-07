# 📱 EnvergaPass — Live Demonstration & Presentation Script

This guide gives you a step-by-step walkthrough to present **EnvergaPass** on desktop and mobile for class presentations, client showcases, or defense demos.

---

## 🚀 Pre-Demo Checklist (1 Minute Setup)

### 1. Start the Server for Both PC and Mobile
Open PowerShell or Terminal and run:
```powershell
cd "z:\CODES!!!! SSD\PHP Enverga\enverga-pass"
php artisan serve --host=0.0.0.0 --port=8000
```

### 2. Connect Your Phone
- Make sure your mobile phone is on the **same Wi-Fi** as your computer.
- Open Safari (iPhone) or Chrome (Android) and navigate to:
  ```text
  http://192.168.1.4:8000
  ```
- *Optional Pro-Tip:* Tap **Share / Options** $\rightarrow$ **"Add to Home Screen"** to launch it like a native mobile app without URL bars!

---

## 🎭 Live Demo Walkthrough (5-Minute Script)

### Act 1: The First Impression (Brand Identity & Mobile UX)
> **What to Say:**  
> *"Good day! We present **EnvergaPass**, the official Event Ticketing and Access Management System tailored specifically for the Manuel S. Enverga University Foundation community."*

- **On Mobile:**
  - Show the responsive header with the official **MSEUF Crimson (`#960000`)** color and university badge.
  - Swipe or scroll through the interactive **Hero Banner Slider** and upcoming event cards.
  - Point out how easy it is for students to browse university festivals, seminars, and sports meets directly on their phones.

---

### Act 2: Event Details & Ticket Selection
> **What to Say:**  
> *"Students can explore event details, check venue capacity, and choose their ticket tier with real-time seat availability."*

- Tap on: **"MSEUF University Foundation Week 2026: Concert & Grand Festival"**.
- Point out:
  - Event date & time
  - Venue: *MSEUF Gymnasium, Lucena Main Campus*
  - Ticket tiers (e.g., Free General Student Pass vs. VIP Front Stage Pass).
- Tap the **"Get Ticket / Reserve Pass"** button.

---

### Act 3: The Innovation Highlight — Tuition Clearance Check 💡
> **What to Say:**  
> *"A key innovation of EnvergaPass is automated validation. For institutional events, students must be in good standing before claiming university-funded passes."*

- **Demo the Cleared Student (Success Flow):**
  - Enter Student ID: `2022-10482` (Juan Dela Cruz)
  - Result: **✅ Cleared (CCMS Department — Balance: ₱0.00)**
  - Reservation proceeds seamlessly!

- **Demo the Hold / Balance Flow (Security Check):**
  - *(Optional)* Show what happens if another ID is entered: `2023-99812` (Maria Clara Santos).
  - Result: Shows pending tuition balance (₱4,500.00) and directs them to the Accounting office before issuing the pass.

---

### Act 4: The Digital Event Pass & QR Access Code
> **What to Say:**  
> *"Once booked, the student receives their personalized digital access pass with a secure, verifiable QR code."*

- Display the generated **Digital Ticket Pass** on the mobile screen:
  - Student Name & ID Number
  - Event Name & Seat Category
  - Unique Ticket Serial Code
  - **Dynamic QR Code** ready for turnstile / gate scanner check-in.
- Highlight the **"Save / Print Ticket"** action.

---

### Act 5: Gate Verification Simulation (Admin/Scanner View)
> **What to Say:**  
> *"At the gymnasium entrance, bouncers and event marshals can verify the pass instantaneously using the verification endpoint."*

- Show how event marshals verify QR data:
  ```text
  http://192.168.1.4:8000/api/verify-ticket?ticket=TKT-XXXXXX
  ```
- Shows real-time status: valid, already admitted, or invalid.

---

## 📊 Summary of Ready Test Data

| Role / Data | Value | Note |
|---|---|---|
| **Cleared Student ID** | `2022-10482` | Juan Dela Cruz (Balance ₱0.00 — Ready to pass) |
| **Uncleared Student ID** | `2023-99812` | Maria Clara Santos (Balance ₱4,500.00) |
| **Featured Event** | Foundation Week 2026 Concert | Slug: `mseuf-foundation-week-2026` |
| **Mobile URL** | `http://192.168.1.4:8000` | Works on any device connected to local Wi-Fi |

---

## 🎤 Strong Closing Statement
> *"With EnvergaPass, MSEUF transitions from paper stubs and long registration lines to a modern, secure, and university-integrated digital ecosystem. Thank you!"*
