<?php

namespace App\Livewire;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Reset password')]
class ResetPassword extends Component
{
    #[Rule('required', message: 'Please enter a password to set a new one.')]
    public $password;
    #[Rule('required', message: 'Please confirm the new password.')]
    public $password_confirmation;

    public $pathInfo;

    public function updateWithFlash($user, $message) {
        $user->update();
        session()->flash('message', $message);
        $this->redirect('/login');
    }
    public function sendmail($name, $email) {
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>                        
                        <p>Dear ' . $name . ',<br><br>
                        You have successfully changed your password.<br><br>
                        With gratitude and good vibes,<br><br>
                        Angi Yoga</p>
                        <p>This mail has automatically been sent to you by <a href="'. $domain .'">Angi Yoga</a>.</p>
                        <img src="' . $domain . '/logo_small.png" alt="the logo, a bright red, blurred circle">
                    </main>
                </body>
            
            </html>
        ';
        // dd($mail_message);
        // TODO: fix
        $recipients = $email;
        $subject = 'Angi Yoga - Password reset';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);

        $subject = 'Angi Yoga - Password reset - ' . $name;
        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function updatepw() {
        $this->validate([
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);
        if($this->password !== $this->password_confirmation) {
            return $this->addError('password_confirmation', 'The passwords do not match.');
        }

        $array = explode('/' ,$this->pathInfo);
        $token = array_pop($array);
        
        $reset = PasswordReset::where('token', $token)->first();
        if(!$reset) {
            return $this->addError('password_confirmation', 'The password reset link is invalid.');
        }
        $current = strtotime('-1 hour');
        $updated = strtotime($reset->updated_at);
        if(!($updated > $current)) {
            return $this->addError('password_confirmation', 'A password reset link is only valid for an hour. This one is outdated.');
        }
        $user = User::where('email', $reset->email)->first();
        if(!$user) {
            return $this->addError('password_confirmation', 'The password reset link is invalid.');
        }

        $user->password = bcrypt($this->password);

        $this->sendmail($user->name, $user->email);

        $message = 'Changed password successfully.';
        $this->updateWithFlash($user, $message);
    }

    public function mount(Request $request) {
        $this->pathInfo = $request->getPathInfo();
    }

    public function render()
    {
        return view('livewire.reset-password');
    }
}
