<?php

namespace App\Livewire;

use App\Models\Classes;
use App\Models\ClassType;
use App\Models\Pricing;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Handle Classes')]
class HandleClasses extends Component
{
    public $classes = [];
    public $classtypes = [];

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $classesx = [];

    #[Rule('required', message: 'Please provide a title.')]
    public $title;
    #[Rule('required', message: 'Please provide a price id (Stripe).')]
    public $price_id;
    #[Rule('required', message: 'Please provide a start time.')]
    public $startTime;
    #[Rule('required', message: 'Please provide length in minutes.')]
    public $length;
    // #[Rule('required', message: 'Please estimate how many people can attend to the class.')]
    public $places;

    public $teacher;
    public $level;
    public $description;

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/handle-classes');
    }

    public function addclass() {
        $this->validate([
            'title' => 'required',
            'price_id' => 'required',
            'startTime' => 'required',
            'length' => 'required',
            // 'places' => 'required',
        ]);

        if($this->teacher === null) $this->teacher = '';
        if($this->level === null) $this->level = '';
        if($this->description === null) $this->description = '';
        if($this->places === null) $this->places = 9999;

        $pricing = Pricing::where('priceid', $this->price_id)->first();

        if(!$pricing) {
            return $this->addError('price_id', 'The price id doesn\'t match any of the pricing\'s price ids.');
        }

        Classes::create([
            'title' => $this->title,
            'price_id' => $this->price_id,
            'startTime' => $this->startTime,
            'length' => $this->length,
            'places' => $this->places,
            'teacher' => $this->teacher,
            'level' => $this->level,
            'description' => $this->description,
        ]);
        $message = 'Created class successfully.';
        $this->redirectWithFlash($message);
    }

    public function updateclass($index, $id) {
        if($this->classesx[$index]['title'] === '') {
            return $this->addError('classesx' . $index . 'title', 'Please provide a title for the class.');
        }
        if($this->classesx[$index]['price_id'] === '') {
            return $this->addError('classesx' . $index . 'price_id', 'Please provide a price id for the class.');
        }
        if($this->classesx[$index]['startTime'] === '') {
            return $this->addError('classesx' . $index . 'startTime', 'Please provide a start time for the class.');
        }
        if($this->classesx[$index]['length'] === '') {
            return $this->addError('classesx' . $index . 'length', 'Please provide a duration in minutes.');
        }
        if($this->classesx[$index]['places'] === '') $this->classesx[$index]['places'] = 9999;
        // if($this->classesx[$index]['places'] === '') {
        //     return $this->addError('classesx' . $index . 'places', 'Please provide the number of available places for attendees.');
        // }
        // if($this->classesx[$index]['description'] === '') {
        //     return $this->addError('classesx' . $index . 'description', 'Please add a short description.');
        // }
        $pricing = Pricing::where('priceid', $this->classesx[$index]['price_id'])->first();
        if(!$pricing) {
            return $this->addError('price_id', 'The price id doesn\'t match any of the pricing\'s price ids.');
        }

        $class = Classes::find($id);
        $class->title = $this->classesx[$index]['title'];
        $class->price_id = $this->classesx[$index]['price_id'];
        $class->startTime = $this->classesx[$index]['startTime'];
        $class->length = $this->classesx[$index]['length'];
        $class->places = $this->classesx[$index]['places'];
        $class->teacher = $this->classesx[$index]['teacher'];
        $class->level = $this->classesx[$index]['level'];
        $class->description = $this->classesx[$index]['description'];
        $class->update();
        session()->flash('message', 'Updated class successfully.');
        $this->redirect('/handle-classes');
    }

    public function deleteclass($id) {
        $class = Classes::find($id);
        $class->delete();
        session()->flash('message', 'Deleted class successfully.');
        $this->redirect('/handle-classes');
    }

    public function mount() {
        $this->classes = Classes::orderBy('startTime', 'desc')->get();
        $this->classtypes = ClassType::orderBy('order_position', 'desc')->get();
        foreach($this->classes as $class){
            array_push($this->classesx, [
                'id' => $class->id,
                'title' => $class->title,
                'price_id' => $class->price_id,
                'startTime' => $class->startTime,
                'length' => $class->length,
                'places' => $class->places,
                'teacher' => $class->teacher,
                'level' => $class->level,
                'description' => $class->description,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.handle-classes');
    }
}
