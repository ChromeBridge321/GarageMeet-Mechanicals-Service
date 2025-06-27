<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

        return response()->json(['message' => 'guardado con exito', 'user' => $user], Response::HTTP_CREATED);
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
