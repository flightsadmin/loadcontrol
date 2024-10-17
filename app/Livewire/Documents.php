<?php

namespace App\Livewire;

use Livewire\Component;

class Documents extends Component
{
    public $selectedDocument = '';

    public $flight;

    public function mount($flight)
    {
        $this->flight = $flight;
        $this->selectedDocument = session()->get('selectedDocument', '');
    }

    public function updatedSelectedDocument($document)
    {
        session(['selectedDocument' => $document]);
    }

    public function render()
    {
        return view('livewire.documents');
    }
}
