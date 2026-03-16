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
        /* ── CSS custom properties: cannot be replaced by Tailwind ── */
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

        /* ── Rules that reference CSS vars or use features Tailwind cannot express ── */
        body { background: var(--bg); color: var(--text); transition: background 0.2s, color 0.2s; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        /* nav-item: one-sided border-radius (0 24px 24px 0) + CSS var colors */
        .nav-item { color: var(--text-2); border-radius: 0 24px 24px 0; transition: all 0.15s; }
        .nav-item:hover { background: var(--bg-hover); color: var(--text); }
        .nav-item.active { background: var(--accent-bg); color: var(--accent); }
        .nav-item svg { opacity: 0.7; }
        .nav-item.active svg { opacity: 1; }
        .nav-badge { color: var(--text-2); background: var(--bg-hover); }
        .nav-item.active .nav-badge { background: var(--accent-bg); color: var(--accent); }
        .nav-badge.red   { background: var(--danger-bg); color: var(--danger); }
        .nav-badge.green { background: var(--green-bg);  color: var(--green); }

        /* cat-select: appearance:none + SVG bg-image */
        .cat-select {
            background-color: var(--bg); color: var(--text);
            border-color: var(--border);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239aa0a6' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
        }
        .cat-select:focus { border-color: var(--accent); }

        /* toggle-pill: ::after pseudo-element */
        .toggle-pill { background: var(--border); transition: background 0.2s; }
        .toggle-pill.on { background: var(--accent); }
        .toggle-pill::after {
            content: ''; position: absolute;
            top: 3px; left: 3px; width: 16px; height: 16px;
            border-radius: 50%; background: #fff;
            transition: left 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .toggle-pill.on::after { left: 21px; }

        /* CSS var colors on interactive elements */
        .hamburger { color: var(--text-2); }
        .hamburger:hover { background: var(--bg-hover); }
        .btn-outline { background: transparent; border-color: var(--border); color: var(--accent); }
        .btn-outline:hover { background: var(--accent-bg); border-color: var(--accent); }
        .btn-filled { background: var(--accent); }
        .btn-filled:hover { background: #1557b0; }
        .btn-text { color: var(--danger); }
        .btn-text:hover { background: var(--danger-bg); }

        /* add-form: :focus-within pseudo-class */
        .add-form { border-color: var(--border); background: var(--bg); transition: border-color 0.15s, box-shadow 0.15s; }
        .add-form:focus-within { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(26,115,232,0.12); }
        .add-input { color: var(--text); }
        .add-input::placeholder { color: var(--text-3); }
        .add-sep { background: var(--border); }
        .add-date-btn { color: var(--text-3); transition: color 0.15s; }
        .add-date-btn:hover { color: var(--accent); }
        .add-cat-select { border-color: var(--border); color: var(--text-2); }
        .add-btn { background: var(--accent); transition: background 0.15s; }
        .add-btn:hover { background: #1557b0; }

        /* cat chips */
        .cat-chip { background: var(--bg-surface); border-color: var(--border); color: var(--text-2); }
        .cat-del-btn { color: var(--text-3); transition: color 0.15s; }
        .cat-del-btn:hover { color: var(--danger); }
        .cat-add-input { border-color: var(--border); background: var(--bg); color: var(--text); transition: border-color 0.15s; }
        .cat-add-input::placeholder { color: var(--text-3); }
        .cat-add-input:focus { border-color: var(--accent); }
        .cat-add-btn { background: var(--accent); transition: background 0.15s; }
        .cat-add-btn:hover { background: #1557b0; }

        /* task items */
        .task-item { border-color: var(--border); transition: background 0.1s; animation: fadeIn 0.15s ease; }
        .task-item:first-child { border-top: 1px solid var(--border); }
        .task-item:hover { background: var(--bg-hover); }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .check-btn { border-color: var(--border); transition: all 0.15s; }
        .check-btn:hover { border-color: var(--accent); color: var(--accent); }
        .check-btn.checked { border-color: var(--green); background: var(--green); color: #fff; }

        .dot-blue   { background: var(--accent); }
        .dot-red    { background: var(--danger); }
        .dot-orange { background: var(--warn); }
        .dot-yellow { background: var(--star); }

        .task-name { color: var(--text); }
        .task-name.done    { color: var(--text-3); }
        .task-name.starred { color: var(--star); }
        .task-due { color: var(--text-3); }
        .task-due.overdue { color: var(--danger); }
        .task-due.done    { color: var(--text-3); }
        .task-cat-tag { background: var(--accent-bg); color: var(--accent-t); }

        /* task-actions: :has() pseudo-class + hover-reveal */
        .task-actions { transition: opacity 0.15s; }
        .task-item:hover .task-actions { opacity: 1; }
        .task-actions:has(.starred-on) { opacity: 1; }

        .icon-btn { color: var(--text-3); transition: background 0.15s, color 0.15s; }
        .icon-btn:hover { background: var(--bg-surface); color: var(--text); }
        .icon-btn.star-btn:hover { color: var(--star); background: none; }
        .icon-btn.edit-btn:hover { color: var(--accent); background: var(--accent-bg); }
        .icon-btn.del-btn:hover  { color: var(--danger); background: var(--danger-bg); }
        .icon-btn.starred-on { color: var(--star); }

        /* stat box */
        .stat-box { background: var(--bg); border-color: var(--border); }
        .stat-num.blue  { color: var(--accent); }
        .stat-num.green { color: var(--green); }
        .stat-num.red   { color: var(--danger); }

        /* modals */
        .modal { background: var(--bg); }
        .modal-title { color: var(--text); }
        .modal-sub   { color: var(--text-3); }
        .modal-close { color: var(--text-3); transition: background 0.15s; }
        .modal-close:hover { background: var(--bg-hover); color: var(--text); }
        .modal-label { color: var(--text-2); }
        .modal-input { border-color: var(--border); background: var(--bg); color: var(--text); transition: border-color 0.15s, box-shadow 0.15s; }
        .modal-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(26,115,232,0.12); }
        .modal-save   { background: var(--accent); transition: background 0.15s; }
        .modal-save:hover { background: #1557b0; }
        .modal-cancel { border-color: var(--border); color: var(--text-2); transition: background 0.15s; }
        .modal-cancel:hover { background: var(--bg-hover); }
        .modal-delete { background: var(--danger); transition: background 0.15s; }
        .modal-delete:hover { background: #c5221f; }

        /* sidebar bg */
        #sidebar { background: var(--bg-sidebar); border-color: var(--border); transition: background 0.2s, border-color 0.2s; }
        header   { background: var(--bg); border-color: var(--border); }

        /* sidebar overlay */
        #sidebarOverlay { display: none; background: rgba(0,0,0,0.4); }
        #sidebarOverlay.visible { display: block; }

        /* sidebar mobile slide */
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed !important;
                top: 56px; left: 0; z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
                height: calc(100vh - 56px) !important;
            }
            #sidebar.open { transform: translateX(0); }
        }
    </style>
</head>

<body class="min-h-screen text-sm leading-relaxed" style="font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;">

    {{-- HEADER --}}
    <header class="sticky top-0 z-[100] h-14 flex items-center justify-between px-4 border-b">
        <div class="flex items-center gap-2">
            <button class="hamburger lg:hidden flex items-center justify-center w-10 h-10 rounded-full border-0 bg-transparent cursor-pointer"
                    id="sidebarToggle" aria-label="Menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <span class="text-lg font-semibold tracking-[-0.3px]" style="color:var(--accent);">TaskFlow</span>
        </div>
        <div class="flex items-center gap-2">
            @auth
                <span class="text-[13px]" style="color:var(--text-2);">{{ auth()->user()->name ?? '' }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn-text inline-flex items-center font-['Inter'] text-[13px] font-medium px-3 py-[6px] rounded border border-transparent bg-transparent cursor-pointer no-underline whitespace-nowrap">Sign out</button>
                </form>
            @else
                <a href="/register" class="btn-outline inline-flex items-center font-['Inter'] text-[13px] font-medium px-4 py-[6px] rounded border cursor-pointer no-underline whitespace-nowrap">Log in</a>
                <a href="/register" class="btn-filled inline-flex items-center font-['Inter'] text-[13px] font-medium px-4 py-[6px] rounded border-0 cursor-pointer no-underline whitespace-nowrap text-white">Register</a>
            @endauth
        </div>
    </header>

    <div id="sidebarOverlay" class="fixed inset-0 z-[49]"></div>

    <div class="flex min-h-[calc(100vh-56px)]">

        {{-- SIDEBAR --}}
        <aside id="sidebar" class="w-64 shrink-0 flex flex-col sticky top-14 h-[calc(100vh-56px)] overflow-y-auto border-r">

            <div class="py-2">
                <span class="block text-[11px] font-semibold uppercase tracking-[0.08em] px-4 pt-2 pb-1" style="color:var(--text-3);">Menu</span>

                <a href="/?filter=all" class="nav-item flex items-center gap-3 px-4 py-[10px] text-sm no-underline mr-2 cursor-pointer font-['Inter'] {{ request('filter') === 'all' ? 'active font-medium' : '' }} filter-link">
                    <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    All Tasks
                    @auth <span class="nav-badge ml-auto text-xs font-medium px-[7px] py-[1px] rounded-[10px] min-w-[22px] text-center">{{ $allPosts->count() }}</span> @endauth
                </a>

                <a href="/?filter=upcoming" class="nav-item flex items-center gap-3 px-4 py-[10px] text-sm no-underline mr-2 cursor-pointer font-['Inter'] {{ request('filter') === 'upcoming' ? 'active font-medium' : '' }} filter-link">
                    <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Upcoming
                    @auth <span class="nav-badge ml-auto text-xs font-medium px-[7px] py-[1px] rounded-[10px] min-w-[22px] text-center">{{ $allPosts->where('dueDate', '>', today())->count() }}</span> @endauth
                </a>

                <a href="/?filter=today" class="nav-item flex items-center gap-3 px-4 py-[10px] text-sm no-underline mr-2 cursor-pointer font-['Inter'] {{ request('filter') === 'today' ? 'active font-medium' : '' }} filter-link">
                    <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Today
                    @auth <span class="nav-badge ml-auto text-xs font-medium px-[7px] py-[1px] rounded-[10px] min-w-[22px] text-center">{{ $allPosts->where('dueDate', today())->count() }}</span> @endauth
                </a>

                <a href="/?filter=overdue" class="nav-item flex items-center gap-3 px-4 py-[10px] text-sm no-underline mr-2 cursor-pointer font-['Inter'] {{ request('filter') === 'overdue' ? 'active font-medium' : '' }} filter-link">
                    <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Overdue
                    @auth <span class="nav-badge red ml-auto text-xs font-medium px-[7px] py-[1px] rounded-[10px] min-w-[22px] text-center">{{ $allPosts->where('dueDate', '<', today())->count() }}</span> @endauth
                </a>

                <a href="/?filter=completed" class="nav-item flex items-center gap-3 px-4 py-[10px] text-sm no-underline mr-2 cursor-pointer font-['Inter'] {{ request('filter') === 'completed' ? 'active font-medium' : '' }} filter-link">
                    <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Completed
                    @auth <span class="nav-badge green ml-auto text-xs font-medium px-[7px] py-[1px] rounded-[10px] min-w-[22px] text-center">{{ $allPosts->where('completed')->count() }}</span> @endauth
                </a>
            </div>

            <div class="h-px mx-4 my-1" style="background:var(--border);"></div>

            <div class="py-2">
                <span class="block text-[11px] font-semibold uppercase tracking-[0.08em] px-4 pt-2 pb-1" style="color:var(--text-3);">Category</span>
                <form method="GET" action="/">
                    <select name="category" onchange="this.form.submit()"
                            class="cat-select block w-[calc(100%-32px)] mx-4 my-1 font-['Inter'] text-[13px] py-2 pl-[10px] pr-7 border rounded outline-none cursor-pointer">
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

            <div class="h-px mx-4 my-1" style="background:var(--border);"></div>

            <div class="flex gap-2 px-4 py-3">
                <div class="stat-box flex-1 border rounded-lg px-2 py-[10px] text-center">
                    <div class="stat-num blue text-xl font-semibold leading-none">{{ count($allPosts) }}</div>
                    <div class="text-[10px] mt-[3px] uppercase tracking-[0.05em]" style="color:var(--text-3);">Total</div>
                </div>
                <div class="stat-box flex-1 border rounded-lg px-2 py-[10px] text-center">
                    <div class="stat-num green text-xl font-semibold leading-none">{{ $allPosts->where('completed')->count() }}</div>
                    <div class="text-[10px] mt-[3px] uppercase tracking-[0.05em]" style="color:var(--text-3);">Done</div>
                </div>
                <div class="stat-box flex-1 border rounded-lg px-2 py-[10px] text-center">
                    <div class="stat-num red text-xl font-semibold leading-none">{{ count($allPosts) - $allPosts->where('completed')->count() }}</div>
                    <div class="text-[10px] mt-[3px] uppercase tracking-[0.05em]" style="color:var(--text-3);">Left</div>
                </div>
            </div>

            <div class="h-px mx-4 my-1" style="background:var(--border);"></div>

            <div class="py-2">
                <span class="block text-[11px] font-semibold uppercase tracking-[0.08em] px-4 pt-2 pb-1" style="color:var(--text-3);">Favourites</span>
                @php $favourites = $allPosts->where('favourite', true); @endphp
                @forelse ($favourites as $fav)
                    <div class="flex items-center gap-[10px] px-4 py-[7px] text-[13px]" style="color:var(--text-2);">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="var(--star)" class="shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="flex-1 min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">{{ $fav->list }}</span>
                        @if($fav->dueDate) <span class="text-[11px] shrink-0" style="color:var(--text-3);">{{ $fav->dueDate->format('d M') }}</span> @endif
                    </div>
                @empty
                    <p class="px-4 py-3 text-[13px]" style="color:var(--text-3);">No favourites yet.</p>
                @endforelse
            </div>

            <div class="mt-auto flex items-center gap-[10px] px-4 py-3 text-[13px] border-t" style="color:var(--text-2); border-color:var(--border);">
                <button class="toggle-pill relative w-10 h-[22px] rounded-[11px] border-0 cursor-pointer shrink-0" id="themeToggle" aria-label="Toggle dark mode"></button>
                <span id="themeLabel">Light mode</span>
                <input type="checkbox" class="hidden" id="themeCheckbox">
            </div>
        </aside>

        {{-- MAIN --}}
        <main class="flex-1 min-w-0 max-w-[800px] p-[32px_40px] max-md:p-[20px_16px]">

            <h1 class="text-[22px] font-semibold mb-1" style="color:var(--text);">My Tasks</h1>
            <p class="text-[13px] mb-6" style="color:var(--text-3);">Stay focused. Get it done.</p>

            @guest
            <div class="flex items-center gap-2 px-[14px] py-[10px] rounded mb-5 text-[13px]" style="background:var(--warn-bg); border:1px solid var(--warn); color:var(--warn);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Sign in or register to add and manage your tasks.
            </div>
            @endguest

            <form action="/create-list" method="POST" class="add-form flex items-center border rounded-lg overflow-hidden mb-5 shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
                @csrf
                <input name="list" type="text" placeholder="Add a task..." autocomplete="off"
                       {{ auth()->guest() ? 'disabled' : '' }}
                       class="add-input flex-1 min-w-0 font-['Inter'] text-sm px-[14px] py-3 bg-transparent border-0 outline-none disabled:opacity-40 disabled:cursor-not-allowed">
                <div class="add-sep w-px h-6 shrink-0"></div>
                <div class="add-date-btn relative flex items-center justify-center w-11 h-11 border-0 bg-transparent cursor-pointer shrink-0" title="Set due date">
                    <input {{ auth()->guest() ? 'disabled' : '' }} type="text" name="dueDate" id="dueDate" class="absolute opacity-0 w-px h-px pointer-events-none">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <select name="category_id" class="add-cat-select font-['Inter'] text-[13px] px-[10px] h-11 bg-transparent border-0 border-l cursor-pointer outline-none min-w-[110px] max-w-[140px]">
                    <option value="">No category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" {{ auth()->guest() ? 'disabled' : '' }}
                        class="add-btn font-['Inter'] text-[13px] font-medium px-5 h-11 border-0 text-white cursor-pointer shrink-0 disabled:opacity-[0.35] disabled:cursor-not-allowed">
                    Add task
                </button>
            </form>

            <div class="flex items-center flex-wrap gap-[6px] mb-5">
                @foreach($categories as $category)
                <span class="cat-chip inline-flex items-center gap-1 text-xs pl-[10px] pr-2 py-[3px] rounded-2xl border">
                    {{ $category->name }}
                    <form method="POST" action="/delete-category/{{ $category->id }}" style="display:inline;line-height:1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cat-del-btn bg-transparent border-0 cursor-pointer p-0 flex items-center text-sm leading-none" title="Remove">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </form>
                </span>
                @endforeach
                <div class="flex items-center gap-[6px] ml-auto">
                    <form action="/create-category" method="POST" class="flex gap-[6px] items-center">
                        @csrf
                        <input type="text" name="name" placeholder="New category"
                               class="cat-add-input font-['Inter'] text-[13px] px-[10px] py-[5px] border rounded w-[130px] outline-none">
                        <button type="submit" class="cat-add-btn font-['Inter'] text-[13px] font-medium px-3 py-[5px] border-0 rounded text-white cursor-pointer whitespace-nowrap">Add</button>
                    </form>
                </div>
            </div>

            <div class="flex items-center gap-2 mb-2">
                <span class="text-[13px] font-semibold uppercase tracking-[0.06em]" style="color:var(--text-2);">Tasks</span>
                <span class="text-xs font-medium px-2 py-[1px] rounded-[10px]" style="color:var(--accent); background:var(--accent-bg);">{{ count($posts) }}</span>
            </div>

            <div id="task-container" class="flex flex-col">
                @include('partials.todo-js')
            </div>
        </main>

    </div>

    {{-- Edit Modal --}}
    <div id="editModal" class="modal-bg hidden fixed inset-0 z-[200] flex items-center justify-center p-4" style="background:rgba(0,0,0,0.5);">
        <div id="editModalBox" class="modal w-full max-w-[440px] relative rounded-lg p-6 shadow-[0_8px_30px_rgba(0,0,0,0.2)]">
            <div class="flex items-start justify-between mb-5">
                <div>
                    <div class="modal-title text-base font-semibold">Edit task</div>
                    <div class="modal-sub text-[13px] mt-[2px]">Update the task details below</div>
                </div>
                <button class="modal-close flex items-center justify-center w-8 h-8 rounded-full bg-transparent border-0 cursor-pointer shrink-0" onclick="closeEditModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <label class="modal-label block text-xs font-medium mb-[6px]">Task name</label>
                <input id="editInput" type="text" name="list" autocomplete="off" class="modal-input w-full font-['Inter'] text-sm px-3 py-[10px] border rounded-md outline-none mb-4" placeholder="Task name...">
                <label class="modal-label block text-xs font-medium mb-[6px]">Due date</label>
                <input {{ auth()->guest() ? 'disabled' : '' }} type="text" name="dueDate" id="editDueDate" class="modal-input w-full font-['Inter'] text-sm px-3 py-[10px] border rounded-md outline-none mb-4" placeholder="Select a date...">
                <div class="flex justify-end gap-2 mt-1">
                    <button type="button" onclick="closeEditModal()" class="modal-cancel font-['Inter'] text-[13px] font-medium px-4 py-2 rounded border bg-transparent cursor-pointer">Cancel</button>
                    <button type="submit" class="modal-save font-['Inter'] text-[13px] font-medium px-5 py-2 rounded border-0 text-white cursor-pointer">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal" class="modal-bg hidden fixed inset-0 z-[200] flex items-center justify-center p-4" style="background:rgba(0,0,0,0.5);">
        <div id="DeleteBox" class="modal w-full max-w-[440px] relative rounded-lg p-6 shadow-[0_8px_30px_rgba(0,0,0,0.2)]">
            <div class="flex items-start justify-between mb-5">
                <div>
                    <div class="modal-title text-base font-semibold">Delete task?</div>
                    <div class="modal-sub text-[13px] mt-[2px]">This action cannot be undone.</div>
                </div>
                <button class="modal-close flex items-center justify-center w-8 h-8 rounded-full bg-transparent border-0 cursor-pointer shrink-0" onclick="closeDeleteModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="flex justify-end gap-2">
                <form id="deleteForm" method="POST" style="display:contents;">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" class="modal-cancel font-['Inter'] text-[13px] font-medium px-4 py-2 rounded border bg-transparent cursor-pointer">Cancel</button>
                    <button type="submit" class="modal-delete font-['Inter'] text-[13px] font-medium px-5 py-2 rounded border-0 text-white cursor-pointer">Delete</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>