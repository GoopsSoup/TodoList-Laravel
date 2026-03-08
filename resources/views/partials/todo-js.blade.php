@forelse ($posts as $index => $post)
<div class="task-card group flex items-center gap-3 bg-[#13131a] border border-white/6 hover:border-[#7c6dfa]/28 hover:shadow-[0_4px_20px_rgba(0,0,0,0.3)] rounded-[7px] px-4 py-3.5">                    
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
                <p class="text-[#e0dc2299]">{{ $post['list'] }}</p>
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