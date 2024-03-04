<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Payments')]
class Payments extends Component
{
    public $payments = [];
    public $dbpayments = [];
    public $users = [];
    // public $csid = '';

    public function render()
    {
        $this->dbpayments = Payment::orderBy('created', 'desc')->get();
        $this->users = User::orderBy('created_at', 'desc')->get();
        foreach ($this->dbpayments as $dbpayment) {
            $username = '';
            $useremail = '';
            foreach ($this->users as $dbuser) {
                if($dbpayment->user_id === $dbuser->id){
                    $username = $dbuser->name;
                    $useremail = $dbuser->email;
                }
            }
            array_push($this->payments, (object)
            [
                'username' => $username,
                'useremail' => $useremail,
                'stripeid' => $dbpayment->stripeid,
                'intent' => $dbpayment->intent,
                'amount' => $dbpayment->amount,
                'email' => $dbpayment->email,
                'name' => $dbpayment->name,
                'created' => $dbpayment->created,
            ]);
        }
        return view('livewire.payments');
    }
}
