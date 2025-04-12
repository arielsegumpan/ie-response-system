<?php

namespace App\Livewire\Pages;

use App\Models\Blog;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class BlogShow extends Component
{
    public Blog $blog;
    public array $meta = [];

    public function mount($slug)
    {
        $this->blog = Blog::with([
            'categories:id,cat_name,cat_slug',
            'tags:id,tag_name,tag_slug'
        ])->where('slug', $slug)->firstOrFail();

        $this->meta = $this->blog->metadata ?? [];
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.blog-show');
    }
}
