<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Account')]
class Profile extends Component
{
    public User $user;
    public $balances = [];

    #[Rule('required', message: 'To update your e-mail address provide a new e-mail address.')]
    public $email;

    #[Rule('required', message: 'To update your password please enter your old password.')]
    public $old_password;

    #[Rule('required', message: 'To update your password you need to provide a new one.')]
    #[Rule('min:3', message: 'The new password must be at least three characters in length.')]
    public $new_password;

    public $subscription;
    public $goals;
    public $history;

    public function updateWithFlash($user, $message) {
        $user->update();
        session()->flash('message', $message);
        $this->redirect('/' . auth()->user()->id);
    }

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/');
    }

    public function updateemail() {
        $this->validate([
            'email' => 'required'
        ]);

        $user = User::find($this->user->id);
        $user->email = $this->email;

        $message = 'Updated e-mail successfully.';
        $this->updateWithFlash($user, $message);
    }

    public function updatepw() {
        $this->validate([
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        $user = User::find($this->user->id);
        if(!Hash::check($this->old_password, $user->password)) {
            return $this->addError('old_password', 'The old password does not match this entry.');
        }

        $user->password = bcrypt($this->new_password);

        $message = 'Changed password successfully.';
        $this->updateWithFlash($user, $message);
    }
    public function updatesubscription() {
        $user = User::find($this->user->id);

        if($this->subscription === true) {
            $user->email_notifications = 1;
        } else {
            $user->email_notifications = 0;
        }
        $message = 'Changed preference successfully.';
        $this->updateWithFlash($user, $message);
    }

    public function updategoals() {
        $this->validate([
            'goals' => 'required'
        ]);

        $user = User::find($this->user->id);
        $user->goals = $this->goals;

        $message = 'Updated goals successfully.';
        $this->updateWithFlash($user, $message);
    }

    public function updatehistory() {
        $this->validate([
            'history' => 'required'
        ]);

        $user = User::find($this->user->id);
        $user->history = $this->history;

        $message = 'Updated history successfully.';
        $this->updateWithFlash($user, $message);
    }

    public function deleteaccount() {
        $user = User::find(auth()->user()->id);
        $user->delete();
        $message = 'Deleted account successfully.';
        $this->redirectWithFlash($message);
    }

    public function mount() {
        $this->email = $this->user->email;
        $this->goals = $this->user->goals;
        $this->history = $this->user->history;
        if($this->user->email_notifications === 1) {
            $this->subscription = true;
        } else {
            $this->subscription = false;
        }
        $this->balances = Balance::where('user_id', $this->user->id)->get();
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
