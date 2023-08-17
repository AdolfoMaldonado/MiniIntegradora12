<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userequipo extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'users_equipos';
    protected $primaryKey = 'id';
    protected $fillable = [
    'user_id',
    'equipo_id'
];
public function sensuserr()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'equipo_id');
    }
    
}
