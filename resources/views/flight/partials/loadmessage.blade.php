@if ($flight->loadsheet)
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="printable-content">
                @include('loadsheet.ldm-data')
            </div>
        </div>
    </div>
@else
    <div class="container mb-3">
        <p>Loadsheet not Finalised</p>
    </div>
@endif
