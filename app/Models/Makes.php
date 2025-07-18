<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makes extends Model
{
    protected $table = 'makes';
    protected $primaryKey = 'make_id';
    protected $fillable = [
        'name',
    ];

    // Relación con la tabla MakeModel (uno a muchos)
    public function makeModels()
    {
        return $this->hasMany(MakeModel::class, 'make_id', 'make_id');
    }

    // Relación muchos a muchos con Models a través de MakeModel
    public function models()
    {
        return $this->belongsToMany(Models::class, 'makes_model', 'make_id', 'model_id');
    }
}
