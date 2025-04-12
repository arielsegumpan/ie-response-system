<?php

namespace App\Livewire\Pages;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Attributes\Layout;

class BlogShow extends Component
{
    public Blog $blog;
    public Collection $relatedBlogs;
    public array $meta = [];

    public function mount($slug)
    {
        $this->blog = Blog::with([
            'categories:id,cat_name,cat_slug',
            'tags:id,tag_name,tag_slug'
        ])->where('slug', $slug)->firstOrFail();

        $this->meta = $this->blog->metadata ?? [];

        $this->relatedBlogs = Blog::where('user_id', $this->blog->user_id)
            ->where('id', '!=', $this->blog->id)
            ->latest()
            ->take(5)
            ->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.blog-show');
    }
}
