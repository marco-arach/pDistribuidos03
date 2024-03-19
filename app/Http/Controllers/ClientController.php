<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function listClients()
    {
        $clientes = Client::all();
        return response()->json($clientes);
    }

    public function createClient(Request $request)
    {
        $request->validate([
            'ci' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|digits:8',
            'direccion' => 'required|string|max:255',
            'email' => 'nullable|string|email|unique:cliente,email',
        ]);

        $cliente = Client::create([
            'ci' => $request->ci,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'email' => $request->email,
        ]);
        
        return response()->json(['message' => 'Cliente creado correctamente', 'data' => $cliente], 201);
    }
}
