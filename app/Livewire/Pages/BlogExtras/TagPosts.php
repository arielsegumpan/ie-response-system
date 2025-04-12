<?php

namespace App\Livewire\Pages\BlogExtras;

use App\Models\Tag;
use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TagPosts extends Component
{
    use WithPagination;

    public ?Tag $tag = null;
    public string $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->tag = Tag::where('tag_slug', $slug)->firstOrFail();
    }

    #[Layout('layouts.app')]
    public function render()
    {

        $postsTags = Blog::whereHas('tags', function ($query) {
            $query->where('tag_slug', $this->slug);
        })
        ->where('is_visible', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(6)
        ->through(function ($post) {
            $post->content = Str::limit(strip_tags($post->content), 70);
            return $post;
        });


        return view('livewire.pages.blog-extras.tag-posts',[
            'postsTags' => $postsTags
        ]);
    }
}
