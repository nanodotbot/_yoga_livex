<?php

namespace App\Livewire;

use App\Models\About;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Handle About')]
class HandleAbout extends Component
{
    public $paragraphs = [];

    #[Rule('required', message: 'Please provide a position and a text.')]
    public $paragraphsx = [];

    #[Rule('required', message: 'Please provide a order position for the paragraph.')]
    public $position;
    #[Rule('required', message: 'Well, if you want to create a paragraph, you should provide some text.')]
    public $paragraph;

    public function redirectWithFlash($message) {
        session()->flash('message', $message);
        $this->redirect('/handle-about');
    }

    public function addparagraph() {
        $this->validate([
            'position' => 'required',
            'paragraph' => 'required'
        ]);
        About::create([
            'position' => $this->position,
            'paragraph' => $this->paragraph,
        ]);
        $message = 'Created paragraph successfully.';
        $this->redirectWithFlash($message);
    }

    public function updateparagraph($index, $id) {
        if($this->paragraphsx[$index]['position'] === '') {
            return $this->addError('paragraphsx' . $index . 'position', 'Please provide a position for the text.');
        }
        if($this->paragraphsx[$index]['paragraph'] === '') {
            return $this->addError('paragraphsx' . $index . 'paragraph', 'Please add some text for the paragraph.');
        }
        $about = About::find($id);
        $about->position = $this->paragraphsx[$index]['position'];
        $about->paragraph = $this->paragraphsx[$index]['paragraph'];
        $about->update();
        session()->flash('message', 'Updated paragraph successfully.');
        $this->redirect('/handle-about');
    }

    public function deleteparagraph($id) {
        $about = About::find($id);
        $about->delete();
        session()->flash('message', 'Deleted paragraph successfully.');
        $this->redirect('/handle-about');
    }

    public function mount() {
        $this->paragraphs = About::orderBy('position')->get();
        foreach ($this->paragraphs as $index => $paragraph) {
            array_push($this->paragraphsx, [
                'id' => $paragraph->id,
                'position' => $paragraph->position,
                'paragraph' => $paragraph->paragraph,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.handle-about');
    }
}
