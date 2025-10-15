<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id_vehicle';

    protected $fillable = [
        'plate_number',
        'type',
        'capacity',
    ];

    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class, 'vehicle_id', 'id_vehicle');
    }
}
