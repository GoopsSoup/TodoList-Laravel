<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TaskFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }

        .sidebar-scroll::-webkit-scrollbar { width: 3px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 10px; }

        .task-scroll::-webkit-scrollbar { width: 4px; }
        .task-scroll::-webkit-scrollbar-thumb { background: rgba(124,109,250,0.3); border-radius: 10px; }

        .task-input:focus { box-shadow: 0 0 0 2px rgba(124,109,250,0.45), 0 0 30px rgba(124,109,250,0.12); }

        .task-card { transition: border-color 0.2s, transform 0.15s, box-shadow 0.2s; }
        .task-card:hover { transform: translateY(-1px); }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .task-card { animation: slideIn 0.25s ease both; }

        .orb-1 {
            position: fixed; pointer-events: none; z-index: 0;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(124,109,250,0.10) 0%, transparent 70%);
            top: -150px; left: 80px;
        }
        .orb-2 {
            position: fixed; pointer-events: none; z-index: 0;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(250,109,154,0.07) 0%, transparent 70%);
            bottom: -80px; right: 40px;
        }

        #sidebar { transition: transform 0.3s ease; }
        #sidebarOverlay { transition: opacity 0.3s ease; }
    </style>
</head>

<body class="bg-[#0d0d12] text-[#f0eff8] min-h-screen">

    <div class="orb-1"></div>
    <div class="orb-2"></div>

    {{-- ===== NAVBAR ===== --}}
    <header class="sticky top-0 z-50 flex items-center justify-between px-4 md:px-6 h-14 bg-[#0d0d12]/80 backdrop-blur-xl border-b border-white/6">
        <div class="flex items-center gap-3">
            <button id="sidebarToggle" class="lg:hidden flex flex-col gap-1.25 p-1.5 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                <span class="w-5 h-0.5 bg-white/50 rounded"></span>
                <span class="w-5 h-0.5 bg-white/50 rounded"></span>
                <span class="w-3.5 h-0.5 bg-white/50 rounded"></span>
            </button>
            <span class="font-display font-extrabold text-[1.1rem] bg-linear-to-r from-[#7c6dfa] to-[#fa6d9a] bg-clip-text text-transparent tracking-tight">
                TaskFlow
            </span>
        </div>

        <div class="flex items-center gap-2">
            @auth
            <span class="hidden sm:block text-xs text-white/25 mr-1">{{ auth()->user()->name ?? '' }}</span>
            <form action="/logout" method="POST">
                @csrf
                <button class="font-display text-xs font-bold tracking-wide text-[#f87171] px-3.5 py-1.5 rounded-lg border border-[#f87171]/20 bg-[#f87171]/5 hover:bg-[#f87171]/15 transition-colors cursor-pointer">
                    Sign out
                </button>
            </form>
            @else
            <a href="/register" class="font-display text-xs font-bold tracking-wide text-white/35 px-3.5 py-1.5 rounded-lg border border-white/[0.07] hover:text-white/60 hover:border-white/15 transition-colors">
                Log in
            </a>
            <a href="/register" class="font-display text-xs font-bold tracking-wide text-white px-3.5 py-1.5 rounded-lg bg-[#7c6dfa] hover:bg-[#6b5ce7] transition-colors">
                Register
            </a>
            @endauth
        </div>
    </header>

    {{-- Mobile overlay --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 opacity-0 pointer-events-none lg:hidden"></div>

    <div class="relative z-10 flex min-h-[calc(100vh-3.5rem)]">

        {{-- ===== SIDEBAR ===== --}}
        <aside id="sidebar"
            class="fixed lg:sticky top-14 left-0 h-[calc(100vh-3.5rem)] w-64 bg-[#111118] border-r border-white/6 flex flex-col z-40 -translate-x-full lg:translate-x-0 sidebar-scroll overflow-y-auto">

            <nav class="flex-1 p-3 space-y-0.5">

                {{-- Main nav --}}
                <p class="font-display text-[10px] font-bold uppercase tracking-widest text-white/20 px-2 pt-3 pb-2">Menu</p>

                <a href="#" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg bg-[#7c6dfa]/10 text-[#7c6dfa] text-sm font-medium">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    All Tasks
                    <span class="ml-auto text-[10px] font-display font-bold bg-[#7c6dfa]/20 text-[#7c6dfa] px-1.5 py-0.5 rounded-full">
                        {{ count($posts) }}
                    </span>
                </a>

                <a href="#" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-white/35 hover:text-white/65 hover:bg-white/4 text-sm transition-colors">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Today
                </a>

                <a href="#" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-white/35 hover:text-white/65 hover:bg-white/4 text-sm transition-colors">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Upcoming
                </a>

                <a href="#" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-white/35 hover:text-white/65 hover:bg-white/4 text-sm transition-colors">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    In Progress
                    <span class="ml-auto text-[10px] font-display font-bold bg-[#fa6d9a]/10 text-[#fa6d9a] px-1.5 py-0.5 rounded-full">3</span>
                </a>

                <a href="#" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-white/35 hover:text-white/65 hover:bg-white/4 text-sm transition-colors">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Completed
                </a>

                <div class="border-t border-white/5 my-2"></div>

                {{-- Favourites section --}}
                <div class="flex items-center justify-between px-2 pt-1.5 pb-1">
                    <p class="font-display text-[10px] font-bold uppercase tracking-widest text-white/20">Favourites</p>
                    <button title="Coming soon" class="text-white/15 hover:text-[#fa6d9a] transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </button>
                </div>

                {{-- Placeholder fav lists --}}
                <div class="space-y-0.5 opacity-50">
                    <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-white/30 text-sm">
                        <svg class="w-3.5 h-3.5 text-[#fa6d9a]/50 shrink-0" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="truncate">Work Tasks</span>
                        <span class="ml-auto text-[10px] text-white/15">5</span>
                    </div>
                    <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-white/30 text-sm">
                        <svg class="w-3.5 h-3.5 text-[#fa6d9a]/50 shrink-0" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="truncate">Personal Goals</span>
                        <span class="ml-auto text-[10px] text-white/15">2</span>
                    </div>
                    <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-white/30 text-sm">
                        <svg class="w-3.5 h-3.5 text-[#fa6d9a]/50 fshrink-0" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="truncate">Shopping</span>
                        <span class="ml-auto text-[10px] text-white/15">8</span>
                    </div>
                </div>

                <div class="mx-2 mt-2 px-3 py-2 rounded-lg border border-dashed border-white/8 text-center">
                    <p class="text-[10px] text-white/18 font-display uppercase tracking-wider">Favourites coming soon</p>
                </div>

            </nav>

            {{-- Sidebar footer --}}
            <div class="p-3 border-t border-white/5">
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-white/22 hover:text-white/45 hover:bg-white/4 text-sm transition-colors">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                    Settings
                </a>
            </div>
        </aside>

        {{-- ===== MAIN ===== --}}
        <main class="flex-1 min-w-0 p-5 md:p-8 lg:p-10">
            <div class="max-w-5xl mx-auto min-h-[130vh]">

                <div class="mb-8">
                    <h1 class="font-display font-extrabold text-3xl md:text-4xl tracking-tight mb-1">All Tasks</h1>
                    <p class="text-white/30 text-sm">Stay focused. Get it done.</p>
                </div>

                @guest
                <div class="flex items-center gap-2.5 px-4 py-3 mb-6 rounded-xl border border-[#fa6d9a]/20 bg-[#fa6d9a]/5 text-[#fa6d9a]/75 text-sm">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Sign in or register to add and manage your tasks.
                </div>
                @endguest

                {{-- Add task --}}
                <form action="/create-list" method="POST"
                    class="flex h-12 mb-7 rounded-xl overflow-hidden border border-white/[0.07] bg-[#13131a] focus-within:border-[#7c6dfa]/50 transition-all duration-200">
                    @csrf
                    <input
                        name="list"
                        type="text"
                        placeholder="What needs to be done?"
                        autocomplete="off"
                        {{ auth()->guest() ? 'disabled' : '' }}
                        class="task-input flex-1 bg-transparent border-none outline-none px-4 text-sm text-white placeholder-white/20 disabled:opacity-35 disabled:cursor-not-allowed transition-shadow duration-200"
                    >
                    {{-- due date --}}
                    <input
                     {{ auth()->guest() ? 'disabled' : '' }}
                     type="date" 
                     name="dueDate"
                    >

                    <button
                        type="submit"
                        {{ auth()->guest() ? 'disabled' : '' }}
                        class="font-display font-bold text-[11px] tracking-widest uppercase bg-[#7c6dfa] hover:bg-[#6b5ce7] disabled:opacity-35 disabled:cursor-not-allowed text-white px-5 transition-colors cursor-pointer shrink-0">
                        + Add
                    </button>
                </form>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-3 mb-7 min-h-40 ">
                    <div class="bg-[#13131a] border border-white/6 rounded-xl p-3.5 text-center flex flex-col justify-center">
                        <p class="font-display font-extrabold text-4xl text-[#7c6dfa]">{{ count($posts) }}</p>
                        <p class="text-[11px] text-white/25 mt-0.5 font-display uppercase tracking-wider">Total</p>
                    </div>
                    <div class="bg-[#13131a] border border-white/6 rounded-xl p-3.5 text-center flex flex-col justify-center">
                        <p class="font-display font-extrabold text-4xl text-[#4ade80]">0</p>
                        <p class="text-[11px] text-white/25 mt-0.5 font-display uppercase tracking-wider">Done</p>
                    </div>
                    <div class="bg-[#13131a] border border-white/6 rounded-xl p-3.5 text-center flex flex-col justify-center">
                        <p class="font-display font-extrabold text-4xl text-[#fa6d9a]">{{ count($posts) }}</p>
                        <p class="text-[11px] text-white/25 mt-0.5 font-display uppercase tracking-wider">Pending</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 mb-3">
                    <p class="font-display text-[10px] font-bold uppercase tracking-widest text-white/20">Tasks</p>
                    <span class="text-[10px] font-display font-bold bg-[#7c6dfa]/12 text-[#7c6dfa] px-2 py-0.5 rounded-full">
                        {{ count($posts) }}
                    </span>
                    <div class="flex-1 h-px bg-white/4"></div>
                </div>

                {{-- Task list --}}
                <div class="task-scroll space-y-2 max-h-[52vh] overflow-y-auto pr-0.5 pt-6 ">

                    @forelse ($posts as $index => $post)

                    <div class="task-card group flex items-center gap-3 bg-[#13131a] border border-white/6 hover:border-[#7c6dfa]/28 hover:shadow-[0_4px_20px_rgba(0,0,0,0.3)] rounded-xl px-4 py-3.5">
                        
                        {{-- Centang --}}
                        <span class="flex justify-center items-center cursor-pointer hover:text-[#44ff00]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </span>

                        
                        <span class="font-display text-[14px] font-bold text-white/18 w-5 text-right shrink-0">
                            {{ str_pad($index + 1, 0, '0', STR_PAD_LEFT) }}
                        </span>

                        {{-- bundaran  --}}
                        @php
                            $statusClass = 'bg-[#7c6dfa] shadow-[0_0_4px_rgba(124,109,250,100)]"';

                            if ($post->dueDate) {

                                $daysDifference = now()->diffInDays($post->dueDate);

                                if ($daysDifference < 0) {
                                    $statusClass = 'bg-red-600 shadow-[0_0_4px_rgba(255,0,0,100)]'; 
                                } 
                                elseif ($daysDifference <= 2) {
                                    $statusClass = 'bg-yellow-300 shadow-[0_0_4px_rgba(255,255,0,100)]';
                                }
                            }
                        @endphp
                        <span class="w-2 h-2 rounded-full {{ $statusClass }} shrink-0"></span>

                        <div class="relative flex-1 min-w-0 group/text ">
                            <p class="text-sm text-white/80 truncate">
                                {{ $post['list'] }} 
                                @if ($post->dueDate)    
                                <p class="text-[11px]">Due: {{ $post->dueDate->format('d M Y') }}</p>
                                @endif
                            </p>
                           
                            <div class="absolute bottom-full left-0 mb-2 hidden group-hover/text:block bg-[#1c1c28] border border-[#7c6dfa]/20 text-white/75 text-xs px-3 py-2 rounded-lg z-80 max-w-xs wrap-break-words shadow-xl ">
                                {{ $post['list'] }}
                            </div>
                        </div>

                        {{-- Star  --}}
                        <button title="Favourite (coming soon)" class="opacity-0 group-hover:opacity-100 text-white/18 hover:text-[#f6ff00] transition-all shrink-0 cursor-pointer">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </button>

                        {{-- Edit & Delete --}}
                        <div class="flex items-center gap-1.5 shrink-0">
                            @auth
                            <button
                                type="button"
                                onclick="openEditModal('{{ $post->id }}', `{{ addslashes($post->list) }}`)"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#7c6dfa]/10 text-[#7c6dfa] hover:bg-[#7c6dfa]/22 hover:shadow-[0_0_10px_rgba(124,109,250,0.25)] transition-all cursor-pointer"
                                title="Edit">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>

                            <button 
                                type="submit" 
                                onclick="openDeleteModal('{{ $post->id }}', `{{ addslashes($post->list) }}`)"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#f87171]/6 text-[#f87171] hover:bg-[#f87171]/18 transition-all cursor-pointer" 
                                title="Delete">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            </button>

                            @else
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/3 text-white/15 cursor-not-allowed" title="Edit">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </span>
                            @endauth
                        </div>

                    </div>

                    @empty
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-[#7c6dfa]/8 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-[#7c6dfa]/35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        </div>
                        <p class="text-white/28 text-sm">No tasks yet.</p>
                        <p class="text-white/15 text-xs mt-1">Add one above to get started.</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </main>
    </div>


    {{-- Edit overlay --}}
    <div id="editModal" class="fixed inset-0 z-200 flex items-center justify-center px-4 hidden">
        {{-- Backdrop --}}
        <div id="editModalBackdrop" onclick="closeEditModal()" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        {{-- Modal box --}}
        <div id="editModalBox" class="relative w-full max-w-md bg-[#13131a] border border-white/8 rounded-2xl shadow-[0_24px_60px_rgba(0,0,0,0.6)] p-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-display font-bold text-lg tracking-tight">Edit Task</h2>
                    <p class="text-white/30 text-xs mt-0.5">Make your changes below</p>
                </div>
                <button onclick="closeEditModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-white/30 hover:text-white/70 hover:bg-white/6 transition-all cursor-pointer">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            {{-- Form --}}
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block font-display text-[10px] font-bold uppercase tracking-widest text-white/25 mb-2">Task</label>
                    <input
                        id="editInput"
                        type="text"
                        name="list"
                        autocomplete="off"
                        class="edit-input w-full bg-[#0d0d12] border border-white/[0.07] focus:border-[#7c6dfa]/50 rounded-xl px-4 py-3 text-sm text-white placeholder-white/20 outline-none transition-all duration-200"
                        placeholder="Task name..."
                    >
                </div>

                <div class="flex items-center gap-2.5">
                    <button type="submit" class="flex-1 font-display font-bold text-xs tracking-widest uppercase bg-[#7c6dfa] hover:bg-[#6b5ce7] text-white py-3 rounded-xl transition-colors cursor-pointer">
                        Save Changes
                    </button>
                    <button type="button" onclick="closeEditModal()" class="font-display font-bold text-xs tracking-widest uppercase text-white/35 hover:text-white/60 border border-white/[0.07] hover:border-white/15 py-3 px-5 rounded-xl transition-all cursor-pointer">
                        Cancel
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- Delete overlay --}}
    <div id="deleteModal" class="fixed inset-0 z-200 flex items-center justify-center px-4 hidden">
        {{-- Backdrop --}}
        <div id="editModalBackdrop" onclick="closeDeleteModal()" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        {{-- Modal box --}}
        <div id="DeleteBox" class="relative w-full max-w-md bg-[#13131a] border border-white/8 rounded-2xl shadow-[0_24px_60px_rgba(0,0,0,0.6)] p-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-5 ">
                <div>
                    <h2 class="font-display font-bold text-lg tracking-tight">Are You Sure?</h2>
                    <p class="text-white/30 text-xs mt-0.5">Are you sure to delete this task</p>
                </div>
                <button onclick="closeDeleteModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-white/30 hover:text-white/70 hover:bg-white/6 transition-all cursor-pointer">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            {{-- Form --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-between items-stretch sm:items-center pt-7 tracking-tight">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="tracking-tight w-full sm:w-60 sm h-12 flex items-center justify-center rounded-lg bg-[#f9181871] hover:bg-[#f918189e] transition-all cursor-pointer text-[#f5e2e2c9]" title="Delete">
                        Delete
                    </button>
                </form>
                <div>
                    <button onclick="closeDeleteModal()" class="tracking-tight w-full cursor-pointer bg-[#60606037] sm:w-37 h-12 rounded-lg hover:bg-[#6060609a]">
                        Cancel  
                    </button> 
                </div>
            </div>
        </div>
    </div>

    <script src="/js/home.js">
    </script>

</body>
</html>