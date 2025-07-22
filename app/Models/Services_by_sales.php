<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services_by_sales extends Model
{
    protected $table = 'services_by_sales';
    protected $fillable = [
        'services_id',
        'services_sales_id',
    ];
    public $timestamps = false;
}
