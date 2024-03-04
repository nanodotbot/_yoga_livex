<?php

namespace App\Livewire;

use App\Models\Newsletter;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Angi Yoga')]
class Home extends Component
{
    #[Rule('required', message: 'Please enter an e-mail address to subscribe to my newsletter.')]
    #[Rule('email', message: 'Please enter a valid e-mail address.')]
    public $email;

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/');
    }

    public function sendmail($token, $address) {
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>
                        <p>Hi,<br><br>you successfully subscribed to my newsletter.</p>
                        <p>If you want to unsubscribe, please use the following link: <a href="' . $domain . $address . $token . '">Unsubscribe</a></p>
                        <p>This mail has automatically been sent to you by <a href="'. $domain .'">Angi Yoga</a>.</p>
                        <img src="' . $domain . '/logo_small.png" alt="the logo, a bright red, blurred circle">
                    </main>
                </body>
            
            </html>
        ';
        // dd($mail_message);
        // TODO: fix
        $subject = 'Angi Yoga - Newsletter subscription';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';

        $recipients = $this->email;
        mail($recipients, $subject, $mail_message, $headers);
        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function subscribe() {
        $this->validate();

        $user = User::where('email', $this->email)->first();
        $token = str()->random(64);

        if($user) {
            $user->email_notifications = 1;
            $user->update();
            $this->sendmail('', '/account');
        } else {
            Newsletter::create([
                'email' => $this->email,
                'token' => $token,
            ]);
            $this->sendmail($token, '/unsubscribe/');
        }


        $message = 'Successfully subscribed to the newsletter.';
        $this->redirectWithFlash($message);
    }

    public function render()
    {
        return view('livewire.home');
    }
}
