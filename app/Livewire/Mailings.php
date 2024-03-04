<?php

namespace App\Livewire;

use App\Models\Newsletter;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Mailings extends Component
{
    public $unregistered;
    public $registered;

    public $unregisteredList = [];
    public $registeredList = [];
 
    #[Rule('required', message: 'A subject is needed.')]
    public $subject;

    #[Rule('required', message: 'A mail message is needed.')]
    public $mailtext;

    public function sendmail($email) {
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>
                        <p>' . nl2br($this->mailtext) . '</p>
                        <p>This mail has been sent to you by <a href="'. $domain .'">Angi Yoga</a>.</p>
                        <img src="' . $domain . '/logo_small.png" alt="the logo, a bright red, blurred circle">
                    </main>
                </body>
            
            </html>
        ';
        // dd($mail_message);
        // TODO: fix
        $recipients = $email;
        $subject = $this->subject;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function sendthismail() {
        $this->validate();
        if(!$this->unregistered && !$this->registered) {
            if($this->unregisteredList && count($this->unregisteredList) !== 0) return $this->addError('unregistered', 'You have to choose at least one list of recipients.');
            return $this->addError('registered', 'You have to choose at least one list of recipients.');
        }
        if ($this->registered) {
            foreach ($this->registeredList as $registered) {
                $this->sendmail($registered);
            }
        }
        if ($this->unregistered) {
            foreach ($this->unregisteredList as $unregistered) {
                $this->sendmail($unregistered->email);
            }
        }

        $recipients = 'angi@angi.yoga, info@nano.sx';
        $this->sendmail($recipients);

        session()->flash('message', 'Sent e-mail successfully.');
        $this->redirect('/mailings');
    }

    public function mount() {
        $this->unregisteredList = Newsletter::all();
        $registeredUsers = User::all();
        foreach ($registeredUsers as $user) {
            if ($user->email_notifications) array_push($this->registeredList, $user->email);
        }
        // dd($this->unregisteredList);
    }

    public function render()
    {
        return view('livewire.mailings');
    }
}
