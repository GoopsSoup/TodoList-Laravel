<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TaskFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root, [data-theme="light"] {
            --bg:         #ffffff;
            --bg-surface: #f8f9fa;
            --bg-hover:   #f1f3f4;
            --bg-sidebar: #f8f9fa;
            --border:     #e0e0e0;
            --text:       #202124;
            --text-2:     #5f6368;
            --text-3:     #9aa0a6;
            --accent:     #1a73e8;
            --accent-bg:  #e8f0fe;
            --accent-t:   #1a73e8;
            --danger:     #d93025;
            --danger-bg:  #fce8e6;
            --green:      #188038;
            --green-bg:   #e6f4ea;
            --warn:       #e37400;
            --warn-bg:    #fef7e0;
            --star:       #f9ab00;
        }

        [data-theme="dark"] {
            --bg:         #202124;
            --bg-surface: #292a2d;
            --bg-hover:   #35363a;
            --bg-sidebar: #292a2d;
            --border:     #3c4043;
            --text:       #e8eaed;
            --text-2:     #9aa0a6;
            --text-3:     #5f6368;
            --accent:     #8ab4f8;
            --accent-bg:  #1e2a3a;
            --accent-t:   #8ab4f8;
            --danger:     #f28b82;
            --danger-bg:  #2d1f1f;
            --green:      #81c995;
            --green-bg:   #1e2d23;
            --warn:       #fdd663;
            --warn-bg:    #2d2210;
            --star:       #fdd663;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.5;
            transition: background 0.2s, color 0.2s;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        /* ===== NAVBAR ===== */
        header {
            position: sticky;
            top: 0;
            z-index: 100;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
        }

        .header-left { display: flex; align-items: center; gap: 8px; }

        .hamburger {
            display: none;
            align-items: center;
            justify-content: center;
            width: 40px; height: 40px;
            border-radius: 50%;
            background: none; border: none;
            cursor: pointer; color: var(--text-2);
            transition: background 0.15s;
        }
        .hamburger:hover { background: var(--bg-hover); }
        @media (max-width: 1023px) { .hamburger { display: flex; } }

        .logo { font-size: 18px; font-weight: 600; color: var(--accent); letter-spacing: -0.3px; }

        .header-right { display: flex; align-items: center; gap: 8px; }
        .user-name { font-size: 13px; color: var(--text-2); }

        .btn {
            display: inline-flex; align-items: center;
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
            padding: 6px 16px; border-radius: 4px; border: none;
            cursor: pointer; text-decoration: none;
            transition: all 0.15s; white-space: nowrap;
        }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--accent); }
        .btn-outline:hover { background: var(--accent-bg); border-color: var(--accent); }
        .btn-filled { background: var(--accent); color: #fff; }
        .btn-filled:hover { background: #1557b0; }
        .btn-text { background: transparent; border: 1px solid transparent; color: var(--danger); padding: 6px 12px; }
        .btn-text:hover { background: var(--danger-bg); }

        /* ===== LAYOUT ===== */
        .layout { display: flex; min-height: calc(100vh - 56px); }

        /* ===== SIDEBAR ===== */
        #sidebar {
            width: 256px; flex-shrink: 0;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            position: sticky; top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            transition: background 0.2s, border-color 0.2s;
        }

        @media (max-width: 1023px) {
            #sidebar {
                position: fixed; top: 56px; left: 0; z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
            }
            #sidebar.open { transform: translateX(0); }
        }

        #sidebarOverlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.4); z-index: 49;
        }
        #sidebarOverlay.visible { display: block; }

        .sidebar-section { padding: 8px 0; }
        .sidebar-label {
            font-size: 11px; font-weight: 600; color: var(--text-3);
            letter-spacing: 0.08em; text-transform: uppercase;
            padding: 8px 16px 4px; display: block;
        }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 16px; font-size: 14px; color: var(--text-2);
            text-decoration: none;
            border-radius: 0 24px 24px 0; margin-right: 8px;
            transition: all 0.15s; cursor: pointer;
        }
        .nav-item:hover { background: var(--bg-hover); color: var(--text); }
        .nav-item.active { background: var(--accent-bg); color: var(--accent); font-weight: 500; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.7; }
        .nav-item.active svg { opacity: 1; }

        .nav-badge {
            margin-left: auto; font-size: 12px; font-weight: 500;
            color: var(--text-2); background: var(--bg-hover);
            padding: 1px 7px; border-radius: 10px; min-width: 22px; text-align: center;
        }
        .nav-item.active .nav-badge { background: var(--accent-bg); color: var(--accent); }
        .nav-badge.red   { background: var(--danger-bg); color: var(--danger); }
        .nav-badge.green { background: var(--green-bg);  color: var(--green); }

        .sidebar-divider { height: 1px; background: var(--border); margin: 4px 16px; }

        .cat-select {
            display: block; width: calc(100% - 32px); margin: 4px 16px;
            font-family: 'Inter', sans-serif; font-size: 13px;
            padding: 8px 28px 8px 10px;
            border: 1px solid var(--border); border-radius: 4px;
            background: var(--bg); color: var(--text);
            cursor: pointer; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239aa0a6' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 10px center;
        }
        .cat-select:focus { outline: none; border-color: var(--accent); }

        .stats-row { display: flex; gap: 8px; padding: 12px 16px; }
        .stat-box {
            flex: 1; background: var(--bg);
            border: 1px solid var(--border); border-radius: 8px;
            padding: 10px 8px; text-align: center;
        }
        .stat-num { font-size: 20px; font-weight: 600; line-height: 1; }
        .stat-num.blue  { color: var(--accent); }
        .stat-num.green { color: var(--green); }
        .stat-num.red   { color: var(--danger); }
        .stat-lbl { font-size: 10px; color: var(--text-3); margin-top: 3px; text-transform: uppercase; letter-spacing: 0.05em; }

        .fav-item { display: flex; align-items: center; gap: 10px; padding: 7px 16px; font-size: 13px; color: var(--text-2); }
        .fav-text { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .fav-date { font-size: 11px; color: var(--text-3); flex-shrink: 0; }
        .no-fav { padding: 12px 16px; font-size: 13px; color: var(--text-3); }

        .sidebar-footer {
            margin-top: auto; padding: 12px 16px;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; gap: 10px;
            font-size: 13px; color: var(--text-2);
        }
        .toggle-pill {
            position: relative; width: 40px; height: 22px;
            border-radius: 11px; background: var(--border);
            cursor: pointer; transition: background 0.2s;
            flex-shrink: 0; border: none;
        }
        .toggle-pill.on { background: var(--accent); }
        .toggle-pill::after {
            content: ''; position: absolute;
            top: 3px; left: 3px; width: 16px; height: 16px;
            border-radius: 50%; background: #fff;
            transition: left 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .toggle-pill.on::after { left: 21px; }
        .theme-checkbox { display: none; }

        /* ===== MAIN ===== */
        main { flex: 1; min-width: 0; padding: 32px 40px; max-width: 800px; }
        @media (max-width: 768px) { main { padding: 20px 16px; } }

        .page-heading { font-size: 22px; font-weight: 600; color: var(--text); margin-bottom: 4px; }
        .page-sub { font-size: 13px; color: var(--text-3); margin-bottom: 24px; }

        .guest-notice {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 14px; background: var(--warn-bg);
            border: 1px solid var(--warn); border-radius: 6px;
            font-size: 13px; color: var(--warn); margin-bottom: 20px;
        }

        /* ===== ADD FORM ===== */
        .add-form {
            display: flex; align-items: center;
            border: 1px solid var(--border); border-radius: 8px;
            background: var(--bg); overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .add-form:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(26,115,232,0.12);
        }
        .add-input {
            flex: 1; min-width: 0;
            font-family: 'Inter', sans-serif; font-size: 14px;
            padding: 12px 14px; background: transparent;
            border: none; outline: none; color: var(--text);
        }
        .add-input::placeholder { color: var(--text-3); }
        .add-input:disabled { opacity: 0.4; cursor: not-allowed; }

        .add-sep { width: 1px; height: 24px; background: var(--border); flex-shrink: 0; }

        .add-date-btn {
            display: flex; align-items: center; justify-content: center;
            width: 44px; height: 44px;
            background: none; border: none; color: var(--text-3);
            cursor: pointer; flex-shrink: 0; transition: color 0.15s;
            position: relative;
        }
        .add-date-btn:hover { color: var(--accent); }
        .date-input-hidden { position: absolute; opacity: 0; width: 1px; height: 1px; pointer-events: none; }

        .add-cat-select {
            font-family: 'Inter', sans-serif; font-size: 13px;
            padding: 0 10px; height: 44px;
            background: none; border: none;
            border-left: 1px solid var(--border);
            color: var(--text-2); cursor: pointer; outline: none;
            min-width: 110px; max-width: 140px;
        }

        .add-btn {
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
            padding: 0 20px; height: 44px;
            background: var(--accent); border: none;
            color: #fff; cursor: pointer; flex-shrink: 0;
            transition: background 0.15s;
        }
        .add-btn:hover { background: #1557b0; }
        .add-btn:disabled { opacity: 0.35; cursor: not-allowed; }

        /* ===== CATEGORY BAR ===== */
        .cat-bar {
            display: flex; align-items: center;
            flex-wrap: wrap; gap: 6px; margin-bottom: 20px;
        }
        .cat-chip {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 12px; padding: 3px 8px 3px 10px;
            border-radius: 16px; background: var(--bg-surface);
            border: 1px solid var(--border); color: var(--text-2);
        }
        .cat-del-btn {
            background: none; border: none; cursor: pointer;
            color: var(--text-3); font-size: 14px; line-height: 1;
            padding: 0; transition: color 0.15s; display: flex; align-items: center;
        }
        .cat-del-btn:hover { color: var(--danger); }
        .cat-add-wrap { display: flex; align-items: center; gap: 6px; margin-left: auto; }
        .cat-add-input {
            font-family: 'Inter', sans-serif; font-size: 13px;
            padding: 5px 10px; border: 1px solid var(--border);
            border-radius: 4px; background: var(--bg); color: var(--text);
            width: 130px; outline: none; transition: border-color 0.15s;
        }
        .cat-add-input::placeholder { color: var(--text-3); }
        .cat-add-input:focus { border-color: var(--accent); }
        .cat-add-btn {
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
            padding: 5px 12px; background: var(--accent); border: none;
            border-radius: 4px; color: #fff; cursor: pointer; white-space: nowrap;
            transition: background 0.15s;
        }
        .cat-add-btn:hover { background: #1557b0; }

        /* ===== LIST HEADER ===== */
        .list-header { display: flex; align-items: center; margin-bottom: 8px; gap: 8px; }
        .list-title { font-size: 13px; font-weight: 600; color: var(--text-2); text-transform: uppercase; letter-spacing: 0.06em; }
        .list-count { font-size: 12px; font-weight: 500; color: var(--accent); background: var(--accent-bg); padding: 1px 8px; border-radius: 10px; }

        /* ===== TASK ITEMS ===== */
        #task-container { display: flex; flex-direction: column; }

        .task-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            transition: background 0.1s;
            animation: fadeIn 0.15s ease;
        }
        .task-item:first-child { border-top: 1px solid var(--border); }
        .task-item:hover { background: var(--bg-hover); }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .check-form { display: flex; align-items: center; }
        .check-btn {
            width: 18px; height: 18px; border-radius: 50%;
            border: 2px solid var(--border); background: none;
            cursor: pointer; display: flex; align-items: center;
            justify-content: center; color: transparent; flex-shrink: 0;
            transition: all 0.15s;
        }
        .check-btn:hover { border-color: var(--accent); color: var(--accent); }
        .check-btn.checked { border-color: var(--green); background: var(--green); color: #fff; }

        .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .dot-blue   { background: var(--accent); }
        .dot-red    { background: var(--danger); }
        .dot-orange { background: var(--warn); }
        .dot-yellow { background: var(--star); }

        .task-body { flex: 1; min-width: 0; }
        .task-name { font-size: 14px; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .task-name.done    { text-decoration: line-through; color: var(--text-3); }
        .task-name.starred { color: var(--star); }

        .task-meta { display: flex; align-items: center; gap: 8px; margin-top: 2px; }
        .task-due { font-size: 12px; color: var(--text-3); }
        .task-due.overdue { color: var(--danger); }
        .task-due.done    { text-decoration: line-through; color: var(--text-3); }
        .task-cat-tag { font-size: 11px; padding: 1px 7px; border-radius: 10px; background: var(--accent-bg); color: var(--accent-t); }

        .task-actions { display: flex; align-items: center; gap: 2px; opacity: 0; transition: opacity 0.15s; }
        .task-item:hover .task-actions { opacity: 1; }
        /* Always show if starred */
        .task-actions:has(.starred-on) { opacity: 1; }

        .icon-btn {
            display: flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 50%;
            background: none; border: none; cursor: pointer;
            color: var(--text-3); transition: background 0.15s, color 0.15s;
        }
        .icon-btn:hover { background: var(--bg-surface); color: var(--text); }
        .icon-btn.star-btn:hover { color: var(--star); }
        .icon-btn.edit-btn:hover { color: var(--accent); background: var(--accent-bg); }
        .icon-btn.del-btn:hover  { color: var(--danger); background: var(--danger-bg); }
        .icon-btn.starred-on { color: var(--star); }

        .empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 64px 20px; text-align: center; }
        .empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--accent-bg); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; color: var(--accent); }
        .empty-title { font-size: 15px; font-weight: 500; color: var(--text-2); margin-bottom: 4px; }
        .empty-sub   { font-size: 13px; color: var(--text-3); }

        /* ===== MODALS ===== */
        .modal-bg {
            position: fixed; inset: 0; background: rgba(0,0,0,0.5);
            z-index: 200; display: flex; align-items: center;
            justify-content: center; padding: 16px;
        }
        .modal-bg.hidden { display: none; }
        .modal {
            background: var(--bg); border-radius: 8px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            padding: 24px; width: 100%; max-width: 440px; position: relative;
        }
        .modal-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px; }
        .modal-title { font-size: 16px; font-weight: 600; color: var(--text); }
        .modal-sub   { font-size: 13px; color: var(--text-3); margin-top: 2px; }
        .modal-close {
            display: flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 50%;
            background: none; border: none; cursor: pointer;
            color: var(--text-3); transition: background 0.15s; flex-shrink: 0;
        }
        .modal-close:hover { background: var(--bg-hover); color: var(--text); }
        .modal-label { display: block; font-size: 12px; font-weight: 500; color: var(--text-2); margin-bottom: 6px; }
        .modal-input {
            width: 100%; font-family: 'Inter', sans-serif; font-size: 14px;
            padding: 10px 12px; border: 1px solid var(--border); border-radius: 6px;
            background: var(--bg); color: var(--text); outline: none; margin-bottom: 16px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .modal-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(26,115,232,0.12); }
        .modal-actions { display: flex; justify-content: flex-end; gap: 8px; margin-top: 4px; }
        .modal-save {
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
            padding: 8px 20px; background: var(--accent); border: none;
            border-radius: 4px; color: #fff; cursor: pointer; transition: background 0.15s;
        }
        .modal-save:hover { background: #1557b0; }
        .modal-cancel {
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
            padding: 8px 16px; background: none; border: 1px solid var(--border);
            border-radius: 4px; color: var(--text-2); cursor: pointer; transition: background 0.15s;
        }
        .modal-cancel:hover { background: var(--bg-hover); }
        .modal-delete {
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
            padding: 8px 20px; background: var(--danger); border: none;
            border-radius: 4px; color: #fff; cursor: pointer; transition: background 0.15s;
        }
        .modal-delete:hover { background: #c5221f; }
    </style>
</head>

<body>

    <header>
        <div class="header-left">
            <button class="hamburger" id="sidebarToggle" aria-label="Menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <span class="logo">TaskFlow</span>
        </div>
        <div class="header-right">
            @auth
                <span class="user-name">{{ auth()->user()->name ?? '' }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-text">Sign out</button>
                </form>
            @else
                <a href="/register" class="btn btn-outline">Log in</a>
                <a href="/register" class="btn btn-filled">Register</a>
            @endauth
        </div>
    </header>

    <div id="sidebarOverlay"></div>

    <div class="layout">

        <aside id="sidebar">
            <div class="sidebar-section">
                <span class="sidebar-label">Menu</span>

                <a href="/?filter=all" class="nav-item {{ request('filter') === 'all' ? 'active' : '' }} filter-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    All Tasks
                    @auth <span class="nav-badge">{{ $allPosts->count() }}</span> @endauth
                </a>

                <a href="/?filter=upcoming" class="nav-item {{ request('filter') === 'upcoming' ? 'active' : '' }} filter-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Upcoming
                    @auth <span class="nav-badge">{{ $allPosts->where('dueDate', '>', today())->count() }}</span> @endauth
                </a>

                <a href="/?filter=today" class="nav-item {{ request('filter') === 'today' ? 'active' : '' }} filter-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Today
                    @auth <span class="nav-badge">{{ $allPosts->where('dueDate', today())->count() }}</span> @endauth
                </a>

                <a href="/?filter=overdue" class="nav-item {{ request('filter') === 'overdue' ? 'active' : '' }} filter-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Overdue
                    @auth <span class="nav-badge red">{{ $allPosts->where('dueDate', '<', today())->count() }}</span> @endauth
                </a>

                <a href="/?filter=completed" class="nav-item {{ request('filter') === 'completed' ? 'active' : '' }} filter-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Completed
                    @auth <span class="nav-badge green">{{ $allPosts->where('completed')->count() }}</span> @endauth
                </a>
            </div>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section">
                <span class="sidebar-label">Category</span>
                <form method="GET" action="/">
                    <select name="category" onchange="this.form.submit()" class="cat-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="filter" value="category">
                </form>
            </div>

            <div class="sidebar-divider"></div>

            <div class="stats-row">
                <div class="stat-box">
                    <div class="stat-num blue">{{ count($allPosts) }}</div>
                    <div class="stat-lbl">Total</div>
                </div>
                <div class="stat-box">
                    <div class="stat-num green">{{ $allPosts->where('completed')->count() }}</div>
                    <div class="stat-lbl">Done</div>
                </div>
                <div class="stat-box">
                    <div class="stat-num red">{{ count($allPosts) - $allPosts->where('completed')->count() }}</div>
                    <div class="stat-lbl">Left</div>
                </div>
            </div>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section">
                <span class="sidebar-label">Favourites</span>
                @php $favourites = $allPosts->where('favourite', true); @endphp
                @forelse ($favourites as $fav)
                    <div class="fav-item">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="var(--star)" style="flex-shrink:0;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="fav-text">{{ $fav->list }}</span>
                        @if($fav->dueDate) <span class="fav-date">{{ $fav->dueDate->format('d M') }}</span> @endif
                    </div>
                @empty
                    <p class="no-fav">No favourites yet.</p>
                @endforelse
            </div>

            <div class="sidebar-footer">
                <button class="toggle-pill" id="themeToggle" aria-label="Toggle dark mode"></button>
                <span id="themeLabel">Light mode</span>
                <input type="checkbox" class="theme-checkbox" id="themeCheckbox">
            </div>
        </aside>

        <main>
            <h1 class="page-heading">My Tasks</h1>
            <p class="page-sub">Stay focused. Get it done.</p>

            @guest
            <div class="guest-notice">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Sign in or register to add and manage your tasks.
            </div>
            @endguest

            <form action="/create-list" method="POST" class="add-form">
                @csrf
                <input name="list" type="text" placeholder="Add a task..." autocomplete="off" {{ auth()->guest() ? 'disabled' : '' }} class="add-input">
                <div class="add-sep"></div>
                <div class="add-date-btn" title="Set due date">
                    <input {{ auth()->guest() ? 'disabled' : '' }} type="text" name="dueDate" id="dueDate" class="date-input-hidden">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <select name="category_id" class="add-cat-select">
                    <option value="">No category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" {{ auth()->guest() ? 'disabled' : '' }} class="add-btn">Add task</button>
            </form>

            <div class="cat-bar">
                @foreach($categories as $category)
                <span class="cat-chip">
                    {{ $category->name }}
                    <form method="POST" action="/delete-category/{{ $category->id }}" style="display:inline;line-height:1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cat-del-btn" title="Remove">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </form>
                </span>
                @endforeach
                <div class="cat-add-wrap">
                    <form action="/create-category" method="POST" style="display:flex;gap:6px;align-items:center;">
                        @csrf
                        <input type="text" name="name" placeholder="New category" class="cat-add-input">
                        <button type="submit" class="cat-add-btn">Add</button>
                    </form>
                </div>
            </div>

            <div class="list-header">
                <span class="list-title">Tasks</span>
                <span class="list-count">{{ count($posts) }}</span>
            </div>

            <div id="task-container">
                @include('partials.todo-js')
            </div>
        </main>

    </div>

    {{-- Edit Modal --}}
    <div id="editModal" class="modal-bg hidden">
        <div id="editModalBox" class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Edit task</div>
                    <div class="modal-sub">Update the task details below</div>
                </div>
                <button class="modal-close" onclick="closeEditModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <label class="modal-label">Task name</label>
                <input id="editInput" type="text" name="list" autocomplete="off" class="modal-input" placeholder="Task name...">
                <label class="modal-label">Due date</label>
                <input {{ auth()->guest() ? 'disabled' : '' }} type="text" name="dueDate" id="editDueDate" class="modal-input" placeholder="Select a date...">
                <div class="modal-actions">
                    <button type="button" onclick="closeEditModal()" class="modal-cancel">Cancel</button>
                    <button type="submit" class="modal-save">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal" class="modal-bg hidden">
        <div id="DeleteBox" class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Delete task?</div>
                    <div class="modal-sub">This action cannot be undone.</div>
                </div>
                <button class="modal-close" onclick="closeDeleteModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="modal-actions">
                <form id="deleteForm" method="POST" style="display:contents;">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" class="modal-cancel">Cancel</button>
                    <button type="submit" class="modal-delete">Delete</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>