<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Contact')]
class Contact extends Component
{
    #[Rule('required', message: 'Please give yourself a name.')]
    public $name;
    public $email;
    public $tel;
    #[Rule('required', message: 'Please add a message to me.')]
    public $message;
    #[Rule('required', message: 'Please verify that you have read the privacy policy.')]
    public $privacy;

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/contact');
    }

    public function sendmail() {
        $this->validate();
        if(!$this->email && !$this->tel){
            return $this->addError('tel', 'Please provide an e-mail address or phone number.');
        }
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>
                        <p>Hello ' . $this->name . ',<br><br>your e-mail has been successfully delivered. I will respond to you as soon as possible.</p>
                        <table>
                            <tr>
                                <td>name:</td><td>' . $this->name . '</td>
                            </tr>
                            <tr>
                                <td>email:</td><td>' . $this->email . '</td>
                            </tr>
                            <tr>
                                <td>tel:</td><td>' . $this->tel . '</td>
                            </tr>
                            <tr>
                                <td>message:</td><td>' . $this->message . '</td>
                            </tr>
                        </table>
                        <br><br>
                        <p>This mail has automatically been sent to you by <a href="' . $domain . '">Angi Yoga</a>.</p>
                        <img src="' . $domain . '/logo_small.png" alt="the logo, a bright red, blurred circle">
                    </main>
                </body>
            
            </html>
        ';
        // dd($mail_message);
        // TODO: fix
        $recipients = 'info@nano.sx';
        $subject = 'Angi Yoga - Contact form';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';

        if($this->email){
            $recipients = $this->email;
        }
        mail($recipients, $subject, $mail_message, $headers);

        $subject = 'Angi Yoga - Contact form (Copy)';
        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);

        $message = 'Sent mail successfully.';
        $this->redirectWithFlash($message);
    }

    public function render()
    {
        return view('livewire.contact');
    }
}
