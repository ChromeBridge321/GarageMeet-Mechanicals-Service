<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentMethod;
use Stripe\SetupIntent;
use Stripe\Customer;
use Stripe\Exception\CardException;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        // Asegurar que Stripe esté configurado
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createSetupIntent(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        try {
            // Crear o obtener el customer de Stripe
            if (!$user->stripe_id) {
                $customer = Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);

                $user->stripe_id = $customer->id;
                $user->save();
            }

            // Crear SetupIntent
            $setupIntent = SetupIntent::create([
                'customer' => $user->stripe_id,
                'payment_method_types' => ['card'],
                'usage' => 'off_session'
            ]);

            return response()->json([
                'client_secret' => $setupIntent->client_secret,
                'setup_intent_id' => $setupIntent->id
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function attachPaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string'
        ]);

        $user = auth('api')->user();

        if (!$user || !$user->stripe_id) {
            return response()->json(['error' => 'Usuario no encontrado o sin Stripe ID'], 400);
        }

        try {
            $paymentMethod = PaymentMethod::retrieve($request->payment_method_id);
            $paymentMethod->attach(['customer' => $user->stripe_id]);

            return response()->json([
                'message' => 'Método de pago agregado exitosamente',
                'payment_method' => $paymentMethod
            ]);
        } catch (CardException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPaymentMethods()
    {
        $user = auth('api')->user();

        if (!$user || !$user->stripe_id) {
            return response()->json(['error' => 'Usuario no encontrado'], 400);
        }

        try {
            $paymentMethods = PaymentMethod::all([
                'customer' => $user->stripe_id,
                'type' => 'card'
            ]);

            return response()->json([
                'payment_methods' => collect($paymentMethods->data)->map(function ($pm) {
                    return [
                        'id' => $pm->id,
                        'type' => $pm->type,
                        'card' => $pm->card ? [
                            'brand' => $pm->card->brand,
                            'last4' => $pm->card->last4,
                            'exp_month' => $pm->card->exp_month,
                            'exp_year' => $pm->card->exp_year
                        ] : null
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deletePaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string'
        ]);

        try {
            $paymentMethod = PaymentMethod::retrieve($request->payment_method_id);
            $paymentMethod->detach();

            return response()->json(['message' => 'Método de pago eliminado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
