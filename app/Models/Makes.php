<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makes extends Model
{
    protected $table = 'makes';
    protected $primaryKey = 'makes_id';
    protected $fillable = [
        'names',
    ];
}
