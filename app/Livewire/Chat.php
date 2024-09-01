<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\Flight;

class Chat extends Component
{
    public $flight;
    public $message = '';
    public $messages;

    public function mount(Flight $flight)
    {
        $this->flight = $flight;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = $this->flight->messages()->latest()->get();
    }

    public function sendMessage()
    {
        Message::create([
            'user_id' => auth()->id(),
            'flight_id' => $this->flight->id,
            'content' => $this->message,
        ]);

        $this->message = '';
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
