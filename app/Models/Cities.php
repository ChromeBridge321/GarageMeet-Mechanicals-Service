<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';
    protected $primaryKey = 'cities_id';
    protected $fillable = [
        'name',
        'states_id',
    ];
    public $timestamps = false;
    public function state()
    {
        return $this->belongsTo(States::class, 'states_id');
    }
}
