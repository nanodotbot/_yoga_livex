<?php

namespace App\Livewire;

use App\Models\Payment;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Orders')]
class Order extends Component
{
    public $orders = [];

    public function mount() {
        $orders = Payment::where('user_id', auth()->user()->id)->orderBy('created', 'desc')->get();
        foreach ($orders as $order) {
            array_push($this->orders, [
                'id' => $order->id,
                'created' => $order->created,
                'intent' => $order->intent,
                'type' => $order->type,
                'amount' => $order->amount,
                'email' => $order->email,
                'name' => $order->name,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.order');
    }
}
