<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Chat for: {{ $flight->flight_number }}</h5>
                </div>
                <div class="card-body p-4" style="height: 520px; overflow-y: auto;">
                    @foreach ($messages as $message)
                        <div class="d-flex {{ auth()->id() === $message->user_id ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                            <div
                                class="d-flex flex-column {{ auth()->id() === $message->user_id ? 'align-items-end' : 'align-items-start' }}">
                                <div class="rounded p-2 {{ auth()->id() === $message->user_id ? 'bg-secondary-subtle' : 'bg-primary-subtle' }}">
                                    <strong>{{ $message->user->name }}</strong>
                                    <span class="text-muted"><small>{{ $message->created_at->format('H:i') }}</small></span>
                                    <p class="mb-0">{{ $message->content }}</p>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <form wire:submit.prevent="sendMessage" class="d-flex">
                        <input type="text" wire:model="message" class="form-control me-2" placeholder="Type your message..." required />
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>