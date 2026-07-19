<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jejak Karbon') — Carbon Tracker</title>
    <meta name="description" content="Pantau dan kurangi jejak karbon harianmu dengan mudah.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --color-primary: #16a34a;
            --color-primary-dark: #15803d;
            --color-primary-light: #dcfce7;
            --color-bg: #f0fdf4;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }
        .gradient-hero {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 100%);
        }
        .card-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.6);
        }
        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.625rem;
            font-size: 0.9rem;
            background: #f8fafc;
            color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22,163,74,0.15);
            background: #ffffff;
        }
        .btn-primary {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.625rem;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(22,163,74,0.35);
        }
        .btn-primary:active { transform: translateY(0); }
        .btn-outline {
            background: transparent;
            color: #475569;
            padding: 0.75rem 1.5rem;
            border-radius: 0.625rem;
            font-weight: 500;
            font-size: 0.9rem;
            border: 1.5px solid #cbd5e1;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
        }
        .btn-outline:hover { background: #f1f5f9; border-color: #94a3b8; }
        .fade-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .slide-up { animation: slideUp 0.4s ease-out forwards; }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px; }
    </style>
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>