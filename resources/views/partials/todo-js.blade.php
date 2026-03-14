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

<div class="task-item">

    {{-- Complete button --}}
    <form class="check-form" method="POST" action="/posts/{{ $post->id }}/completed">
        @csrf
        @method('PATCH')
        <button type="submit" class="check-btn {{ $post->completed ? 'checked' : '' }}" title="Mark complete">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </button>
    </form>

    {{-- Status dot --}}
    <span class="dot {{ $dotClass }}"></span>

    {{-- Task content --}}
    <div class="task-body">
        <div class="task-name {{ $post->completed ? 'done' : ($post->favourite ? 'starred' : '') }}">
            {{ $post['list'] }}
        </div>
        <div class="task-meta">
            @if ($post->dueDate)
                <span class="task-due {{ $post->completed ? 'done' : ($isOverdue ? 'overdue' : '') }}">
                    {{ $post->dueDate->format('d M Y') }}
                </span>
            @endif
            <span class="task-cat-tag">{{ $post->category->name ?? 'No category' }}</span>
        </div>
    </div>

    {{-- Actions --}}
    <div class="task-actions">

        {{-- Star --}}
        <form method="POST" action="/posts/{{ $post->id }}/favourite">
            @csrf
            @method('PATCH')
            <button type="submit" class="icon-btn star-btn {{ $post->favourite ? 'starred-on' : '' }}" title="Favourite">
                <svg width="15" height="15" viewBox="0 0 24 24"
                    fill="{{ $post->favourite ? 'currentColor' : 'none' }}"
                    stroke="currentColor" stroke-width="1.8">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
            </button>
        </form>

        @auth
        {{-- Edit --}}
        <button
            type="button"
            onclick="openEditModal('{{ $post->id }}', `{{ addslashes($post->list) }}`)"
            class="icon-btn edit-btn"
            title="Edit">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </button>

        {{-- Delete --}}
        <button
            type="button"
            onclick="openDeleteModal('{{ $post->id }}')"
            class="icon-btn del-btn"
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

<div class="empty-state">
    <div class="empty-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 11l3 3L22 4"/>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
    </div>
    <p class="empty-title">No tasks here</p>
    <p class="empty-sub">Add a task above to get started.</p>
</div>

@endforelse