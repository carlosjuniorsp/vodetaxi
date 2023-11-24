<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use SoftDeletes;
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'city',
        'state',
        'address',
        'phone'
    ];

    protected $hidden = [
        'updated_at'
    ];
}
