<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;
    protected $primaryKey = 'users_id';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Verificar si el usuario tiene una suscripción activa
    public function hasActiveSubscription(): bool
    {
        return $this->subscribed('default');
    }

    // Obtener la suscripción activa
    public function getActiveSubscription()
    {
        return $this->subscription('default');
    }

    // Verificar si puede acceder al panel de control
    public function canAccessDashboard(): bool
    {
        if (!$this->hasActiveSubscription()) {
            return false;
        }

        $subscription = $this->getActiveSubscription();

        // Verificar que la suscripción existe y está activa
        if (!$subscription) {
            return false;
        }

        // Verificar el estado de la suscripción
        $activeStates = ['active', 'trialing'];

        return in_array($subscription->stripe_status, $activeStates) &&
            !$subscription->ended();
    }

    // Verificar si la suscripción está cancelada pero aún activa
    public function hasSubscriptionCancelled(): bool
    {
        if (!$this->hasActiveSubscription()) {
            return false;
        }

        $subscription = $this->getActiveSubscription();
        return $subscription && $subscription->ends_at !== null && !$subscription->ended();
    }
}
