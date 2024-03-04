<?php

namespace App\Livewire;

use App\Models\ClassType;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Handle Class Styles')]
class HandleClassType extends Component
{
    public $classtypes = [];

    #[Rule('required', message: 'Please provide all necessary data.')]
    public $classtypesx = [];

    #[Rule('required', message: 'Please provide a title.')]
    public $title;
    #[Rule('required', message: 'Please provide a date and a time (e.g. every Monday 7pm).')]
    public $time_schedule;
    #[Rule('required', message: 'Please provide a location (online, outdoor, studio).')]
    public $location;
    #[Rule('required', message: 'The order position will determine in which order the class styles are listed.')]
    public $order_position;
    #[Rule('required', message: 'Please add a description of the class type.')]
    public $description;


    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/handle-class-type');
    }

    public function addclasstype() {
        $this->validate([
            'title' => 'required',
            'time_schedule' => 'required',
            'location' => 'required',
            'order_position' => 'required',
            'description' => 'required',
        ]);

        ClassType::create([
            'title' => $this->title,
            'time_schedule' => $this->time_schedule,
            'location' => $this->location,
            'order_position' => $this->order_position,
            'description' => $this->description,
        ]);
        $message = 'Created class type successfully.';
        $this->redirectWithFlash($message);
    }

    public function updateclasstype($index, $id) {
        if($this->classtypesx[$index]['title'] === '') {
            return $this->addError('classtypesx' . $index . 'title', 'Please provide a title.');
        }
        if($this->classtypesx[$index]['time_schedule'] === '') {
            return $this->addError('classtypesx' . $index . 'time_schedule', 'Please provide a date and a time (e.g. every Monday 7pm).');
        }
        if($this->classtypesx[$index]['location'] === '') {
            return $this->addError('classtypesx' . $index . 'location', 'Please provide a location (online, outdoor, studio).');
        }
        if($this->classtypesx[$index]['order_position'] === '') {
            return $this->addError('classtypesx' . $index . 'order_position', 'The order position will determine in which order the class styles are listed.');
        }
        if($this->classtypesx[$index]['description'] === '') {
            return $this->addError('classtypesx' . $index . 'description', 'Please add a description of the class type.');
        }
        $class = ClassType::find($id);
        $class->title = $this->classtypesx[$index]['title'];
        $class->time_schedule = $this->classtypesx[$index]['time_schedule'];
        $class->location = $this->classtypesx[$index]['location'];
        $class->order_position = $this->classtypesx[$index]['order_position'];
        $class->description = $this->classtypesx[$index]['description'];
        $class->update();
        session()->flash('message', 'Updated class type successfully.');
        $this->redirect('/handle-class-type');
    }

    public function deleteclasstype($id) {
        $class = ClassType::find($id);
        $class->delete();
        session()->flash('message', 'Deleted class type successfully.');
        $this->redirect('/handle-class-type');
    }

    public function mount() {
        $this->classtypes = ClassType::orderBy('order_position', 'desc')->get();
        foreach($this->classtypes as $class){
            array_push($this->classtypesx, [
                'id' => $class->id,
                'title' => $class->title,
                'time_schedule' => $class->time_schedule,
                'location' => $class->location,
                'order_position' => $class->order_position,
                'description' => $class->description,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.handle-class-type');
    }
}
