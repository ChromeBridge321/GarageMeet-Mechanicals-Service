<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'services_id';
    protected $fillable = [
        'mechanical_workshops_id',
        'name',

    ];
    public $timestamps = false;

    public function mechanicalWorkshop()
    {
        return $this->belongsTo(Mechanicals::class, 'mechanical_workshops_id', 'id');
    }
}
