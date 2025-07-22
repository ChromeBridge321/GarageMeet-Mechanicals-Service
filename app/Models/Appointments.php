<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'appointments_id';
    protected $fillable = [
        'mechanical_workshops_id',
        'services_id',
        'clients_id',
        'date'
    ];
    public $timestamps = false;
}
