<?php

namespace App\Livewire;

use App\Models\Balance;
use App\Models\Classes as ModelsClasses;
use App\Models\ClassType;
use App\Models\Pricing;
use App\Models\Subscription;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Classes')]
class Classes extends Component
{
    public $classes = [];
    public $classesx = [];
    public $classesSelection = [];

    public $classtypes = [];
    public $classtypesx = [];

    public $pricings = [];
    public $balances = [];

    // calendar

    public $selectionYear;
    public $selectionMonth;

    public $currentYear;
    public $currentMonth;
    public $currentDay;
    public $currentDate;

    public $daysInMonth;
    public $weeksInMonth;

    public $weekdays = 7;

    public $active = False;
    public $activeDate;

    public function daysInMonth($month = null, $year = null) {
        if ($year === null) $year = date("Y",time());
        if ($month === null) $month = date("m", time());

        $numDays = date('t', strtotime($year . '-' . $month . '-01'));
        return $numDays;
    }
    public function weeksInMonth($month = null, $year = null) {
        if ($year === null) $year = date("Y",time());
        if ($month === null) $month = date("m", time());

        $daysInMonth = $this->daysInMonth($month, $year);
        $numWeeks = ($daysInMonth % 7 === 0 ? 0 : 1) + intval($daysInMonth / 7);

        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
        $monthEndingDay = date('N',strtotime($year.'-'.$month.'-'.$daysInMonth));
        if($monthEndingDay < $monthStartDay) $numWeeks++;

        return $numWeeks;
    }
    public function increaseMonth() {
        if($this->currentMonth === 12) {
            $this->selectionMonth = 1;
            $this->selectionYear = intval($this->currentYear) + 1;
        } else {
            $this->selectionMonth = intval($this->currentMonth) + 1;
            $this->selectionYear = $this->currentYear;
        }
    }
    public function decreaseMonth() {
        if($this->currentMonth === 1) {
            $this->selectionMonth = 12;
            $this->selectionYear = intval($this->currentYear) - 1;
        } else {
            $this->selectionMonth = intval($this->currentMonth) - 1;
            $this->selectionYear = $this->currentYear;
        }
    }
    public function filterClasses($date) {
        $this->active = True;
        $this->activeDate = $date;
        $this->classesSelection = array_filter($this->classesx, function($k) {
            $startTime = strtotime($this->classesx[$k]['startTime']);
            $startTime = date("Y-m-d", $startTime);

            return $this->activeDate === $startTime;
        }, ARRAY_FILTER_USE_KEY);
    }

    public function sendregistermail($id, $user) {
        $domain = env('DOMAIN');
        $class = ModelsClasses::find($id);
        $mail_message = '
            <html>

                <body>
                    <main>                        
                        <p>Dear ' . $user->name . ',<br><br>
                        You have successfully subscribed to the following class.<br><br>
                        With gratitude and good vibes,<br><br>
                        Angi Yoga</p>
                        <table>
                            <tr>
                                <td>title:</td><td>' . $class->title . '</td>
                            </tr>
                            <tr>
                                <td>start time:</td><td>' . $class->startTime . '</td>
                            </tr>
                            <tr>
                                <td>length:</td><td>' . $class->length . '</td>
                            </tr>
                            <tr>
                                <td>description:</td><td>' . $class->description . '</td>
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
        $recipients = $user->email;
        $subject = 'Angi Yoga - Class registration';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);

