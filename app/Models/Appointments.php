<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointments extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'mechanical_workshops_id',
        'client_name',
        'client_email',
        'client_phone',
        'description',
        'appointment_date',
        'status',
        'created_by',
        'cancellation_token',
        'notes'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    // Generar token de cancelación automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (empty($appointment->cancellation_token)) {
                $appointment->cancellation_token = Str::random(64);
            }
        });
    }

    // Relaciones
    public function workshop()
    {
        return $this->belongsTo(Mechanicals::class, 'mechanical_workshops_id', 'id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeByWorkshop($query, $workshopId)
    {
        return $query->where('mechanical_workshops_id', $workshopId);
    }

    // Métodos de utilidad
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function getCancellationUrl()
    {
        return url("/appointments/cancel/{$this->cancellation_token}");
    }
}
