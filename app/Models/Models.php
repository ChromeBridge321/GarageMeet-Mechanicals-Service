<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    protected $table = 'models';
    protected $primaryKey = 'model_id';
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;
    // Relación con la tabla MakeModel (uno a muchos)
    public function makeModels()
    {
        return $this->hasMany(MakeModel::class, 'model_id', 'model_id');
    }

    // Relación muchos a muchos con Makes a través de MakeModel
    public function makes()
    {
        return $this->belongsToMany(Makes::class, 'makes_model', 'model_id', 'make_id');
    }
}
