<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees_positions extends Model
{
    protected $table = 'employes_positions';
    protected $fillable = [
        'employees_id',
        'positions_id',
    ];
    public $timestamps = false;
    public function position()
    {
        return $this->belongsTo(Positions::class, 'positions_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employees_id');
    }
}
