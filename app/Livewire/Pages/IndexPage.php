<?php

namespace App\Livewire\Pages;

use App\Models\Blog;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class IndexPage extends Component
{

    public function getFeaturedPosts()
    {
        return Blog::with([
            'categories:id,cat_name,cat_slug',
            'tags:id,tag_name,tag_slug'
            ])
            ->where('is_visible', 1)
            ->where('is_featured', 1)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

    }
    #[Layout('layouts.app')]
    #[Title('Home')]
    public function render()
    {
        return view('livewire.pages.index-page',[
            'featuredPosts' => $this->getFeaturedPosts()
        ]);
    }
}
