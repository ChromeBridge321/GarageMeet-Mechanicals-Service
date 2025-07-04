<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'vehicles_id';
    protected $fillable = [
        'make',
        'plates',
        'model',
        'clients_id',
    ];
    public function client()
    {
        return $this->belongsTo(clients::class, 'clients_id');
    }
}
