<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class IndexPage extends Component
{

    #[Layout('layouts.app')]
    #[Title('Home')]
    public function render()
    {
        return view('livewire.pages.index-page');
    }
}
