<?php

namespace App\Livewire;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forgot password')]
class ForgotPassword extends Component
{
    #[Rule('required', message: 'Please enter an e-mail address.')]
    #[Rule('email', message: 'Please enter a valid e-mail address.')]
    public $email;

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/');
    }

    public function mail($token) {
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>                        
                        <p>Dear user,<br><br>
                        You have asked for a password reset. You can set a new password in <a href="' . $domain . '/reset-password/' . $token . '">the linked form</a>. This link will expire in an hour.</p>
                        <p>This mail has automatically been sent to you by <a href="'. $domain .'">Angi Yoga</a>.</p>
                        <img src="' . $domain . '/logo_small.png" alt="the logo, a bright red, blurred circle">
                    </main>
                </body>
            
            </html>
        ';
        // dd($mail_message);
        // TODO: fix
        $recipients = $this->email;
        $subject = 'Angi Yoga - Password reset';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);

        $subject = 'Angi Yoga - Password reset - ' . $this->email;
        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function sendMail() {
        $this->validate();
        
        $user = User::where('email', $this->email)->first();

        if(!$user) {
            return $this->addError('email', 'Please enter the e-mail address that you have used for the registration.');
        }

        $token = str()->random(64);

        $mailExists = PasswordReset::where('email', $this->email)->first();

        if($mailExists) {
            $mailExists->token = $token;
            $mailExists->update();
        } else {
            PasswordReset::create([
                'email' => $this->email, 
                'token' => $token
            ]);
        }

        $this->mail($token);

        $message = 'An e-mail with a link to the password reset page has successfully been sent to you. Please check your e-mails.';
        $this->redirectWithFlash($message);
    }

    public function render()
    {
        return view('livewire.forgot-password');
    }
}
