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
        'clients_id',
        'pieces_id',
        'date',
        'price',
    ];
    public $timestamps = false;
}
