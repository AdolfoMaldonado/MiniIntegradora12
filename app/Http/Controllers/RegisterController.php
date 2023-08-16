<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Register;

class RegisterController extends Controller
{
    public function getAdafruitDataAndStore(Request $request)
    {
        $url = 'https://io.adafruit.com/api/v2/YOUR_USERNAME/feeds/YOUR_FEED/data';
        
        $response = Http::withHeaders([
            'X-AIO-Key' => 'YOUR_AIO_KEY',
        ])->get($url);

        $data = $response->json();

        foreach ($data as $entry) {
            // Crea un nuevo registro en la tabla 'registers'
            Register::create([
                'datos' => $entry['value'], // Ajusta esto según la estructura de tus datos
                'unidades' => 'Tu Unidad', // Ajusta las unidades según tus necesidades
                'sensor_id' => 1, // Si deseas asociar el registro a un sensor específico
                'equipo_id' => 1, // Si deseas asociar el registro a un equipo específico
            ]);
        }

        return redirect()->route('home')->with('success', 'Datos de Adafruit almacenados correctamente.');
    }
}
