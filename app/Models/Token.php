<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'token';
    protected $primaryKey = 'id_token';
    protected $fillable = ['user_id', 'token', 'device_name', 'last_used_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
