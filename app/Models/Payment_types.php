<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment_types extends Model
{
    protected $table = 'payment_types';
    protected $primaryKey = 'payment_types_id';
    protected $fillable = ['name', 'mechanical_workshops_id'];
    public $timestamps = false;

    public function workshop()
    {
        return $this->belongsTo(Mechanicals::class, 'mechanical_workshops_id');
    }
}
