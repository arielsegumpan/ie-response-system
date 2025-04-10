<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class Blog extends Component
{
    #[Layout('layouts.app')]
    #[Title('Blog')]
    public function render()
    {
        return view('livewire.pages.blog');
    }
}
