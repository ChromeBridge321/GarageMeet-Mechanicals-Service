<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakeModel extends Model
{
    protected $table = 'makes_model';
    protected $primaryKey = 'makes_model_id';
    protected $fillable = [
        'make_id',
        'model_id',
    ];

    // Relación con la tabla Makes (muchos a uno)
    public function make()
    {
        return $this->belongsTo(Makes::class, 'make_id', 'make_id');
    }

    // Relación con la tabla Models (muchos a uno)
    public function model()
    {
        return $this->belongsTo(Models::class, 'model_id', 'model_id');
    }

    // Relación con la tabla Vehicles (uno a muchos)
    public function vehicles()
    {
        return $this->hasMany(Vehicles::class, 'makes_model_id', 'makes_model_id');
    }
}
