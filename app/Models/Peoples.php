<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peoples extends Model
{
    protected $table = 'peoples';
    protected $primaryKey = 'peoples_id';
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'cellphone_number',

    ];

}
