<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $primaryKey = 'id_location';

    protected $fillable = [
        'job_order_id',
        'type',
        'address',
        'lat',
        'lng',
    ];

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class, 'job_order_id', 'id_job_order');
    }
}
