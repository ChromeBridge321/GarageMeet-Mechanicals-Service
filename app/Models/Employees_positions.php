<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees_positions extends Model
{
    protected $table = 'employees_positions';
    protected $fillable = [
        'employees_id',
        'positions_id',
    ];
}
