<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body>
        {{ $slot }}

        @livewireScripts
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


                    {{-- semua list --}}
                    <a href="/?filter=all"
                        class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm
                        {{ request('filter') === 'all' || !request('filter') ? 'bg-[#7c6dfa]/20 text-[#7c6dfa]' : 'text-white/35 hover:text-white/65 hover:bg-white/4' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#ffffff59" fill-rule="evenodd" d="M3 13.5a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h9.25a.75.75 0 0 0 0-1.5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9.75a.75.75 0 0 0-1.5 0V13a.5.5 0 0 1-.5.5H3Zm12.78-8.82a.75.75 0 0 0-1.06-1.06L9.162 9.177L7.289 7.241a.75.75 0 1 0-1.078 1.043l2.403 2.484a.75.75 0 0 0 1.07.01L15.78 4.68Z" clip-rule="evenodd"/></svg>
                        All Tasks
                        @auth
                        <span class="ml-auto text-[10px] font-display font-bold bg-[#7c6dfa]/20 text-[#7c6dfa] px-1.5 py-0.5 rounded-full"> {{--hover:text-white/65 hover:bg-white/4 bg-[#7c6dfa]/10--}}
                            {{ $allPosts->count() }}
                        </span>
                        @endauth
                    </a>

                    {{-- upcoming    --}}
                    <a href="/?filter=upcoming"
                        class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm
                        {{ request('filter') === 'upcoming' || !request('filter') ? 'bg-[#7c6dfa]/20 text-[#7c6dfa]' : 'text-white/35 hover:text-white/65 hover:bg-white/4' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32"><path fill="none" stroke="#ffffff59" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8l4 4m9-4c0 7.18-5.82 13-13 13S3 23.18 3 16S8.82 3 16 3s13 5.82 13 13Z"/></svg>
                        Upcoming
                        @auth
                        <span class="ml-auto text-[10px] font-display font-bold bg-[#7c6dfa]/20 text-[#7c6dfa] px-1.5 py-0.5 rounded-full">
                            {{ $allPosts->where('dueDate', '>', today())->count() }}
                        </span>
                        @endauth
                    </a>

                    {{-- hari ini --}}
                    <a href="/?filter=today" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm 
                    {{ request('filter') === 'today' || !request('filter') ? 'bg-[#7c6dfa]/20 text-[#7c6dfa]' : 'text-white/35 hover:text-white/65 hover:bg-white/4' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><rect width="416" height="384" x="48" y="80" fill="none" stroke="#ffffff59" stroke-linejoin="round" stroke-width="32" rx="48"/><path fill="none" stroke="#ffffff59" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M128 48v32m256-32v32"/><rect width="96" height="96" x="112" y="224" fill="none" stroke="#ffffff59" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" rx="13"/><path fill="none" stroke="#ffffff59" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M464 160H48"/></svg>
                        Today
                        @auth
                        <span class="ml-auto text-[10px] font-display font-bold bg-[#7c6dfa]/20 text-[#7c6dfa] px-1.5 py-0.5 rounded-full">
                            {{ $allPosts->where('dueDate', today())->count() }}
                        </span>
                        @endauth
                    </a>

                    {{-- overdue --}}
                    <a href="/?filter=overdue" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition-colors
                    {{ request('filter') === 'overdue' || !request('filter') ? 'bg-[#7c6dfa]/20 text-[#7c6dfa]' : 'text-white/35 hover:text-white/65 hover:bg-white/4' }}">
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="none"><path d="M17.75 3A3.25 3.25 0 0 1 21 6.25v5.772a6.471 6.471 0 0 0-1.5-.709V8.5h-15v9.25c0 .966.784 1.75 1.75 1.75h5.063c.173.534.412 1.037.709 1.5H6.25A3.25 3.25 0 0 1 3 17.75V6.25A3.25 3.25 0 0 1 6.25 3h11.5zm0 1.5H6.25A1.75 1.75 0 0 0 4.5 6.25V7h15v-.75a1.75 1.75 0 0 0-1.75-1.75z" fill="#FFFFFF59"/><path d="M23 17.5a5.5 5.5 0 1 1-11 0a5.5 5.5 0 0 1 11 0zM17.5 14a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 1 0v-4a.5.5 0 0 0-.5-.5zm0 7.125a.625.625 0 1 0 0-1.25a.625.625 0 0 0 0 1.25z" fill="#FFFFFF59"/></g></svg>
                        Overdue
                        @auth
                        <span class="ml-auto text-[10px] font-display font-bold bg-[#de4e4e70] text-[#fa6d6d] px-1.5 py-0.5 rounded-full">
                            {{ $allPosts->where('dueDate', '<', today())->count() }}
                        </span>
                        @endauth
                    </a>

                    <a href="/?filter=completed" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition-colors
                        {{ request('filter') === 'completed' || !request('filter') ? 'bg-[#7c6dfa]/20 text-[#7c6dfa]' : 'text-white/35 hover:text-white/65 hover:bg-white/4' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Completed
                        @auth
                        <span class="ml-auto text-[10px] font-display font-bold bg-[#52b14191] text-[#9efa6d] px-1.5 py-0.5 rounded-full">
                            {{ $allPosts->where('completed')->count() }}
                        </span>
                        @endauth
                    </a>

                    <div class="border-t border-white/5 my-2"></div>

                    {{-- Favorites --}}
                    <div class="flex items-center justify-between px-2 pt-1.5 pb-1">
                        <p class="font-display text-[10px] font-bold uppercase tracking-widest text-white">Favourites</p>
                    </div>

                    @php
                        $favourites = $allPosts->where('favourite', true);
                    @endphp

                    {{-- Favorites lists --}}
                    @forelse ($favourites as $fav)
                    <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[#ffffff9f] text-sm">
                        <svg class="w-3.5 h-3.5 text-[#e0e238bc] shrink-0" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="truncate">
                        {{ $fav->list }}
                        </span>
                        @if($fav->dueDate)
                        <span class="ml-auto text-[10px] text-[#ffffffa7]">{{ $fav->dueDate->format('d M Y') }}</span>
                        @endif
                    
                    </div>
                        <div class="hidden">
                            No favourites task yet
                        </div>        
                    @empty
                    <div class="flex mt-6 justify-center items-center gap-4 ">
                        <span class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-white/30">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>  
                        </span>
                        <p class="text-white/30 text-[14px] ">No Favourite Task Yet</p>
                    </div>
                    @endforelse

                </nav>

                {{-- Sidebar footer --}}
                <div class="p-3 border-t border-white/5 flex items-center justify-evenly">
                    <!-- From Uiverse.io by cuzpq --> 
                    <input type="checkbox" class="theme-checkbox">
                    <p class="text-[13px]">Dark Mode/Light Mode</p>
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
                        class="flex h-12 mb-7 rounded-xl overflow-hidden border border-white/[0.07] bg-[#13131a] focus-within:border-[#7c6dfa]/50 transition-all duration-200 ">
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

                        <div class="flex items-center min-w-7.5 sm:min-w-9 justify-center bg-[#616161]">
                            <input
                            {{ auth()->guest() ? 'disabled' : '' }}
                            type="text" 
                            name="dueDate"
                            id="dueDate"
                            class="bg-red-200 w-5 opacity-0 absolute"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6  ">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                        </div>

                        <button
                            type="submit"
                            {{ auth()->guest() ? 'disabled' : '' }}
                            class="font-display font-bold text-[11px] tracking-widest uppercase bg-[#7c6dfa] hover:bg-[#6b5ce7] disabled:opacity-35 disabled:cursor-not-allowed text-white px-5 transition-colors cursor-pointer shrink-0">
                            + Add
                        </button>
                    </form>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-3 mb-7 min-h-40 ">
                        {{-- total --}}
                        <div class="bg-[#13131a] border border-white/6 rounded-xl p-3.5 text-center flex flex-col justify-center">
                            <p class="font-display font-extrabold text-4xl text-[#7c6dfa]">{{ count($allPosts) }}</p>
                            <p class="text-[11px] text-white/25 mt-0.5 font-display uppercase tracking-wider">Total</p>
                        </div>
                        {{-- completed --}}
                        <div class="bg-[#13131a] border border-white/6 rounded-xl p-3.5 text-center flex flex-col justify-center">
                            <p class="font-display font-extrabold text-4xl text-[#4ade80]">{{ $allPosts->where('completed')->count() }}</p>
                            <p class="text-[11px] text-white/25 mt-0.5 font-display uppercase tracking-wider">Done</p>
                        </div>
                        {{-- no done --}}
                        <div class="bg-[#13131a] border border-white/6 rounded-xl p-3.5 text-center flex flex-col justify-center">
                            <p class="font-display font-extrabold text-4xl text-[#fa6d9a]">{{ count($allPosts) - $allPosts->where('completed')->count() }}</p>
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
                    <div class="task-scroll space-y-2 max-h-[52vh] overflow-y-auto pr-0.5 pt-6">

                        @forelse ($posts as $index => $post)

                        <div class="task-card group flex items-center gap-3 bg-[#13131a] border border-white/6 hover:border-[#7c6dfa]/28 hover:shadow-[0_4px_20px_rgba(0,0,0,0.3)] rounded-xl px-4 py-3.5">
                            
                            {{-- Centang --}}
                            <form method="POST" action="/posts/{{ $post->id }}/completed" class="flex justify-center items-center cursor-pointer hover:text-[#44ff00]">
                            @csrf
                            @method('PATCH')
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </button>
                            </form>

                            
                            <span class="font-display text-[14px] font-bold text-white/18 w-5 text-right shrink-0">
                                {{ str_pad($index + 1, 0, '0', STR_PAD_LEFT) }}
                            </span>

                            {{-- bundaran  --}}
                            @php
                                $statusClass = 'bg-[#7c6dfa] shadow-[0_0_4px_rgba(124,109,250,100)]"';

                                if ($post->dueDate) {

                                    $daysDifference = now()->diffInDays($post->dueDate);

                                    if ($daysDifference < -1) {
                                        $statusClass = 'bg-red-600 shadow-[0_0_4px_rgba(255,0,0,100)]'; 
                                    } 
                                    elseif ($daysDifference <= 0) {
                                        $statusClass = 'bg-orange-500 shadow-[0_0_4px_rgba(255,165,0,100)]';
                                    }
                                    elseif ($daysDifference <= 2) {
                                        $statusClass = 'bg-yellow-300 shadow-[0_0_4px_rgba(255,255,0,100)]';
                                    }
                                }
                            @endphp
                            <span class="w-2 h-2 rounded-full {{ $statusClass }} shrink-0"></span>

                            <div class="relative flex-1 min-w-0 group/text ">
                                <p class="text-sm text-white/80 truncate">
                                    @if ($post->completed)
                                    <p class="line-through text-[#80808092] ">{{ $post['list'] }}</p>
                                    @elseif ($post->favourite)
                                    <p class="text-[#cac711]">{{ $post['list'] }}</p>
                                    @else 
                                    {{ $post['list'] }}
                                    @endif

                                    @if ($post->dueDate)    
                                        @if ($post->completed)
                                        <p class="text-[11px] line-through text-[#80808092]">Due: {{ $post->dueDate->format('d M Y') }}</p>
                                        @else
                                        <p class="text-[11px]">Due: {{ $post->dueDate->format('d M Y') }}</p>
                                        @endif
                                    @endif
                                </p>
                            
                                <div class="absolute bottom-full left-0 mb-2 hidden group-hover/text:block bg-[#1c1c28] border border-[#7c6dfa]/20 text-white/75 text-xs px-3 py-2 rounded-lg z-80 max-w-xs wrap-break-words shadow-xl ">
                                    {{ $post['list'] }}
                                </div>
                            </div>

                            {{-- Star  --}}
                            <form method="POST" action="/posts/{{ $post->id }}/favourite" class="flex items-center justify-center">
                            @csrf
                            @method('PATCH')
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 cursor-pointer opacity-0 group-hover:opacity-100 text-[white] hover:text-[#d9ff00] transition-all hover:fill-[#d9ff00]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                </svg>
                            </button>
                            </form>


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
    </body>
</html>
