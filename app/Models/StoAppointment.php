<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoAppointment extends Model
{
    use HasFactory;

    protected $table = 'sto_appointments';

    protected $fillable = [
        'service_id',
        'service_name',
        'name',
        'phone',
        'appointment_date',
        'status',
        'notes',
    ];
}
