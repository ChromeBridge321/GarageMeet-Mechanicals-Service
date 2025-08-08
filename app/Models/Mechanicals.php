<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class Mechanicals extends Model
{
    protected $table = 'mechanical_workshops';
    protected $fillable = [
        'users_id',
        'cities_id',
        'states_id',
        'name',
        'cellphone_number',
        'email',
        'address',
        'google_maps_link'

    ];
    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo(Cities::class, 'cities_id', 'cities_id');
    }

    public function services()
    {
        return $this->hasMany(Services::class, 'mechanical_workshops_id', 'id');
    }

    public function paymentTypes()
    {
        return $this->hasMany(Payment_types::class, 'mechanical_workshops_id', 'id');
    }

}
