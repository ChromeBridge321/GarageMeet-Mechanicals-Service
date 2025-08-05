<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table = 'states';
    protected $primaryKey = 'states_id';

    protected $fillable = [
        'name',
        'countries_id',
    ];
    public $timestamps = false;
    public function country()
    {
        return $this->belongsTo(Countries::class, 'countries_id');
    }

    public function cities()
    {
        return $this->hasMany(Cities::class, 'states_id');
    }
}
