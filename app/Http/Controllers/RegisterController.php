<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Register;

class RegisterController extends Controller
{
    private function fetchDataFromFeed($token, $feedName)
    {
        $response = Http::withHeaders(['X-AIO-key' => $token])
            ->get("https://io.adafruit.com/api/v2/AlbMaldonado2994/feeds/{$feedName}");
        return $response->json();
    }

    public function obtenerDatosFeed(Request $request, $feedName)
    {
        $token = $request->header('X-AIO-key');
        $feedData = $this->fetchDataFromFeed($token, $feedName . '/data');
    
        return response()->json([
            'status' => 'ok',
            'datos' => $feedData
        ], 200);
    }
    

    public function obtenerUltimoDato(Request $request, $feedName)
    {
        $token = $request->header('X-AIO-key');
        $datos = $this->fetchDataFromFeed($token, $feedName);
    
        return response()->json($datos, 200);
    }
    

    public function obtenerTodo(Request $request)
    {
        $token = $request->header('X-AIO-key');

        $feeds = ['humedad', 'lluvia', 'sonido','temperatura'];

        $dataSubset = [];

        foreach ($feeds as $feed) {
            $feedData = $this->fetchDataFromFeed($token, $feed);
            $dataSubset[$feed] = [
                'name' => $feedData['name'],
                'last_value' => $feedData['last_value'],
                'created_at' => $feedData['created_at']
            ];
        }

        return response()->json($dataSubset, 200);
    }


}
