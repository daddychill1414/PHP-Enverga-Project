<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — MSEUF Enverga Pass</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        :root {
            --crimson: #730000;
            --crimson-dark: #5a0000;
            --gold: #D4AF37;
            --gold-light: #f0e2a0;
            --bg: #f5f3f0;
            --card-bg: #ffffff;
            --text-dark: #1a1a1a;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --error-bg: #fef2f2;
            --error-border: #fecaca;
            --error-text: #991b1b;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(115, 0, 0, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(212, 175, 55, 0.04) 0%, transparent 50%);
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .logo-area {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: var(--crimson);
            border-radius: 16px;
            margin-bottom: 1rem;
            box-shadow: 0 4px 14px rgba(115, 0, 0, 0.25);
        }

        .logo-badge svg {
            width: 32px;
            height: 32px;
            fill: white;
        }

        .logo-area h1 {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--text-dark);
            letter-spacing: -0.03em;
        }

        .logo-area p {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.35rem;
            font-weight: 500;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.04);
        }

        .error-alert {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .error-alert svg {
            width: 18px;
            height: 18px;
            fill: var(--error-text);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .error-alert p {
            font-size: 0.8rem;
            color: var(--error-text);
            font-weight: 600;
            line-height: 1.4;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.7rem 0.9rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
            background: #fafafa;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--crimson);
            box-shadow: 0 0 0 3px rgba(115, 0, 0, 0.08);
            background: white;
        }

        .form-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--crimson);
            cursor: pointer;
        }

        .remember-row label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            padding: 0.75rem;
            background: var(--crimson);
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(115, 0, 0, 0.2);
        }

        .login-btn:hover {
            background: var(--crimson-dark);
            box-shadow: 0 4px 14px rgba(115, 0, 0, 0.3);
        }

        .login-btn:active {
            transform: scale(0.98);
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .footer-text a {
            color: var(--crimson);
            text-decoration: none;
            font-weight: 700;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-area">
            <div class="logo-badge">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-1 6h2v2h-2V7zm0 4h2v6h-2v-6z"/></svg>
            </div>
            <h1>Enverga Pass Admin</h1>
            <p>MSEUF Event Management System</p>
        </div>

        <div class="login-card">
            @if ($errors->any())
                <div class="error-alert">
                    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="admin@mseuf.edu.ph"
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="••••••••"
                        required
                    >
                </div>

                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember this session</label>
                </div>

                <button type="submit" class="login-btn">Sign In to Admin Panel</button>
            </form>
        </div>

        <p class="footer-text">
            <a href="{{ route('events.index') }}">← Back to Event Catalog</a>
        </p>
    </div>
</body>
</html>
