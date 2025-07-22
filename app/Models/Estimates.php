<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estimates extends Model
{
    protected $table = 'estimates';
    protected $primaryKey = 'estimates_id';
    protected $fillable = [
        'services_id',
        'clients_id',
        'mechanical_workshops_id',
        'date',
    ];
    public $timestamps = false;
}
