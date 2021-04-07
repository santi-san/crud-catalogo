<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    # Cambiar nombre a la tabla (plurales esp)
    // protected $table = 'regiones';
    # Deshabilita (created_at y updated_at)
    public $timestamps = false;
    # Cambiar nombre de ID por el ID del nombre de la tabla
    protected $primaryKey = 'idProducto';
    #############################
    ### Metodos de relaciones ###

    public function relMarca() 
    {
        return $this->belongsTo(
                Marca::class,
                'idMarca',
                'idMarca'
            );
    }
    public function relCategoria() 
    {
        return $this->belongsTo(
                Categoria::class,
                'idCategoria',
                'idCategoria'
            );
    }
}
