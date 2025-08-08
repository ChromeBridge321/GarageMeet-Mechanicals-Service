<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function retornar()
    {
        return response()->json('hola');
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Obtener el usuario autenticado con su taller mecánico
        $user = auth('api')->user()->load('mechanicalWorkshop');

        // Preparar los datos del usuario
        $userData = [
            'id' => $user->users_id,
            'email' => $user->email,
            'type_user' => $user->typeUser->name ?? null, // Asegurarse de que el tipo de usuario esté cargado
            'name' => $user->name,
            'last_name' => $user->last_name,
        ];

        // Agregar datos del taller mecánico si existe, excluyendo created_at y updated_at
        if ($user->mechanicalWorkshop) {
            $mechanicalData = $user->mechanicalWorkshop->toArray();
            unset($mechanicalData['created_at']);
            unset($mechanicalData['updated_at']);
            $userData['mechanical_workshop'] = $mechanicalData;
        } else {
            $userData['mechanical_workshop'] = null;
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $userData
        ]);
    }


    public function register(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'name' => 'required|string|max:60',
            'last_name' => 'required|string|max:90',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:4',
            'type_user' => 'required|int|',
        ]);

        if ($validar->fails()) {
            return response()->json(['error' => $validar->messages()], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'type_users_id' => $request->input('type_user'),
        ]);

        $stripeCustomer = $user->createAsStripeCustomer();

        // Generar token JWT para el usuario recién registrado
        $token = auth('api')->login($user);

        // Cargar relación del tipo de usuario
        $user->load('typeUser');

        // Preparar los datos del usuario
        $userData = [
            'id' => $user->users_id,
            'email' => $user->email,
            'type_user' => $user->typeUser->name ?? null,
            'name' => $user->name,
            'last_name' => $user->last_name,
        ];

        // El usuario recién registrado no tiene taller mecánico
        $userData['mechanical_workshop'] = null;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $userData
        ], Response::HTTP_CREATED);
    }

    /**
     * Update user data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request)
    {
        $user = auth('api')->user();
        // return $user;

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validar = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:60',
            'last_name' => 'sometimes|string|max:90',
            'email' => 'sometimes|string|max:255|unique:users,email,' . $user->users_id . ',users_id',
            'password' => 'sometimes|string|min:4|confirmed',
            'current_password' => 'required_with:password|string',
            'type_users_id' => 'sometimes|int|exists:type_users,type_users_id',

        ]);

        if ($validar->fails()) {
            return response()->json(['error' => $validar->messages()], Response::HTTP_BAD_REQUEST);
        }

        // Verificar contraseña actual si se está actualizando la contraseña
        if ($request->has('password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return response()->json(['error' => 'Current password is incorrect'], Response::HTTP_BAD_REQUEST);
            }
        }

        // Actualizar solo los campos que se envían en la solicitud
        $updateData = [];

        if ($request->has('name')) {
            $updateData['name'] = $request->input('name');
        }

        if ($request->has('last_name')) {
            $updateData['last_name'] = $request->input('last_name');
        }

        if ($request->has('email')) {
            $updateData['email'] = $request->input('email');
        }

        if ($request->has('password')) {
            $updateData['password'] = Hash::make($request->input('password'));
        }

        if ($request->has('type_users_id')) {
            $updateData['type_users_id'] = $request->input('type_users_id');
        }

        // Actualizar el usuario
        $user->update($updateData);

        // Preparar los datos del usuario actualizado
        $userData = [
            'users_id' => $user->users_id,
            'email' => $user->email,
            'type_user' => $user->typeUser->name ?? null,
            'name' => $user->name,
            'last_name' => $user->last_name,
            //'stripe_id' => $user->stripe_id,
        ];

        if ($user->hasStripeId()) {
            $user->syncStripeCustomerDetails();
        }

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $userData
        ], Response::HTTP_OK);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Pass true to force the token to be blacklisted "forever"
        auth('api')->logout(true);
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::refresh();
        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
