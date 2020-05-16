<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    public function index(){
        return response()->json([
            'area' => 'Administrativa',
            'obs' => 'Foi necessario realizar a autentificação para cheagar aqui'
        ], 401);
    }
    }
    