        $subject = 'Angi Yoga - Class registration - ' . $user->name;
        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }
    public function sendunregistermail($id, $user) {
        $domain = env('DOMAIN');
        $class = ModelsClasses::find($id);
        $mail_message = '
            <html>

                <body>
                    <main>                        
                        <p>Dear ' . $user->name . ',<br><br>
                        You have successfully un-subscribed from the following class.<br><br>
                        With gratitude and good vibes,<br><br>
                        Angi Yoga</p>
                        <table>
                            <tr>
                                <td>title:</td><td>' . $class->title . '</td>
                            </tr>
                            <tr>
                                <td>start time:</td><td>' . $class->startTime . '</td>
                            </tr>
                            <tr>
                                <td>length:</td><td>' . $class->length . '</td>
                            </tr>
                            <tr>
                                <td>description:</td><td>' . $class->description . '</td>
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
        $recipients = $user->email;
        $subject = 'Angi Yoga - Class un-registration';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= 'From: info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);

        $subject = 'Angi Yoga - Class un-registration - ' . $user->name;
        $recipients = 'angi@angi.yoga, info@nano.sx';
        mail($recipients, $subject, $mail_message, $headers);
    }

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/classes');
    }

    public function unregister($id, $price_id) {
        $subscription = Subscription::where('user_id', auth()->user()->id, 'and')->where('classes_id', $id)->first();
        $user = User::find(auth()->user()->id);

        $pricing = Pricing::where('priceid', $price_id)->first();
        $type = $pricing->type;
        $amount = $pricing->amount;

        $subscription->delete();

        $balance = Balance::where('user_id', $user->id, 'and')->where('type', $type)->first();
        $balance->balance = $balance->balance + $amount;
        $balance->update();

        $this->sendunregistermail($id, $user);

        $message = 'Un-registered from class successfully.';
        $this->redirectWithFlash($message);
    }

    public function register($id, $price_id) {
        $subscription = Subscription::where('user_id', auth()->user()->id, 'and')->where('classes_id', $id)->first();
        $user = User::find(auth()->user()->id);

        $pricing = Pricing::where('priceid', $price_id)->first();
        $type = $pricing->type;
        $amount = $pricing->amount;
        
        if(!$subscription) {
            Subscription::create([
                'user_id' => auth()->user()->id,
                'classes_id' => $id
            ]);
            $balance = Balance::where('user_id', $user->id, 'and')->where('type', $type)->first();
            $balance->balance = $balance->balance - $amount;
            $balance->update();

            $this->sendregistermail($id, $user);

            $message = 'Registered for class successfully.';
            $this->redirectWithFlash($message);    
        }
    }

    public function mount() {
        $this->classes = ModelsClasses::orderBy('startTime')->get();
        $this->classtypes = ClassType::orderBy('order_position')->get();
        if (auth()->user()) {
            $this->balances = Balance::where('user_id', auth()->user()->id)->get();
        }
        $this->pricings = Pricing::all();

        $current = time();
        foreach($this->classes as $class){
            $time = strtotime($class->startTime);
            // $date = date("d.m.Y H:i", $current);

            foreach ($this->pricings as $pricing) {
                if ($pricing->priceid === $class->price_id) {
                    $type = $pricing->type;
                }
            }
            if ($this->balances && count($this->balances) !== 0) {
                foreach ($this->balances as $balance) {
                    if ($balance->type === $type && $balance->user_id === auth()->user()->id) {
                        $currentBalance = $balance->balance;
                    }
                }
            } else {
                $currentBalance = '';
            }

            if(auth()->user()){
                $subscribed = Subscription::where('user_id', auth()->user()->id, 'and')->where('classes_id', $class->id)->first();
            } else {
                $subscribed = null;
            }
            $subscriptions = Subscription::where('classes_id', $class->id)->get();
            $count = count($subscriptions);
            // dd($class->startTime);
            if($current < $time) {
                array_push($this->classesx, [
                    'id' => $class->id,
                    'title' => $class->title,
                    'type' => $type,
                    'price_id' => $class->price_id,
                    'balance' => $currentBalance,
                    'startTime' => $class->startTime,
                    'length' => $class->length,
                    'places' => $class->places,
                    'teacher' => $class->teacher,
                    'level' => $class->level,
                    'description' => $class->description,
                    'subscribed' => $subscribed,
                    'count' => $count,
                ]);
            }
        }
    }

    public function render()
    {
        // calendar

        if ($this->selectionYear) {
            $this->currentYear = $this->selectionYear;
        } else {
            $this->currentYear = intval(date("Y", time()));
        }
        if ($this->selectionMonth) {
            $this->currentMonth = $this->selectionMonth;
        } else {
            $this->currentMonth = intval(date("m", time()));
        }

        $this->daysInMonth = $this->daysInMonth($this->currentMonth, $this->currentYear);
        $this->weeksInMonth = $this->weeksInMonth($this->currentMonth, $this->currentYear);

        return view('livewire.classes');
    }
}
