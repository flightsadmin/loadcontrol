<?php

namespace App\Livewire;

use App\Models\Envelope;
use Livewire\Component;

class EnvelopeManager extends Component
{
    public $envelopes = [];

    public $isEditable = [];

    public $aircraftType;

    public $newEnvelopeType;

    public function mount($aircraftType)
    {
        $this->aircraftType = $aircraftType;
        $this->loadEnvelopes();
    }

    public function loadEnvelopes()
    {
        $this->envelopes = Envelope::where('aircraft_type_id', $this->aircraftType)
            ->get()
            ->groupBy('envelope_type')
            ->toArray();
    }

    public function toggleEdit($type)
    {
        $this->isEditable[$type] = ! ($this->isEditable[$type] ?? false);
    }

    public function addEnvelope($type)
    {
        $this->envelopes[$type][] = ['envelope_type' => $type, 'index' => 0.0, 'weight' => 0];
    }

    public function removeEnvelope($type, $index)
    {
        $envelopeData = $this->envelopes[$type][$index];
        if (isset($envelopeData['id'])) {
            $en = Envelope::where('aircraft_type_id', $this->aircraftType)
                ->where('id', $envelopeData['id'])
                ->where('envelope_type', $envelopeData['envelope_type'])
                ->delete();
        }
        unset($this->envelopes[$type][$index]);
        $this->envelopes[$type] = array_values($this->envelopes[$type]);
    }

    public function createType()
    {
        if (! empty($this->newEnvelopeType) && ! array_key_exists($this->newEnvelopeType, $this->envelopes)) {
            $this->envelopes[$this->newEnvelopeType] = [];
            $this->newEnvelopeType = '';
        }
    }

    public function save()
    {
        foreach ($this->envelopes as $type => $envelopeGroup) {
            foreach ($envelopeGroup as $envelope) {
                Envelope::updateOrCreate(
                    ['id' => $envelope['id'] ?? null],
                    [
                        'aircraft_type_id' => $this->aircraftType,
                        'envelope_type' => $type,
                        'index' => $envelope['index'],
                        'weight' => $envelope['weight'],
                    ]
                );
            }
        }
        $this->loadEnvelopes();
        $this->isEditable = [];
    }

    public function render()
    {
        return view('livewire.envelope-manager');
    }
}
