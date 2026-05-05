<!DOCTYPE html>
<html lang="{{ session('locale', 'en') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Creator File Storage')</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: "Segoe UI", Arial, sans-serif; background: #0f172a; color: white; }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        .site-nav { background: #111827; }
        .nav-inner { max-width: 1120px; margin: 0 auto; padding: 20px 5%; display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; }
        .brand { font-weight: 800; font-size: 22px; }
        .brand span { color: inherit; }
        .nav-links { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .nav-links a, .nav-links button { color: #cbd5e1; border: 1px solid transparent; background: transparent; padding: 7px 10px; border-radius: 6px; font: inherit; cursor: pointer; }
        .nav-links a:hover, .nav-links button:hover, .nav-links .active { color: white; background: #1e293b; }
        .nav-links .primary { background: #6366f1; color: white; font-weight: 700; border-color: #6366f1; }
        .nav-links .primary:hover { background: #4f46e5; color: white; }
        .hamburger { display: none; background: transparent; border: 1px solid #475569; color: #cbd5e1; border-radius: 6px; padding: 7px 12px; cursor: pointer; }
        .lang-dropdown { position: relative; }
        .lang-toggle { color: #cbd5e1; border: 1px solid #334155; background: transparent; border-radius: 6px; padding: 7px 10px; cursor: pointer; }
        .lang-menu { display: none; position: absolute; right: 0; top: calc(100% + 8px); min-width: 135px; background: #1e293b; border: 1px solid #334155; border-radius: 8px; overflow: hidden; z-index: 30; }
        .lang-dropdown.open .lang-menu { display: block; }
        .lang-menu a { display: block; border-radius: 0; padding: 10px 12px; }
        .role-chip { background:#6366f122;color:#818cf8;padding:5px 11px;border-radius:20px;font-size:13px;border:1px solid #6366f144; }
        .shell { max-width: 1100px; margin: 0 auto; padding: 40px 5% 70px; }
        .hero { min-height: 56vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        h1 { margin: 0; font-size: clamp(28px, 5vw, 44px); line-height: 1.15; letter-spacing: 0; }
        h2 { margin: 0 0 16px; font-size: clamp(22px, 3vw, 30px); }
        h3 { margin: 0 0 8px; }
        p { color: #94a3b8; line-height: 1.65; }
        .eyebrow { color: #818cf8; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; font-weight: 800; margin-bottom: 12px; }
        .actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 24px; justify-content: center; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 6px; border: 1px solid #334155; padding: 11px 16px; color: white; background: #1e293b; font-weight: 700; cursor: pointer; }
        .btn.primary { background: #6366f1; color: white; border-color: #6366f1; }
        .btn.primary:hover { background: #4f46e5; }
        .btn.danger { border-color: #ef4444; color: #fecaca; }
        .visual { width: 100%; max-width: 760px; margin-top: 32px; border: 1px solid #334155; border-radius: 12px; background: #1e293b; padding: 22px; display: grid; gap: 14px; }
        .visual-row { height: 64px; border-radius: 8px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.1); display: flex; align-items: center; justify-content: space-between; padding: 0 16px; }
        .pill { display: inline-flex; padding: 4px 10px; border-radius: 999px; background: #6366f122; color: #818cf8; font-size: 12px; font-weight: 700; }
        .grid { display: grid; gap: 18px; }
        .grid.three { grid-template-columns: repeat(3, 1fr); }
        .grid.two { grid-template-columns: repeat(2, 1fr); }
        .grid.four-role { grid-template-columns: repeat(4, 1fr); }
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 24px; transition: .2s; }
        a.card:hover { transform: translateY(-3px); border-color: #6366f1; }
        .card.soft { background: #1e293b; }
        .section { margin-top: 42px; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-top: 28px; }
        .stat { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 18px; text-align: center; }
        .stat strong { display: block; font-size: 28px; color: #fff; }
        .stat span { color: #94a3b8; font-size: 13px; }
        .table-wrap { overflow-x: auto; border: 1px solid #334155; border-radius: 12px; background: #1e293b; }
        table { width: 100%; border-collapse: collapse; min-width: 660px; }
        th, td { text-align: left; padding: 14px 16px; border-top: 1px solid #334155; }
        th { border-top: 0; color: #94a3b8; background: #0f172a; font-size: 13px; }
        td { color: #e2e8f0; }
        .form-card { max-width: 500px; margin: 0 auto; }
        .link-button { border: 0; background: transparent; color: #818cf8; font: inherit; font-weight: 700; cursor: pointer; padding: 0; text-decoration: underline; }
        .link-button:hover { color: white; }
        label { display: block; color: #cbd5e1; font-size: 13px; font-weight: 700; margin-bottom: 7px; }
        input, select, textarea { width: 100%; border: 1px solid #475569; background: #0f172a; color: #fff; border-radius: 6px; padding: 12px; font: inherit; }
        textarea { min-height: 120px; resize: vertical; }
        .field { margin-bottom: 16px; }
        .split-auth { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start; }
        .alert { border-radius: 8px; padding: 14px 16px; margin-bottom: 18px; text-align: center; }
        .alert.success { background: #10b98122; color: #86efac; border: 1px solid #10b98166; }
        .alert.error { background: #ef444422; color: #fecaca; border: 1px solid #ef444466; }
        .muted { color: #94a3b8; }
        .detail-list { display: grid; gap: 12px; }
        .detail-list div { display: flex; justify-content: space-between; gap: 18px; padding: 12px 0; border-bottom: 1px solid #334155; }
        .footer { border-top: 1px solid #334155; color: #64748b; text-align: center; padding: 26px 20px; background:#111827; }
        @media (max-width: 820px) {
            .grid.two, .grid.three, .grid.four-role, .split-auth { grid-template-columns: 1fr; }
            .stats { grid-template-columns: repeat(2, 1fr); }
            .nav-inner { align-items: stretch; }
            .nav-top { width: 100%; display: flex; justify-content: space-between; align-items: center; }
            .hamburger { display: inline-flex; }
            .nav-links { display: none; flex-direction: column; align-items: stretch; width: 100%; }
            .nav-links.open { display: flex; }
            .nav-links a, .nav-links button, .lang-toggle { width: 100%; text-align: left; }
            .lang-menu { position: static; margin-top: 6px; }
        }
        @media (max-width: 520px) {
            .stats { grid-template-columns: 1fr; }
            .nav-links { width: 100%; }
            .nav-links a, .nav-links button { padding: 8px; }
        }
    </style>
</head>
<body>
    <nav class="site-nav">
        <div class="nav-inner">
            <div class="nav-top">
                <a class="brand" href="{{ route('home') }}">{{ __('Creator File Storage') }}</a>
                <button class="hamburger" type="button" onclick="document.getElementById('navLinks').classList.toggle('open')">{{ __('Menu') }}</button>
            </div>
            <div class="nav-links" id="navLinks">
                <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                <a class="{{ request()->routeIs('library') || request()->routeIs('details') ? 'active' : '' }}" href="{{ route('library') }}">{{ __('Library') }}</a>
                @if(in_array(session('user_role'), ['admin', 'creator']))
                    <a class="{{ request()->routeIs('file.upload.show') ? 'active' : '' }}" href="{{ route('file.upload.show') }}">{{ __('Upload') }}</a>
                @endif
                @if(session('logged_in'))
                    <a class="{{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">{{ __('Profile') }}</a>
                    <span class="role-chip">{{ __(ucfirst(session('user_role') ?? 'viewer')) }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit">{{ __('Logout') }}</button>
                    </form>
                @else
                    <a class="primary {{ request()->routeIs('midterm') ? 'active' : '' }}" href="{{ route('midterm') }}">{{ __('Login / Register') }}</a>
                @endif
                @php
                    $locale = session('locale', 'en');
                    $labels = ['en' => 'EN', 'ru' => 'RU', 'kk' => 'KZ'];
                @endphp
                <div class="lang-dropdown" id="langDropdown">
                    <button class="lang-toggle" type="button" onclick="document.getElementById('langDropdown').classList.toggle('open')">
                        {{ $labels[$locale] ?? 'EN' }}
                    </button>
                    <div class="lang-menu">
                        <a href="{{ route('lang.switch', 'en') }}" class="{{ $locale === 'en' ? 'active' : '' }}">{{ __('EN - English') }}</a>
                        <a href="{{ route('lang.switch', 'ru') }}" class="{{ $locale === 'ru' ? 'active' : '' }}">{{ __('RU - Russian') }}</a>
                        <a href="{{ route('lang.switch', 'kk') }}" class="{{ $locale === 'kk' ? 'active' : '' }}">{{ __('KZ - Kazakh') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="shell">
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="footer">{{ __('Creator File Storage stores presets, LUTs, and project files for editors, photographers, and content creators.') }}</footer>
    <script>
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('langDropdown');
            if (dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.remove('open');
            }
        });
    </script>
</body>
</html>
