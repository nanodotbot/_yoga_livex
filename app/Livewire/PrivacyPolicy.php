<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Privacy policy')]
class PrivacyPolicy extends Component
{
    public $ip_address = 'No ip address given.';

    public function mount(Request $request){
        $this->ip_address = $request->ip();
    }

    public function render()
    {
        return view('livewire.privacy-policy');
    }
}
