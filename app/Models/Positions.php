<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $table = 'positions';
    protected $primaryKey = 'positions_id';
    protected $fillable = [
        'name',
        'mechanical_workshops_id'
    ];
    public $timestamps = false;
    public function employees()
    {
        return $this->belongsToMany(Employees::class, 'employes_positions', 'positions_id', 'employees_id');
    }
}
