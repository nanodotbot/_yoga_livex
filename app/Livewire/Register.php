<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register')]
class Register extends Component
{
    #[Rule('required', message: 'A username is needed for the registration.')]
    #[Rule('unique:users', message: 'This username is already in use.')]
    public $name = '';

    #[Rule('required', message: 'An e-mail address is needed for the registration.')]
    #[Rule('email', message: 'The e-mail has to be in an e-mail format.')]
    #[Rule('unique:' . User::class . ',email', message: 'This e-mail address is already connected to another account.')]
    public $email = '';

    #[Rule('required', message: 'A password is needed for the registration.')]
    #[Rule('min:3', message: 'The password must be at least three characters in length.')]
    public $password = '';

    #[Rule('required', message: 'Please confirm the password.')]
    public $password_confirmation = '';

    #[Rule('required', message: 'Please verify that you have read the privacy policy.')]
    public $privacy;

    #[Rule('required', message: 'Please verify that you have read the medical disclaimer.')]
    public $health;

    public $goals = '';
    public $history = '';

    public $previous;

    public function sendmail() {
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>
                        <p>Dear ' . $this->name . ',<br><br>
                        Namaste and a warm welcome! I am thrilled to have you as a new member of Angi Yoga.<br><br>
                        Congratulations on taking the first step towards a journey of well-being and self-discovery. Whether you\'re a seasoned yogi or just starting your yoga adventure, I am here to support and inspire you.<br><br>
                        I am excited to be part of your yoga journey and can\'t wait to see the positive impact it brings to your life.<br><br>
                        With gratitude and good vibes,<br><br>
                        Angi Yoga</p>
                        <table>
                            <tr>
                                <td>name:</td><td>' . $this->name . '</td>
                            </tr>
                            <tr>
                                <td>email:</td><td>' . $this->email . '</td>
                            </tr>
                            <tr>
                                <td>goals:</td><td>' . $this->goals . '</td>
                            </tr>
                            <tr>
                                <td>history of sports:</td><td>' . $this->history . '</td>
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
        $recipients = $this->email;
        $subject = 'Angi Yoga - Welcome';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);

        $subject = 'Angi Yoga - Register -' . $this->name;
        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function register() {
        $this->validate();
        if($this->password !== $this->password_confirmation) {
            return $this->addError('password_confirmation', 'The password and the password confirmation fields don\'t match.');
        }
        $password = bcrypt($this->password);
               
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'goals' => $this->goals,
            'history' => $this->history,
            'password' => $password
        ]);

        $newsletter = Newsletter::where('email', $this->email)->first();
        if($newsletter) {
            $user->email_notifications = 1;
            $user->update();
            $newsletter->delete();
        }
 
        $types = ['online', 'outdoor', 'studio', 'private online', 'private studio'];

        foreach ($types as $type) {
            Balance::create([
                'type' => $type,
                'user_id' => $user->id,
                'balance' => 0,
            ]);            
        }

        auth()->login($user);

        $this->sendmail();

        session()->flash('message', 'Registered and logged-in successfully.');
        $this->redirect($this->previous);
    }
    public function mount() {
        $this->previous = URL::previous();
    }

    public function render()
    {
        return view('livewire.register');
    }
}
