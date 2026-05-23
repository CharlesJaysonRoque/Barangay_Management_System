{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Barangay Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Main Theme Colors - Philippine Flag */
            --primary-color: #0038A8;      /* Philippine blue */
            --secondary-color: #CE1126;    /* Philippine red */
            --accent-color: #FCD116;       /* Gold / yellow */

            /* Neutral Colors */
            --background-color: #F8FAFC;
            --surface-color: #FFFFFF;
            --text-color: #1F2937;
            --text-light: #6B7280;

            /* Status Colors */
            --success-color: #16A34A;
            --warning-color: #F59E0B;
            --danger-color: #DC2626;

            /* Borders & Shadows */
            --border-color: #D1D5DB;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --shadow-lg: rgba(0, 0, 0, 0.15);

            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;

            /* Border Radius */
            --radius-sm: 0.25rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-3xl: 2rem;

            /* Transitions */
            --transition-fast: 150ms ease;
            --transition-base: 250ms ease;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, var(--background-color) 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-lg);
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative background elements */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(0, 56, 168, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(206, 17, 38, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Back link */
        .back-link {
            position: fixed;
            top: var(--spacing-xl);
            left: var(--spacing-xl);
            z-index: 10;
        }

        .back-link a {
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            padding: 0.6rem 1.2rem;
            border-radius: var(--radius-3xl);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-color);
            text-decoration: none;
            box-shadow: 0 1px 3px var(--shadow-color);
            transition: all var(--transition-base);
            border: 1px solid rgba(203, 213, 225, 0.5);
        }

        .back-link a:hover {
            background: white;
            box-shadow: 0 4px 12px var(--shadow-color);
            border-color: var(--border-color);
            transform: translateX(-4px);
        }

        .back-link svg {
            width: 18px;
            height: 18px;
            stroke: var(--primary-color);
        }

        /* Main container */
        .login-container {
            width: 100%;
            max-width: 460px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Login Card */
        .login-card {
            background: var(--surface-color);
            border-radius: var(--radius-2xl);
            box-shadow: 0 25px 50px -12px var(--shadow-lg);
            padding: 2.5rem 2rem;
            transition: all var(--transition-base);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            z-index: 1;
        }

        /* Header / Brand */
        .brand {
            text-align: center;
            margin-bottom: var(--spacing-xl);
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto var(--spacing-md);
            background: linear-gradient(135deg, #0038A8 0%, #CE1126 100%);
            border-radius: var(--radius-2xl);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0, 56, 168, 0.2);
        }

        .logo-icon svg {
            width: 36px;
            height: 36px;
            stroke: white;
        }

        .brand h1 {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
        }

        .brand p {
            color: var(--text-light);
            font-size: 0.875rem;
            margin-top: var(--spacing-sm);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: var(--spacing-lg);
        }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: var(--spacing-sm);
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: var(--text-light);
            pointer-events: none;
        }

        input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.75rem;
            font-size: 0.95rem;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-lg);
            background: var(--surface-color);
            transition: all var(--transition-fast);
            outline: none;
            font-family: inherit;
            color: var(--text-color);
        }

        input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.1);
        }

        input::placeholder {
            color: var(--text-light);
            font-weight: 400;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 0.9rem;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 0.95rem;
            color: white;
            cursor: pointer;
            transition: all var(--transition-base);
            margin-top: var(--spacing-sm);
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--spacing-sm);
            box-shadow: 0 4px 12px rgba(0, 56, 168, 0.25);
        }

        .login-btn:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 56, 168, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Footer Links */
        .footer-links {
            margin-top: var(--spacing-xl);
            text-align: center;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .footer-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color var(--transition-fast);
        }

        .footer-links a:hover {
            color: var(--btn-hover);
            text-decoration: underline;
        }

        .divider {
            margin: 0 0.5rem;
            color: var(--border-color);
        }

        /* Alert / Error Messages */
        .alert {
            border-radius: var(--radius-md);
            padding: 0.875rem 1rem;
            margin-bottom: var(--spacing-lg);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-error {
            background: rgba(220, 38, 38, 0.1);
            border-left: 4px solid var(--danger-color);
            color: var(--danger-color);
        }

        .alert-success {
            background: rgba(22, 163, 74, 0.1);
            border-left: 4px solid var(--success-color);
            color: var(--success-color);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border-left: 4px solid var(--warning-color);
            color: var(--warning-color);
        }

        .alert svg {
            flex-shrink: 0;
        }

        /* Remember me checkbox */
        .remember-me {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--spacing-lg);
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            cursor: pointer;
        }

        .checkbox-wrapper input {
            width: auto;
            padding: 0;
            margin: 0;
            cursor: pointer;
        }

        .checkbox-wrapper span {
            font-size: 0.85rem;
            color: var(--text-color);
        }

        /* Responsive */
        @media (max-width: 640px) {
            body {
                padding: var(--spacing-md);
            }

            .login-card {
                padding: 1.8rem 1.5rem;
            }

            .back-link {
                top: var(--spacing-md);
                left: var(--spacing-md);
            }

            .back-link a {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }

            .brand h1 {
                font-size: 1.5rem;
            }

            .logo-icon {
                width: 52px;
                height: 52px;
            }

            .logo-icon svg {
                width: 28px;
                height: 28px;
            }
        }

        @media (max-width: 480px) {
            .remember-me {
                flex-direction: column;
                gap: var(--spacing-sm);
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<div class="back-link">
    <a href="{{ route('landing_page') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to Dashboard
    </a>
</div>

<div class="login-container">
    <div class="login-card">
        <div class="brand">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h1>Barangay System</h1>
            <p>Sign in to your account to continue</p>
        </div>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-error">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    <strong>Authentication Failed</strong><br>
                    {{ $errors->first() }}
                </div>
            </div>
        @endif

        {{-- Display success message (e.g., from password reset) --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <input type="email"
                           name="email"
                           id="email"
                           placeholder="admin@barangay.gov.ph"
                           value="{{ old('email') }}"
                           autofocus
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                    <input type="password"
                           name="password"
                           id="password"
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            <div class="remember-me">
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="remember" id="remember">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="login-btn text-black">
                Sign In
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>
        </form>
    </div>
</div>

</body>
</html>
