@forelse ($posts as $index => $post)

@php
$dotClass = 'dot-blue';
if ($post->dueDate) {
    $diff = now()->diffInDays($post->dueDate, false);
    if ($diff < -1)     $dotClass = 'dot-red';
    elseif ($diff <= 0) $dotClass = 'dot-orange';
    elseif ($diff <= 2) $dotClass = 'dot-yellow';
}
$isOverdue = $post->dueDate && now()->diffInDays($post->dueDate, false) < -1;
@endphp

{{-- task-item: border-bottom, hover bg, fadeIn animation --}}
<div class="task-item flex items-center gap-3 px-3 py-[10px] border-b">

    {{-- Complete button --}}
    <form class="flex items-center" method="POST" action="/posts/{{ $post->id }}/completed">
        @csrf
        @method('PATCH')
        <button type="submit"
                class="check-btn flex items-center justify-center w-[18px] h-[18px] rounded-full border-2 bg-transparent cursor-pointer shrink-0 text-transparent {{ $post->completed ? 'checked' : '' }}"
                title="Mark complete">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </button>
    </form>

    {{-- Status dot --}}
    <span class="dot {{ $dotClass }} w-2 h-2 rounded-full shrink-0"></span>

    {{-- Task body --}}
    <div class="flex-1 min-w-0">
        <div class="task-name text-sm whitespace-nowrap overflow-hidden text-ellipsis {{ $post->completed ? 'done line-through' : ($post->favourite ? 'starred' : '') }}">
            {{ $post['list'] }}
        </div>
        <div class="flex items-center gap-2 mt-[2px]">
            @if ($post->dueDate)
                <span class="task-due text-xs {{ $post->completed ? 'done line-through' : ($isOverdue ? 'overdue' : '') }}">
                    {{ $post->dueDate->format('d M Y') }}
                </span>
            @endif
            <span class="task-cat-tag text-[11px] px-[7px] py-[1px] rounded-[10px]">{{ $post->category->name ?? 'No category' }}</span>
        </div>
    </div>

    {{-- Actions --}}
    <div class="task-actions flex items-center gap-[2px] opacity-0">

        {{-- Star --}}
        <form method="POST" action="/posts/{{ $post->id }}/favourite">
            @csrf
            @method('PATCH')
            <button type="submit" class="icon-btn star-btn {{ $post->favourite ? 'starred-on' : '' }} flex items-center justify-center w-8 h-8 rounded-full border-0 cursor-pointer" title="Favourite">
                <svg width="15" height="15" viewBox="0 0 24 24"
                    fill="{{ $post->favourite ? 'currentColor' : 'none' }}"
                    stroke="currentColor" stroke-width="1.8">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
            </button>
        </form>

        @auth
        {{-- Edit --}}
        <button type="button"
                onclick="openEditModal('{{ $post->id }}', `{{ addslashes($post->list) }}`)"
                class="icon-btn edit-btn flex items-center justify-center w-8 h-8 rounded-full bg-transparent border-0 cursor-pointer"
                title="Edit">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </button>

        {{-- Delete --}}
        <button type="button"
                onclick="openDeleteModal('{{ $post->id }}')"
                class="icon-btn del-btn flex items-center justify-center w-8 h-8 rounded-full bg-transparent border-0 cursor-pointer"
                title="Delete">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
        </button>
        @endauth

    </div>

</div>

@empty

<div class="flex flex-col items-center justify-center py-16 px-5 text-center">
    <div class="flex items-center justify-center w-14 h-14 rounded-full mb-4" style="background:var(--accent-bg); color:var(--accent);">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 11l3 3L22 4"/>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
    </div>
    <p class="text-[15px] font-medium mb-1" style="color:var(--text-2);">No tasks here</p>
    <p class="text-[13px]" style="color:var(--text-3);">Add a task above to get started.</p>
</div>

@endforelse