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
        'password',
        'city',
        'state',
        'address',
        'phone',
        'account_validation'
    ];

    protected $hidden = [
        'updated_at'
    ];
}
