<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Stripe\Exception\CardException;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    public function getPlans()
    {
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();

        return response()->json([
            'plans' => $plans
        ]);
    }

    public function createSubscription(Request $request)
    {
        $request->validate([
            'price_id' => 'required|string',
            'payment_method_id' => 'required|string'
        ]);

        $user = auth('api')->user();

        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        try {
            // Verificar si ya tiene una suscripción activa
            if ($user->hasActiveSubscription()) {
                return response()->json([
                    'error' => 'Ya tienes una suscripción activa'
                ], 400);
            }

            // Crear la suscripción
            $subscription = $user->newSubscription('default', $request->price_id)
                ->create($request->payment_method_id);

            return response()->json([
                'message' => 'Suscripción creada exitosamente',
                'subscription' => [
                    'id' => $subscription->stripe_id,
                    'status' => $subscription->stripe_status,
                    'current_period_end' => $subscription->ends_at,
                ]
            ]);

        } catch (IncompletePayment $exception) {
            return response()->json([
                'requires_action' => true,
                'payment_intent' => [
                    'id' => $exception->payment->id,
                    'client_secret' => $exception->payment->client_secret,
                ]
            ]);
        } catch (CardException $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 400);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Error al crear la suscripción: ' . $exception->getMessage()
            ], 500);
        }
    }

    public function getSubscriptionStatus()
    {
        $user = auth('api')->user();

        if (!$user->hasActiveSubscription()) {
            return response()->json([
                'has_subscription' => false,
                'can_access_dashboard' => false
            ]);
        }

        $subscription = $user->getActiveSubscription();
        $plan = SubscriptionPlan::where('stripe_price_id', $subscription->stripe_price)->first();

        return response()->json([
            'has_subscription' => true,
            'can_access_dashboard' => $user->canAccessDashboard(),
            'subscription' => [
                'id' => $subscription->stripe_id,
                'status' => $subscription->stripe_status,
                'current_period_end' => $subscription->ends_at,
                'cancel_at_period_end' => $subscription->ends_at !== null,
                'cancelled' => $user->hasSubscriptionCancelled(),
                'plan' => $plan
            ]
        ]);
    }

    public function cancelSubscription()
    {
        $user = auth('api')->user();

        if (!$user->hasActiveSubscription()) {
            return response()->json([
                'error' => 'No tienes una suscripción activa'
            ], 400);
        }

        try {
            $subscription = $user->subscription('default');
            $subscription->cancel();

            return response()->json([
                'message' => 'Suscripción cancelada. Tendrás acceso hasta el final del período actual.'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Error al cancelar la suscripción: ' . $exception->getMessage()
            ], 500);
        }
    }

    public function resumeSubscription()
    {
        $user = auth('api')->user();

        if (!$user->hasActiveSubscription()) {
            return response()->json([
                'error' => 'No tienes una suscripción activa'
            ], 400);
        }

        try {
            $subscription = $user->subscription('default');

            // Verificar si la suscripción está cancelada pero no ha terminado
            if ($subscription->ends_at !== null && !$subscription->ended()) {
                $subscription->resume();

                return response()->json([
                    'message' => 'Suscripción reactivada exitosamente'
                ]);
            }

            return response()->json([
                'error' => 'La suscripción no puede ser reactivada'
            ], 400);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Error al reactivar la suscripción: ' . $exception->getMessage()
            ], 500);
        }
    }

    public function changePlan(Request $request)
    {
        $request->validate([
            'price_id' => 'required|string'
        ]);

        $user = auth('api')->user();

        if (!$user->hasActiveSubscription()) {
            return response()->json([
                'error' => 'No tienes una suscripción activa'
            ], 400);
        }

        try {
            $subscription = $user->subscription('default');
            $subscription->swap($request->price_id);

            return response()->json([
                'message' => 'Plan cambiado exitosamente'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Error al cambiar el plan: ' . $exception->getMessage()
            ], 500);
        }
    }
}
