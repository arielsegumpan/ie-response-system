<?php

namespace App\Livewire\Pages;

use App\Models\Blog;
use App\Models\Incident;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class IndexPage extends Component
{

    public $incidents;
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

    public function mount()
    {
        $this->incidents = Incident::with(['type', 'location'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->transform(function ($incident) {
            $incident->formatted_created_at = $incident->created_at->diffForHumans();
            return $incident;
        });
    }

    #[Layout('layouts.app')]
    #[Title('Home')]
    public function render()
    {
        return view('livewire.pages.index-page',[
            'featuredPosts' => $this->getFeaturedPosts(),
            'incidents' => $this->incidents
        ]);
    }
}
