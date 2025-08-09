<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services_sales extends Model
{
    protected $table = 'services_sales';
    protected $primaryKey = 'services_sales_id';
    protected $fillable = [
        'payment_types_id',
        'employees_id',
        'mechanical_workshops_id',
        'vehicles_id',
        'date',
        'price',
    ];
    public $timestamps = false;

    public function mechanicals()
    {
        return $this->belongsTo(Mechanicals::class, 'mechanical_workshops_id');
    }

    public function vehicles()
    {
        return $this->belongsTo(Vehicles::class, 'vehicles_id');
    }

    public function pieces()
    {
        return $this->hasMany(Pieces_sales::class, 'services_sales_id');
    }

    public function services()
    {
        return $this->hasMany(Services_by_sales::class, 'services_sales_id');
    }
}
