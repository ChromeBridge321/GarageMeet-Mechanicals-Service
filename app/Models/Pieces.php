<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pieces extends Model
{
    protected $table = 'pieces';
    protected $primaryKey = 'pieces_id';
    protected $fillable = [
        'name',
        'mechanical_workshops_id',
        'price',
    ];
}
