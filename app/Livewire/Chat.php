<?php

namespace App\Livewire;

use App\Models\Flight;
use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Collection;

class Chat extends Component
{
    public Flight $flight;
    public string $message = '';
    public Collection $messages;

    public function mount(Flight $flight)
    {
        $this->flight = $flight;
        $this->loadMessages();
    }

    #[On('refresh')]
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
        $this->dispatch('refresh');
        $this->dispatch(
            'closeModal',
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

        $this->dispatch('messageDeleted');
        $this->loadMessages();
    }

    #[On('closeModal', 'messageDeleted')]
    public function render()
    {
        return view('livewire.chat');
    }
}
