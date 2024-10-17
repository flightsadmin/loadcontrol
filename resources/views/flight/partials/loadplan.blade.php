<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="mb-1 d-flex justify-content-between align-items-center">
                <span class="bi-skip-backward-fill h5"> FWD</span>
                <h4 class="text-center"><strong>Loading Instruction Report</strong></h4>
                <span class="h5">ED NO 1</span>
            </div>
            <div class="row my-1 align-items-center">
                <div class="col-sm-2"> <strong>{{ $flight->flight_number }}</strong> </div>
                <div class="col-sm-2"> <strong>{{ $flight->registration->registration_number }} </strong></div>
                <div class="col-sm-2"> <strong>{{ $flight->departure }} </strong></div>
                <div class="col-sm-2"> <strong>{{ $flight->origin }} </strong></div>
                <div class="col-sm-2"> <strong>{{ $flight->destination }} </strong></div>
                <div class="col-sm-2"> <strong>Prepared By: {{ auth()->user()->name }} </strong></div>
            </div>

            <div class="col-md-12 position-relative my-2" style="height: 150px">
                <div class="position-absolute"
                    style="top: 70%; left: -20px; transform: translateY(-50%) rotate(-90deg); transform-origin: left top;">
                    <span class="">Arrival</span>
                </div>
                @foreach ($flight->registration->aircraftType->holds as $hold)
                    <div class="hold position-absolute"
                        style="top: 0; left: {{ $hold->fwd }}%; width: {{ $hold->aft - $hold->fwd }}%; height: 100%; background-color: grey; border: 10px solid #6c757d;">
                        <span class="text-white">{{ $hold->hold_no }} <small class="ms-3">Max {{ $hold->max }}</small></span>
                    </div>
                @endforeach
            </div>

            <div class="col-md-12 position-relative my-2" style="height: 150px;">
                <div class="position-absolute"
                    style="top: 70%; left: -20px; transform: translateY(-50%) rotate(-90deg); transform-origin: left top;">
                    <span class="">Loading</span>
                </div>
                @foreach ($flight->registration->aircraftType->holds as $hold)
                    <div class="hold position-absolute"
                        style="top: 0; left: {{ $hold->fwd }}%; width: {{ $hold->aft - $hold->fwd }}%; height: 100%; background-color: grey; border: 10px solid #6c757d;">
                        <span class="text-white">{{ $hold->hold_no }} <small class="ms-3">Max {{ $hold->max }}</small></span>
                        <ul class="mt-2">
                            @forelse ($flight->cargos->where('hold_id', $hold->id) as $cargo)
                                <li class="d-flex justify-content-between align-items-center">
                                    <span class="badge text-bg-primary rounded-pill mb-1">
                                        {{ ucfirst($cargo->type) }} - {{ $cargo->pieces }} / {{ $cargo->weight }}kg
                                    </span>
                                </li>
                            @empty
                                <span>NIL</span>
                            @endforelse
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="col-md-12 position-relative my-2" style="height: 150px">
                <div class="position-absolute"
                    style="top: 70%; left: -20px; transform: translateY(-50%) rotate(-90deg); transform-origin: left top;">
                    <span class="">Departure</span>
                </div>
                @foreach ($flight->registration->aircraftType->holds as $hold)
                    <div class="hold position-absolute"
                        style="top: 0; left: {{ $hold->fwd }}%; width: {{ $hold->aft - $hold->fwd }}%; height: 100%; background-color: grey; border: 10px solid #6c757d;">
                        <span class="text-white">{{ $hold->hold_no }} <small class="ms-3">Max {{ $hold->max }}</small></span>
                    </div>
                @endforeach
            </div>

            <div class="col-md-12">
                <div class="row mt-3">
                    <div class="col-sm-3 border p-2">
                        <strong>Special Instructions</strong>
                        <div class="border-top pt-2"></div>
                    </div>
                    <div class="col-sm-3 border p-2">
                        <strong>Special Load Details</strong>
                        <div class="border-top pt-2"></div>
                    </div>
                    <div class="col-sm-6 border p-2">
                        <strong>I Certify That:</strong>
                        <p class="small">
                            THIS AIRCRAFT HAS BEEN LOADED IN ACCORDANCE WITH THE ABOVE LOADING INSTRUCTIONS,
                            INCLUDING ANY DEVIATIONS SHOWN ON THE DEPARTURE REPORT.
                            ALL DEADLOAD LOADED OR DISTRIBUTED AT THIS PORT HAS BEEN SECURED BY THE AIRCRAFT NETTING AND/OR COMPANY
                            APPROVED RESTRAINT EQUIPMENT.
                            ALL NETTING AND/OR RESTRAINT EQUIPMENT HAS BEEN INSPECTED AND APPROPRIATE CORRECTIVE ACTION HAS BEEN TAKEN
                            FOR DAMAGE NOTED PRIOR TO DEPARTURE.
                        </p>
                        <div class="d-flex justify-content-between">
                            <span>Signed: _____________________</span>
                            <span>Name: _______________________</span>
                            <span>Date: _______________________</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
