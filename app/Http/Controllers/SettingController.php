<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\AircraftType;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(AircraftType $aircraftType)
    {
        $setting = $aircraftType->setting;
        return view('settings.index', compact('setting', 'aircraftType'));
    }

    public function create(AircraftType $aircraftType)
    {
        return view('settings.create', compact('aircraftType'));
    }

    public function store(Request $request, AircraftType $aircraftType)
    {
        $validated = $request->validate([
            'settings' => 'nullable|array',
            'aircraft' => 'nullable|array',
        ]);

        $aircraftType->setting()->updateOrCreate(
            ['aircraft_type_id' => $aircraftType->id],
            ['settings' => $validated]
        );

        return redirect()->route('aircraft_types.settings.index', $aircraftType)
            ->with('success', 'Settings created successfully');
    }

    public function edit(AircraftType $aircraftType, Setting $setting)
    {
        return view('settings.edit', compact('setting', 'aircraftType'));
    }

    public function update(Request $request, AircraftType $aircraftType, Setting $setting)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        $setting->update([
            'settings' => $request->settings
        ]);

        return redirect()->route('aircraft_types.settings.index', $aircraftType)
            ->with('success', 'Settings updated successfully');
    }

    public function destroy(AircraftType $aircraftType, Setting $setting)
    {
        $setting->delete();
        return redirect()->route('aircraft_types.settings.index', $aircraftType)
            ->with('success', 'Settings deleted successfully');
    }
}
