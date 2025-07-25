<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'clients_id';
    protected $fillable = [
        'mechanical_workshops_id',
        'peoples_id',
    ];
    public $timestamps = false;
    public function person()
    {
        return $this->belongsTo(Peoples::class, 'peoples_id');
    }
    public function vehicles()
    {
        return $this->hasMany(Vehicles::class, 'clients_id');
    }
}
