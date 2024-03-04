<?php

namespace App\Livewire;

use App\Models\Pricing;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Handle Pricing')]
class HandlePricing extends Component
{
    public $pricings = [];

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $pricingsx = [];

    #[Rule('required', message: 'Please provide a title.')]
    public $title;
    #[Rule('required', message: 'The type is necessary for balances to be processed correctly.')]
    public $type;
    #[Rule('required', message: 'Please provide Stripe\'s price id (e.g. price_1OYtUEJVbfotMwBUkGGyd9Ja).')]
    public $priceid;
    #[Rule('required', message: 'Please provide a price as an whole number.')]
    public $price;
    #[Rule('required', message: 'Please provide the amount of visits as an whole number.')]
    public $amount;
    #[Rule('required', message: 'Please provide a group title (e.g. Online Class).')]
    public $location;
    #[Rule('required', message: 'The order position will determine in which order the pricings are listed.')]
    public $order_position;
    // #[Rule('required', message: 'Please add a description of the pricing.')]
    public $description;


    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/handle-pricing');
    }

    public function addpricing() {
        $this->validate([
            'title' => 'required',
            'type' => 'required',
            'priceid' => 'required',
            'price' => 'required',
            'amount' => 'required',
            'location' => 'required',
            'order_position' => 'required',
            // 'description' => 'required',
        ]);

        if(!$this->description) $this->description = '';
        if(
            !($this->type === 'online' || 
            $this->type === 'outdoor' || 
            $this->type === 'studio' || 
            $this->type === 'private online' || 
            $this->type === 'private studio')
        ) return $this->addError('type', 'Please choose one of the available types.');

        Pricing::create([
            'title' => $this->title,
            'type' => $this->type,
            'priceid' => $this->priceid,
            'price' => $this->price,
            'amount' => $this->amount,
            'location' => $this->location,
            'order_position' => $this->order_position,
            'description' => $this->description,
        ]);
        $message = 'Created pricing successfully.';
        $this->redirectWithFlash($message);
    }

    public function updatepricing($index, $id) {
        if($this->pricingsx[$index]['title'] === '') {
            return $this->addError('pricingsx' . $index . 'title', 'Please provide a title.');
        }
        if($this->pricingsx[$index]['type'] === '') {
            return $this->addError('pricingsx' . $index . 'type', 'The type is necessary for balances to be processed correctly.');
        }
        if($this->pricingsx[$index]['priceid'] === '') {
            return $this->addError('pricingsx' . $index . 'priceid', 'Please provide Stripe\'s price id (e.g. price_1OYtUEJVbfotMwBUkGGyd9Ja).');
        }
        if($this->pricingsx[$index]['price'] === '') {
            return $this->addError('pricingsx' . $index . 'price', 'Please provide a price as an whole number.');
        }
        if($this->pricingsx[$index]['amount'] === '') {
            return $this->addError('pricingsx' . $index . 'amount', 'Please provide the amount of visits as an whole number.');
        }
        if($this->pricingsx[$index]['location'] === '') {
            return $this->addError('pricingsx' . $index . 'location', 'Please provide a group title (e.g. Online Class).');
        }
        if($this->pricingsx[$index]['order_position'] === '') {
            return $this->addError('pricingsx' . $index . 'order_position', 'The order position will determine in which order the pricings are listed.');
        }
        if(!$this->pricingsx[$index]['description']) $this->pricingsx[$index]['description'] = '';
        if(
            !($this->pricingsx[$index]['type'] === 'online' || 
            $this->pricingsx[$index]['type'] === 'outdoor' || 
            $this->pricingsx[$index]['type'] === 'studio' || 
            $this->pricingsx[$index]['type'] === 'private online' || 
            $this->pricingsx[$index]['type'] === 'private studio')
        ) return $this->addError('pricingsx' . $index . 'type', 'Please choose one of the available types.');

        // if($this->pricingsx[$index]['description'] === '') {
        //     $this->pricingsx[$index]['description'] = '';
        //     return $this->addError('pricingsx' . $index . 'description', 'Please add a description for the pricing.');
        // }
        $class = Pricing::find($id);
        $class->title = $this->pricingsx[$index]['title'];
        $class->type = $this->pricingsx[$index]['type'];
        $class->priceid = $this->pricingsx[$index]['priceid'];
        $class->price = $this->pricingsx[$index]['price'];
        $class->amount = $this->pricingsx[$index]['amount'];
        $class->location = $this->pricingsx[$index]['location'];
        $class->order_position = $this->pricingsx[$index]['order_position'];
        $class->description = $this->pricingsx[$index]['description'];

        $class->update();
        session()->flash('message', 'Updated pricing successfully.');
        $this->redirect('/handle-pricing');
    }

    public function deletepricing($id) {
        $class = Pricing::find($id);
        $class->delete();
        session()->flash('message', 'Deleted pricing successfully.');
        $this->redirect('/handle-pricing');
    }

    public function mount() {
        $this->pricings = Pricing::orderBy('order_position', 'desc')->get();
        foreach($this->pricings as $class){
            array_push($this->pricingsx, [
                'id' => $class->id,
                'title' => $class->title,
                'type' => $class->type,
                'priceid' => $class->priceid,
                'price' => $class->price,
                'amount' => $class->amount,
                'location' => $class->location,
                'order_position' => $class->order_position,
                'description' => $class->description,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.handle-pricing');
    }
}
