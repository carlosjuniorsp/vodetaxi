<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusDriver extends Model
{
    use SoftDeletes;
    protected $table = 'status_driver';

    protected $fillable = [
        'driver_id',
        'zip_code',
        'active',
        'in_running',
        'distance',
    ];

    protected $hidden = [
        'updated_at'
    ];

    /**
     * Relationship to driver model
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}
