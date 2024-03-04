<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Stripe;

#[Title('Checkout')]
class Checkout extends Component
{
    public function processpayment() {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $YOUR_DOMAIN = env('DOMAIN');

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => 'price_1OYtUEJVbfotMwBUkGGyd9Ja',
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/cancel',
        ]);
        
        
        $this->redirect($checkout_session->url);
    }
    
    public function render()
    {
        return view('livewire.checkout');
    }
}
