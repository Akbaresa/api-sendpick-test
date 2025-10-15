<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusJobOrder extends Model
{
    protected $table = 'status_job_orders';
    protected $primaryKey = 'id_status_job_order';
    protected $fillable = ['status_job_order_name'];

    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class, 'status_id', 'id_status_job_order');
    }
}
