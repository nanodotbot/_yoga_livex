<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\Payment;
use App\Models\Pricing;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;

#[Title('Succcess')]
class Success extends Component
{
    public $user;
    public $id;
    public $intent;
    public $payment_status;
    public $type;
    public $amount;
    public $email;
    public $name;
    public $created;
    public $balance = '';

    public function sendmail() {
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>
                        <p>Dear ' . $this->user->name . ',<br><br>
                        your payment was successful. Please check out your new <a href="'. $domain .'/' . $this->user->id . '">balance</a>.<br><br>
                        With gratitude and good vibes,<br><br>
                        Angi Yoga</p>
                        <table>
                            <tr>
                                <td>id:</td><td>' . $this->id . '</td>
                            </tr>
                            <tr>
                                <td>type:</td><td>' . $this->type . '</td>
                            </tr>
                            <tr>
                                <td>amount:</td><td>' . $this->amount . '</td>
                            </tr>
                            <tr>
                                <td>e-mail:</td><td>' . $this->email . '</td>
                            </tr>
                            <tr>
                                <td>name:</td><td>' . $this->name . '</td>
                            </tr>
                            <tr>
                                <td>created:</td><td>' . $this->created . '</td>
                            </tr>
                            <tr>
                                <td>payment status:</td><td>' . $this->payment_status . '</td>
                            </tr>
                        </table>
                        <br><br>
                        <p>This mail has automatically been sent to you by <a href="'. $domain .'">Angi Yoga</a>.</p>
                        <img src="' . $domain . '/logo_small.png" alt="the logo, a bright red, blurred circle">
                    </main>
                </body>
            
            </html>
        ';
        // dd($mail_message);
        // TODO: fix
        $subject = 'Angi Yoga - Payment confirmation';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';

        $recipients = $this->user->email;
        mail($recipients, $subject, $mail_message, $headers);
        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function render(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $session_id = $request->get('session_id');
            $session = Session::retrieve($session_id);

            $this->id = $session->id;
            $this->intent = $session->payment_intent;
            $this->payment_status = $session->payment_status;
            $this->email = $session->customer_details['email'];
            $this->name = $session->customer_details['name'];
            $this->created = $session->created;
            $this->created = date("d.m.Y H:i", $this->created);

            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
            $line_items = $stripe->checkout->sessions->allLineItems($session_id)->data;

            $price_id = $line_items[0]->price->id;

            $this->user = auth()->user();
            $user = User::find($this->user->id);

            $payment = Payment::where('stripeid', $this->id)->first();
            
            if(!$payment) {
                $pricing = Pricing::where('priceid', $price_id)->first();
                $this->type = $pricing->type;
                $this->amount = $pricing->amount;

                $balance = Balance::where('user_id', $this->user->id, 'and')->where('type', $this->type)->first();

                $balance->balance = $balance->balance + $this->amount;
                $balance->update();

                // if($price_id === 'price_1OYtUEJVbfotMwBUkGGyd9Ja'){
                //     $user->balance = $user->balance + 1;
                // }
                // if($price_id === 'price_1OYtVCJVbfotMwBU2pRJpEBj'){
                //     $user->balance = $user->balance + 10;
                // }
                // if($price_id === 'price_1OYtVpJVbfotMwBUAiluoW7G'){
                //     $user->balance = $user->balance + 20;
                // }
                // $user->update();

                Payment::create([
                    'user_id' => $this->user->id,
                    'stripeid' => $this->id,
                    'intent' => $this->intent,
                    'price_id' => $price_id,
                    'type' => $this->type,
                    'amount' => $this->amount,
                    'payment_status' => $this->payment_status,
                    'email' => $this->email,
                    'name' => $this->name,
                    'created' => $session->created,
                ]);

            }
            $this->balance = $balance->balance;
            $this->sendmail();
        } catch (Exception $e) {
            // TODO: fix
            dd($e);
            // abort(404);
        }
        return view('livewire.success', compact('line_items'));
    }
}
