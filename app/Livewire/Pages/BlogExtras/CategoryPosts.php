<?php

namespace App\Livewire\Pages\BlogExtras;

use App\Models\Blog;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
class CategoryPosts extends Component
{
    use WithPagination;

    public ?Category $category = null;
    public string $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->category = Category::where('cat_slug', $slug)->firstOrFail();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $postsCategories = Blog::whereHas('categories', function ($query) {
            $query->where('cat_slug', $this->slug);
        })
        ->where('is_visible', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(6)
        ->through(function ($post) {
            $post->content = Str::limit(strip_tags($post->content), 70);
            return $post;
        });

        return view('livewire.pages.blog-extras.category-posts', [
            'postsCategories' => $postsCategories,
        ]);
    }
}
