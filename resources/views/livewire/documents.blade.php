<div class="container-fluid">
    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Documents</h5>

                @if ($selectedDocument === 'loadsheet')
                    <button type="button" class="btn btn-sm btn-primary bi-printer-fill" onclick="generatePDF()"> Print Loadsheet</button>
                @endif

                <div>
                    <select wire:model.live="selectedDocument" class="form-select form-select-sm">
                        <option value="" disabled>Select a document</option>
                        <option value="loadsheet">Load Sheet</option>
                        <option value="loadplan">Load Plan</option>
                        <option value="loadmessage">Load Message</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @if ($selectedDocument === 'loadsheet')
                    @include('flight.partials.loadsheet', ['flight' => $flight])
                @elseif ($selectedDocument === 'loadplan')
                    @include('flight.partials.loadplan', ['flight' => $flight])
                @elseif ($selectedDocument === 'loadmessage')
                    @include('flight.partials.loadmessage', ['flight' => $flight])
                @else
                    <p class="text-muted">Please select a document to view.</p>
                @endif
            </div>
        </div>
    </div>
</div>
