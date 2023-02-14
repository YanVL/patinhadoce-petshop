<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registrar um novo usuário 
     **/
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $user->createToken('meuToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    /**
     * Login de usuário
     **/
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // checar email do usuario
        $user = User::where('email', $request->email)->first();

        //valida usuario e checa o password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        $token = $user->createToken('meuToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    /**
     * Recupera os dados do usuário com base no token
     **/
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Renova a autorização do usuario
     **/
    public function refresh(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'meuToken' => $request->user()->createToken('meuToken')->plainTextToken,
        ]);
    }

    /**
     * Desloga o usuário
     **/
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Usuário deslogado com sucesso'
        ];
    }
}
