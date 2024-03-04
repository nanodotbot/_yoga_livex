<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\Payment;
use App\Models\Pricing;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AddPayment extends Component
{
    public $payments = [];

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $user_id;

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $stripeid;

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $intent;

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $price_id;

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $type;

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $amount;

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $email;

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $name;

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $created;

    public $payment_status = 'manually_added';

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/add-payment');
    }

    public function sendmail() {
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>
                        <p>Hi Angi,<br><br>you successfully added a payment.</p>
                        <table>
                            <tr>
                                <td>user_id:</td><td>' . $this->user_id . '</td>
                            </tr>
                            <tr>
                                <td>stripeid:</td><td>' . $this->stripeid . '</td>
                            </tr>
                            <tr>
                                <td>intent:</td><td>' . $this->intent . '</td>
                            </tr>
                            <tr>
                                <td>price id:</td><td>' . $this->price_id . '</td>
                            </tr>
                            <tr>
                                <td>type:</td><td>' . $this->type . '</td>
                            </tr>
                            <tr>
                                <td>amount:</td><td>' . $this->amount . '</td>
                            </tr>
                            <tr>
                                <td>email:</td><td>' . $this->email . '</td>
                            </tr>
                            <tr>
                                <td>name:</td><td>' . $this->name . '</td>
                            </tr>
                            <tr>
                                <td>created:</td><td>' . $this->created . '</td>
                            </tr>
                            <tr>
                                <td>payment_status:</td><td>' . $this->payment_status . '</td>
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
        $subject = 'Angi Yoga - Payment added';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';

        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function senddeletemail($id, $user_id, $stripeid, $intent, $price_id, $type, $payment_status, $amount, $email, $name, $created) {
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>
                        <p>Hi Angi,<br><br>you successfully deleted a payment.</p>
                        <table>
                            <tr>
                                <td>id:</td><td>' . $id . '</td>
                            </tr>
                            <tr>
                                <td>user_id:</td><td>' . $user_id . '</td>
                            </tr>
                            <tr>
                                <td>stripeid:</td><td>' . $stripeid . '</td>
                            </tr>
                            <tr>
                                <td>intent:</td><td>' . $intent . '</td>
                            </tr>
                            <tr>
                                <td>price id:</td><td>' . $price_id . '</td>
                            </tr>
                            <tr>
                                <td>type:</td><td>' . $type . '</td>
                            </tr>
                            <tr>
                                <td>amount:</td><td>' . $amount . '</td>
                            </tr>
                            <tr>
                            <td>email:</td><td>' . $email . '</td>
                            </tr>
                            <tr>
                            <td>name:</td><td>' . $name . '</td>
                            </tr>
                            <tr>
                            <td>created:</td><td>' . $created . '</td>
                            </tr>
                            <tr>
                                <td>payment_status:</td><td>' . $payment_status . '</td>
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
        $subject = 'Angi Yoga - Payment added';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';

        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function addPayment() {
        $this->validate();

        $payment = Payment::where('stripeid', $this->stripeid)->first();

        if($payment) {
            return $this->addError('stripeid', 'A payment with this stripe (checkout-session) id already exists.');
        }

        if(!$payment) {
            $pricing = Pricing::where('priceid', $this->price_id)->first();

            if(!$pricing) {
                return $this->addError('price_id', 'The price id doesn\'t match any of the pricing\'s price ids.');
            }
    
            $balance = Balance::where('user_id', $this->user_id, 'and')->where('type', $this->type)->first();

            $balance->balance = $balance->balance + $this->amount;
            $balance->update();

            Payment::create([
                'user_id' => $this->user_id,
                'stripeid' => $this->stripeid,
                'intent' => $this->intent,
                'price_id' => $this->price_id,
                'type' => $this->type,
                'amount' => $this->amount,
                'payment_status' => $this->payment_status,
                'email' => $this->email,
                'name' => $this->name,
                'created' => $this->created,
            ]);
            
            $this->sendmail();

            $message = 'Added payment successfully.';
            $this->redirectWithFlash($message);
        }
    }

    public function deletepayment($id) {
        $payment = Payment::find($id);
        $payment->delete();

        $this->senddeletemail(
            $payment->id,
            $payment->user_id,
            $payment->stripeid,
            $payment->intent,
            $payment->price_id,
            $payment->type,
            $payment->payment_status,
            $payment->amount,
            $payment->email,
            $payment->name,
            $payment->created
        );

        $message = 'Deleted payment successfully.';
        $this->redirectWithFlash($message);
    }

    public function mount() {
        $this->payments = Payment::where('payment_status', 'manually_added')->get();
    }

    public function render()
    {
        return view('livewire.add-payment');
    }
}
