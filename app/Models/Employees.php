<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'employees_id';
    protected $fillable = [
        'mechanical_workshops_id',
        'peoples_id',
    ];

    public function person()
    {
        return $this->belongsTo(Peoples::class, 'peoples_id');
    }
}
