<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Handle Users')]
class HandleUsers extends Component
{
    public $users = [];
    public $balances = [];
    public $balancesx = [];

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/handle-users');
    }

    public function decrease($key){
        // dd($this->balancesx[$key]['balance']);
        $this->balancesx[$key]['balance']--;
    }
    public function increase($key){
        // dd($this->balancesx[$key]['balance']);
        $this->balancesx[$key]['balance']++;
    }

    public function savebalance($user_id, $type, $newbalance) {
        $balance = Balance::where('user_id', $user_id, 'and')->where('type', $type)->first();

        $balance->balance = $newbalance;
        $balance->update();
        $message = 'Successfully updated user balance.';
        $this->redirectWithFlash($message);    
    }

    public function mount() {
        $this->users = User::all();
        $this->balances = Balance::all();
        foreach ($this->balances as $balance) {
            array_push($this->balancesx, [
                'user_id' => $balance->user_id,
                'type' => $balance->type,
                'balance' => $balance->balance,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.handle-users');
    }
}
