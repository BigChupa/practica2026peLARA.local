<?php

namespace App\Http\Controllers;

use App\Models\StoAppointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AppointmentController extends Controller
{
    public function create(Service $service)
    {
        return view('appointments.create', compact('service'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'service_name' => 'required_without:service_id|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        if (!Schema::hasColumn('sto_appointments', 'service_id')) {
            unset($validated['service_id']);
        }

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
