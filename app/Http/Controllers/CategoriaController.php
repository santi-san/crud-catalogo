<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtenemos el listado de categorias
        // $categorias = Categoria::all();
        $categorias = Categoria::paginate(7);

        return view('adminCategorias', 
                [ 'categorias'=>$categorias ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agregarCategoria');
    }


    /**
     * Valida los input
     * @param Request $request
     */
    private function validar(Request $request): void
    {
        $request->validate(
            [
                'catNombre' => 'required|min:2|max:30'
            ],
            [
                'catNombre.required'=>'El campo Nombre de la categoria es obligatorio',
                'catNombre.min'=>'El campo "Nombre de la categoria" debe tener al menos 2 caractéres.',
                'catNombre.max'=>'El campo "Nombre de la categoria" debe tener 30 caractéres como máximo.'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //guardar el dato
        $catNombre = $request->catNombre;
        #Validacion
        $this->validar($request);
        // return 'si ves esto es porque paso la validacion';
        #Instanciacion, asignacion de valores y guardar
        $Categoria = new Categoria;
        $Categoria->catNombre = $catNombre;
        $Categoria->save();
        #retonar peticion + mensaje de ok
        return redirect('/adminCategorias')
                        ->with(['mensaje'=>'Categoria: '.$catNombre.' agregada correctamente.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //obtenemos datos de una marca por su id (select id from tabla where id is X)
        $Categoria = Categoria::find($id);
        //retornamos vista del formulario con datos de la marca, [var + asociativo]
        return view('modificarCategoria',
                    [ 'Categoria'=>$Categoria ]
                );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        # Capturar
        $catNombre = $request->catNombre;
        //validamos
        $this->validar($request);
        //obtenemos datos de una marca
        $Categoria = Categoria::find($request->idCategoria);
        //modificamos atributos
        $Categoria->catNombre = $catNombre;
        //guardamos
        $Categoria->save();
        //retornar peticion + mensaje ok
        return redirect('/adminCategorias')
            ->with(['mensaje'=>'Categoria: '.$catNombre.' modificada correctamente']);
    }


    public function confirmar($id) 
    {
        // Consultar si hay productos con esa categoria
        $productos = Producto::where('idCategoria', $id)->get()->count();
        # obtener los datos de una categoria
        $Categoria = Categoria::find($id);

        # retornar la vista
        return view('eliminarCategoria',
                [ 
                    'Categoria'=>$Categoria,
                    'productos'=>$productos
                ]
            );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Categoria::destroy($request->idCategoria);

        return redirect('/adminCategorias')
            ->with(['mensaje'=>'Categoria: '.$request->catNombre.' eliminada correctamente']);
    }
}
