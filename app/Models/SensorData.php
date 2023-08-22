<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;
    protected $fillable = [
        'feed_id',
        'name',
        'description',
        // Agrega más campos aquí según la estructura de los datos
        'created_at',
        'updated_at'
    ];
}
