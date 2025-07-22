<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mechanicals extends Model
{
    protected $table = 'mechanical_workshops';
    protected $fillable = [
        'users_id',
        'cities_id',
        'name',
        'cellphone_number',
        'email',
        'address',
        'google_maps_link'

    ];
    public $timestamps = false;
}
