<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'vehicles_id';
    protected $fillable = [
        'makes_model_id',
        'plates',
        'clients_id',
    ];
    public function client()
    {
        return $this->belongsTo(clients::class, 'clients_id');
    }

    // Relación con la tabla MakeModel (muchos a uno)
    public function makeModel()
    {
        return $this->belongsTo(MakeModel::class, 'makes_model_id', 'makes_model_id');
    }
}
