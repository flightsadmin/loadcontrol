<?php

namespace App\Livewire;

use App\Models\Flight;
use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\Component;

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
        $this->dispatch(
            'notify',
            icon: 'success',
            message: 'Message sent successfully.',
        );
        $this->message = '';
        $this->loadMessages();
    }

    public function delete($messageId)
    {
        $message = Message::findOrFail($messageId);
        $message->delete();
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.chat');
    }
}
