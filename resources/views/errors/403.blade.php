<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Restricted | PenSoftTech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #0b0f19;
            color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .error-card {
            background: #111827;
            border: 1px solid #1f2937;
            border-radius: 16px;
            max-width: 520px;
            width: 100%;
            padding: 40px 32px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            letter-spacing: 0.05em;
        }
        h1 {
            font-family: 'Sora', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
        }
        p {
            color: #9ca3af;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        @media (min-width: 480px) {
            .actions {
                flex-direction: row;
                justify-content: center;
            }
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 22px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: #2563eb;
            color: #ffffff;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-secondary {
            background: #1f2937;
            color: #d1d5db;
            border: 1px solid #374151;
        }
        .btn-secondary:hover {
            background: #374151;
            color: #ffffff;
        }
        .logout-link {
            margin-top: 24px;
            display: inline-block;
            color: #6b7280;
            font-size: 13px;
            text-decoration: none;
        }
        .logout-link:hover {
            color: #9ca3af;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            HTTP 403 · ACCESS RESTRICTED
        </div>

        <h1>Permission Denied</h1>
        <p>
            {{ $exception->getMessage() ?: 'You do not have the required permissions to access this internal resource. Access is restricted to authorized agency staff.' }}
        </p>

        <div class="actions">
            @auth
                @if(auth()->user()->isClient())
                    <a href="{{ route('client.dashboard') }}" class="btn btn-primary">Go to Client Portal</a>
                @elseif(auth()->user()->isStaff())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Go to Admin Dashboard</a>
                @endif
            @endauth
            <a href="{{ route('home') }}" class="btn btn-secondary">Return to Homepage</a>
        </div>

        @auth
            <form action="{{ auth()->user()->isStaff() ? route('admin.logout') : route('logout') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="logout-link" style="background: none; border: none; cursor: pointer;">
                    Sign in with a different account &rarr;
                </button>
            </form>
        @endauth
    </div>
</body>
</html>
