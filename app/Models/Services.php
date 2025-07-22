<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'services_id';
    protected $fillable = [
        'mechanicals_workshops_id',
        'name',

    ];
    public $timestamps = false;
}
