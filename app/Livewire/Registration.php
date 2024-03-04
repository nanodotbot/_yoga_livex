<?php

namespace App\Livewire;

use App\Models\Classes;
use App\Models\Subscription;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Registrations')]
class Registration extends Component
{
    public $classes = [];

    public function sendmail($class, $user) {
        $domain = env('DOMAIN');
        $mail_message = '
            <html>

                <body>
                    <main>
                        <p>Dear ' . $user->name . ',<br><br>
                        you successfully cancelled your subscription to the following class:<br><br>
                        <table>
                            <tr>
                                <td>start time:</td><td>' . $class->startTime . '</td>
                            </tr>
                            <tr>
                                <td>title:</td><td>' . $class->title . '</td>
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
        $subject = 'Angi Yoga - Subscription cancelled';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';

        $recipients = $user->email;
        mail($recipients, $subject, $mail_message, $headers);
        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/registrations');
    }

    public function cancel($id) {
        $subscription = Subscription::where('user_id', auth()->user()->id, 'and')->where('classes_id', $id)->first();
        $user = User::find(auth()->user()->id);

        $class = Classes::where('id', $subscription->classes_id)->first();
        
        $startTime = strtotime($class->startTime);
        $startTime = date("d.m.Y H:i", $startTime);
        $current = date("d.m.Y H:i");
        if($startTime <= $current) return;

        $subscription->delete();
        $user->balance += 1;
        $user->update();

        $this->sendmail($class, $user);

        $message = 'Un-registered from class successfully.';
        $this->redirectWithFlash($message);
    }

    public function mount() {
        $subscriptions = Subscription::where('user_id', auth()->user()->id)->get();
        foreach ($subscriptions as $subscription) {
            $class = Classes::where('id', $subscription->classes_id)->first();
            array_push($this->classes, [
                'id' => $class->id,
                'title' => $class->title,
                'startTime' => $class->startTime,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.registrations');
    }
}
