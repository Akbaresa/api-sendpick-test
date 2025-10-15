<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    protected $table = 'manifests';
    protected $primaryKey = 'id_manifest';

    protected $fillable = [
        'job_order_id',
        'item_name',
        'quantity',
        'weight',
        'volume',
        'notes',
    ];

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class, 'job_order_id', 'id_job_order');
    }
}
