<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Gallery')]
class Gallery extends Component
{
    public function render()
    {
        return view('livewire.gallery');
    }
}
