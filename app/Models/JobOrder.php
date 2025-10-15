<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_orders';
    protected $primaryKey = 'id_job_order';

    protected $fillable = [
        'job_number',
        'customer_name',
        'pickup_address',
        'destination_address',
        'status_id',
        'driver_id',
        'vehicle_id',
        'total_weight',
        'total_volume',
    ];

    public function status()
    {
        return $this->belongsTo(StatusJobOrder::class, 'status_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function manifests()
    {
        return $this->hasMany(Manifest::class, 'job_order_id', 'id_job_order');
    }
}
