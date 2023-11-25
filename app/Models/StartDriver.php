<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StartDriver extends Model
{
    protected $table = 'start_driver';

    protected $fillable = [
        'client_id',
        'driver_id',
        'from_zip_code',
        'to_zip_code',
        'distance_client',
        'running',
        'finished'
    ];

    protected $hidden = [
        'updated_at'
    ];
}
