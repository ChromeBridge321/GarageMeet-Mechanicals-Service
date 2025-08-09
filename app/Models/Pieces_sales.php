<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pieces_sales extends Model
{
    protected $table = 'pieces_sales';

    protected $fillable = [
        'services_sales_id',
        'pieces_id',
    ];
    public $timestamps = false;

    public function serviceSale()
    {
        return $this->belongsTo(Services_sales::class, 'services_sales_id');
    }

    public function piece()
    {
        return $this->belongsTo(Pieces::class, 'pieces_id');
    }
}
