<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class Todo extends Component
{
    public $filter = 'all';

    protected $queryString = ['filter'];

    public function render()
    {
        if (!auth()->check()) {
            return view('livewire.todo', [
                'allPosts' => collect(),
                'posts' => collect(),
            ]);
        }

        $query = auth()->user()
            ->userList()
            ->orderBy('completed', 'asc')
            ->orderBy('dueDate', 'desc')
            ->latest();

        $allPosts = auth()->user()->userList()->latest()->get();

        if ($this->filter === 'today') {
            $query->whereDate('dueDate', today());
        }

        if ($this->filter === 'overdue') {
            $query->whereDate('dueDate', '<', today());
        }

        if ($this->filter === 'upcoming') {
            $query->whereDate('dueDate', '>', today());
        }

        if ($this->filter === 'completed') {
            $query->where('completed', true);
        }

        if ($this->filter === 'favourite') {
            $query->where('favourite', true);
        }

        return view('livewire.todo', [
            'allPosts' => $allPosts,
            'posts' => $query->get(),
        ]);
    }
};
?>

<div>
    
</div>