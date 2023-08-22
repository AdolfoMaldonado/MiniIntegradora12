<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Register;
use App\Models\SensorData;

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

        $sensorData = new SensorData();
        $sensorData->fill([
            'feed_id' => $datos['id'],
            'name' => $datos['name'],
            'description' => $datos['description'],
            // Llena más campos aquí según la estructura de los datos
            'created_at' => $datos['created_at'],
            'updated_at' => $datos['updated_at']
        ]);

        // Guarda la instancia en la base de datos
        $sensorData->save();

        return response()->json($datos, 200);
    }

    public function Todo(Request $request)
    {
        $token = $request->header('X-AIO-key');

        $feeds = ['humedad', 'lluvia', 'sonido', 'temperatura', 'proximidad', 'luminosidad'];

        $dataSubset = [];

        foreach ($feeds as $feed) {
            $Data = $this->fetchDataFromFeed($token, $feed);
            $dataSubset[$feed] = [
                'name' => $Data['name'],
                'last_value' => $Data['last_value'] === '0' ? 'Apagado' : ($Data['last_value'] === '1' ? 'Encendido' : $Data['last_value']),
                'created_at' => $Data['created_at']
            ];
        }

        return response()->json($dataSubset, 200);
    }
}
