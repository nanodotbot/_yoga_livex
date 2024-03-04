<?php

namespace App\Livewire;

use App\Models\Subscription;
use App\Models\User;
use Livewire\Component;

class HandleSubscription extends Component
{
    public $subscriptions = [];
    public $filtered_subscriptions = [];
    public $ids = [];
    public $grouped_ids = [];
    public $grouped_subscriptions = [];

    public function mount() {
        $this->subscriptions = Subscription::with('classes')->with('users')->orderBy('classes_id')->get();
        foreach($this->subscriptions as $subscription) {
            // dd($subscription);
            $class_id = $subscription->classes[0]['id'];
            $class_title = $subscription->classes[0]['title'];
            $start_time = $subscription->classes[0]['startTime'];
            $user_name = $subscription->users[0]['name'];
            array_push($this->filtered_subscriptions, [
                'id' => $class_id,
                'title' => $class_title,
                'start_time' => $start_time,
                'user_name' => $user_name,
            ]);
            array_push($this->ids, $class_id);
        }
        foreach($this->ids as $key => $value) {
            $class_id = $this->filtered_subscriptions[$key]['id'];
            $class_title = $this->filtered_subscriptions[$key]['title'];
            $start_time = $this->filtered_subscriptions[$key]['start_time'];
            $user_name = $this->filtered_subscriptions[$key]['user_name'];
     
            if(array_search($value,$this->ids) === $key){
                array_push($this->grouped_subscriptions, [
                    'id' => $class_id,
                    'title' => $class_title,
                    'start_time' => $start_time,
                    'users' => [$user_name]    
                ]);
                array_push($this->grouped_ids, $class_id);
            } else {
                $gkey = array_search($class_id, $this->grouped_ids);
                // dd($gkey);
                // dd($this->grouped_subscriptions[$gkey]['users']);
                array_push($this->grouped_subscriptions[$gkey]['users'], $user_name);
            }
        }
    }

    public function render()
    {
        return view('livewire.handle-subscription');
    }
}
