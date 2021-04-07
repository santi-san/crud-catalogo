<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    # Cambiar nombre a la tabla (plurales esp)
    // protected $table = 'regiones';
    # Deshabilita (created_at y updated_at)
    public $timestamps = false;
    # Cambiar nombre de ID por el ID del nombre de la tabla
    protected $primaryKey = 'idMarca';
}
