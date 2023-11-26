<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StartRace extends Model
{
    use SoftDeletes;
    protected $table = 'start_race';

    protected $fillable = [
        'client_id',
        'from_zip_code',
        'to_zip_code',
    ];

    protected $hidden = [
        'updated_at'
    ];

    /**
     * Relationship to client model
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
