<?php

namespace App\Livewire;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Livewire\Component;

class Unsubscribe extends Component
{
    public $pathInfo;

    public function mount(Request $request) {
        $this->pathInfo = $request->getPathInfo();
        $array = explode('/' ,$this->pathInfo);
        $token = array_pop($array);
        
        $newsletter = Newsletter::where('token', $token)->first();
        if($newsletter) $newsletter->delete();
    }

    public function render()
    {
        return view('livewire.unsubscribe');
    }
}
