<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use Illuminate\Http\Request;
use SoapServer;

class SoapController extends Controller
{
    public function handle(Request $request)
    {
        $server = new SoapServer(null, [
            'uri' => '/soap',
        ]);

        $server->setClass(self::class);
        ob_start();
        $server->handle($request->getContent());
        $response = ob_get_clean();

        return response($response)->header('Content-Type', 'text/xml');
    }

    public function listClients()
    {
        $clientes = Client::all();
        return response()->json($clientes);
    }

    public function createClient($ci, $nombre, $telefono, $direccion, $email)
    {        
        $ci = $ci;
        $nombre = (string) $nombre;
        $telefono = $telefono;
        $direccion = (string) $direccion;
        $email = (string) $email;
        
        $validator = Validator::make([
            'ci' => $ci,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'email' => $email,
        ], [
            'ci' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|digits:8',
            'direccion' => 'required|string|max:255',
            'email' => 'nullable|string|email|unique:cliente,email',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $cliente = Client::create([
            'ci' => $ci,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'email' => $email,
        ]);
        
        return response()->json(['message' => 'Cliente creado correctamente', 'data' => $cliente], 201);
    }
}
