<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cars extends Model
{
    use SoftDeletes;
    protected $table = 'Cars';

    protected $fillable = [
        'driver_id',
        'plate',
        'color',
        'year',
        'model',
        'name',
        'created_at',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    /**
     * Relationship to driver model
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}
