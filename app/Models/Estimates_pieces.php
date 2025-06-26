<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estimates_pieces extends Model
{
    protected $table = 'estimates_pieces';
    protected $fillable = [
        'estimates_id',
        'pieces_id',
    ];
}
