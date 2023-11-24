<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;
    protected $table = 'driver';

    protected $fillable = [
        'name',
        'email',
        'password',
        'city',
        'state',
        'address',
        'phone',
        'age',
        'picture',
        'gender',
        'description',
        'account_validation'
    ];

    protected $hidden = [
        'updated_at'
    ];
}
