<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOffice extends Model
{
    protected $fillable = [
        'service',
        'ref',
        'number',
        'city_ref',
        'city_name',
        'address',
        'longitude',
        'latitude',
        'schedule',
        'is_active',
    ];

    protected $casts = [
        'schedule' => 'array',
        'longitude' => 'decimal:7',
        'latitude' => 'decimal:7',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByService($query, $service)
    {
        return $query->where('service', $service);
    }

    public function scopeByCity($query, $cityRef)
    {
        return $query->where('city_ref', $cityRef);
    }

    public function getFullAddressAttribute()
    {
        return $this->city_name . ', ' . $this->address;
    }
}
