<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class Isugid extends Component
{
    #[Layout('layouts.app')]
    #[Title('Isugid')]
    public function render()
    {
        return view('livewire.pages.isugid');
    }
}
