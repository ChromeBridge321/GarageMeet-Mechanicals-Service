<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'countries';
    protected $primaryKey = 'countries_id';
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;
    public function states()
    {
        return $this->hasMany(States::class, 'countries_id');
    }
}
