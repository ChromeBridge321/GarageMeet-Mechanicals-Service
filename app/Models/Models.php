<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    protected $table = 'models';
    protected $primaryKey = 'models_id';
    protected $fillable = [
        'names',
        'makes_id',
    ];
}
