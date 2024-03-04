<?php

namespace App\Livewire;

use App\Models\Pricing as ModelsPricing;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Pricing')]
class Pricing extends Component
{
    public $pricings = [];
    public $locations = [];

    public function processgeneral($priceid) {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $YOUR_DOMAIN = env('DOMAIN');

        $checkout_session = Session::create([
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => $priceid,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/cancel',
        ]);
        
        $this->redirect($checkout_session->url);
    }

    public function mount() {
        $this->pricings = ModelsPricing::orderBy('order_position')->get();
        foreach ($this->pricings as $pricing) {
            if(in_array($pricing->location, $this->locations)) continue;
            array_push($this->locations, $pricing->location);
        }
    }

    public function render()
    {
        return view('livewire.pricing');
    }
}
