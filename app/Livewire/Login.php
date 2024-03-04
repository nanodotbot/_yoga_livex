<?php

namespace App\Livewire;

use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class Login extends Component
{
    #[Rule('required', message: 'Please login using your e-mail address.')]
    #[Rule('email', message: 'Please login using your e-mail address.')]
    public $email = '';

    #[Rule('required', message: 'Please login using your password.')]
    public $password = '';

    public $rememberme;

    public $previous;

    public function login() {
        $this->validate();

        if($this->rememberme) {
            if(auth()->attempt([
                'email' => $this->email,
                'password' => $this->password
            ], true)) {
                session()->regenerate();
                session()->flash('message', 'Logged-in successfully.');
                $this->redirect($this->previous);
            } else {
                $this->addError('password', message: 'Your credentials are invalid.');
            }
        } else {
            if(auth()->attempt([
                'email' => $this->email,
                'password' => $this->password
            ])) {
                session()->regenerate();
                session()->flash('message', 'Logged-in successfully.');
                $this->redirect($this->previous);
            } else {
                $this->addError('password', message: 'Your credentials are invalid.');
            }
        }

    }
    public function mount() {
        $this->previous = URL::previous();
    }

    public function render()
    {
        return view('livewire.login');
    }
}
