<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutentificadorController extends Controller
{
    public function registro(Request $request){
         //parte de validadação
         $request->validate([
            'password' => 'required|string|confirmed',
            'email' => 'required|string|email|unique:users'
        ]);
        //criando o usuario
        $user = new User([
            'name'=>$request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
        ]);
        //salvando
        $user->save();
        return response()->json([
            'res' => 'Usuario criado com sucesso'
        ], 201);
    }

    public function login(Request $request){
        $request->validate([
            'password' => 'required|string',
            'email' => 'required|string|email'
        ]);

        $credencias = [
            'password' => $request->password,
            'email' => $request->email
        ];

        //retorna um true ou false
        if (!Auth::attempt($credencias)) {
             return response()->json([
                'res' => 'Acesso negado Email ou senha inválido'
            ], 401);
        }
        //criando token de validação de usuario
        $user = $request->user();
        $token = $user->createToken('Token de acesso')->accessToken;
        //retornando token de acesso com a devida confirmação
        return response()->json([
            'token' => $token,
            'user'=> $user
        ], 200);
    }

    public function logout(Request $request){
        //revogando token com o revoke
        $request->user()->token()->revoke();
        return response()->json([
            'res' => 'Deslogado com sucesso'
        ], 200);
    }
}
