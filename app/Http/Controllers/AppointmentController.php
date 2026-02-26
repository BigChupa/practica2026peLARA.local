<?php

namespace App\Http\Controllers;

use App\Models\StoAppointment;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create(Service $service)
    {
        return view('appointments.create', compact('service'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        StoAppointment::create($validated);

        return redirect()->route('services')->with('success', 'Запит на послугу надіслано успішно! Ми зв\'яжемося з вами найближчим часом.');
    }

    public function index()
    {
        $appointments = StoAppointment::all();
        return view('appointments.index', compact('appointments'));
    }

    public function show(StoAppointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function cancel(StoAppointment $appointment)
    {
        if ($appointment->status !== 'completed') {
            $appointment->update(['status' => 'cancelled']);
        }

        return redirect()->route('appointments.index')->with('success', 'Запис скасовано.');
    }
}
