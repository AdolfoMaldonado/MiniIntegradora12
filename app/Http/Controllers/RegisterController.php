<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Register;

class RegisterController extends Controller
{
    private function fetchDataFromFeed($token, $nombre)
    {
        $response = Http::withHeaders(['X-AIO-key' => $token])
            ->get("https://io.adafruit.com/api/v2/AlbMaldonado2994/feeds/{$nombre}");
        return $response->json();
    }

    public function Datos(Request $request, $nombre)
    {
        $token = $request->header('X-AIO-key');
        $Data = $this->fetchDataFromFeed($token, $nombre . '/data');
    
        return response()->json([
            'status' => 'ok',
            'datos' => $Data
        ], 200);
    }
    

    public function Ultimo(Request $request, $nombre)
    {
        $token = $request->header('X-AIO-key');
        $datos = $this->fetchDataFromFeed($token, $nombre);
    
        return response()->json($datos, 200);
    }
    

    public function Todo(Request $request)
    {
        $token = $request->header('X-AIO-key');

        $feeds = ['humedad', 'lluvia', 'sonido','temperatura'];

        $dataSubset = [];

        foreach ($feeds as $feed) {
            $Data = $this->fetchDataFromFeed($token, $feed);
            $dataSubset[$feed] = [
                'name' => $Data['name'],
                'last_value' => $Data['last_value'],
                'created_at' => $Data['created_at']
            ];
        }

        return response()->json($dataSubset, 200);
    }


}
