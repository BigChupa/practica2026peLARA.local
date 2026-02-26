<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller{



public function verifyStoAppointment($appointmentId)
{
    $appointment = \App\Models\StoAppointment::findOrFail($appointmentId);
    $appointment->status = 'confirmed';
    $appointment->save();
    return redirect()->route('admin.sto.appointments')->with('success', 'Статус оновлено!');
}

    public function stoAppointments()
    {
        $toCall = \App\Models\StoAppointment::whereNull('status')
            ->orWhere('status', 'pending')
            ->get();

        $called = \App\Models\StoAppointment::where('status', 'confirmed')->get();

        return view('admin.sto_appointments', compact('toCall', 'called'));
    }
    public function index()
    {
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $usersCount = User::count();
        $categoriesCount = Category::count();

        $stoAppointmentsToCall = \App\Models\StoAppointment::whereNull('status')
            ->orWhere('status', 'pending')
            ->get();

        $stoAppointmentsCalled = \App\Models\StoAppointment::where('status', 'confirmed')->get();

        $stoAppointmentsCount = \App\Models\StoAppointment::where('status', 'confirmed')->count();
        $stoAppointmentsPendingCount = \App\Models\StoAppointment::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'productsCount', 'ordersCount', 'usersCount', 'categoriesCount',
            'stoAppointmentsToCall', 'stoAppointmentsCalled', 'stoAppointmentsCount', 'stoAppointmentsPendingCount'
        ));
    }
    
    
}

