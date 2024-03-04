<?php

namespace App\Livewire;

use App\Models\About as ModelsAbout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('About')]
class About extends Component
{
    // public $paragraphs = [];

    public function render()
    {
        // $this->paragraphs = ModelsAbout::orderBy('position')->get();
        return view('livewire.about');
    }
}
