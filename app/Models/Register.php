<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Register extends Model
{
    use HasFactory,SoftDeletes;
    protected $primaryKey = 'id';
    protected $fillable = [
    'datos',
    'unidades',
    'sensor_id',
    'equipo_id'
];

public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_id', 'sensor_id');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'equipo_id');
    }
    protected $table = 'registers';
}
