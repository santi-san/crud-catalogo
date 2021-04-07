<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtenemos el listado de marcas
        // $marcas = Marca::all();
        $marcas = Marca::paginate(5);

        return view('adminMarcas', 
                [ 'marcas'=>$marcas ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agregarMarca');
    }

    /**
     * Valida los input
     * @param Request $request
     */
    private function validar(Request $request): void
    {
        $request->validate(
            [
                'mkNombre' => 'required|min:2|max:30'
            ],
            [
                'mkNombre.required'=>'El campo Nombre de la marca es obligatorio',
                'mkNombre.min'=>'El campo "Nombre de la marca" debe tener al menos 2 caractéres.',
                'mkNombre.max'=>'El campo "Nombre de la marca" debe tener 30 caractéres como máximo.'
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
        $mkNombre = $request->mkNombre;
        #Validacion
        $this->validar($request);
        // return 'si ves esto es porque paso la validacion';
        #Instanciacion, asignacion de valores y guardar
        $Marca = new Marca;
        $Marca->mkNombre = $mkNombre;
        $Marca->save();
        #retonar peticion + mensaje de ok
        return redirect('/adminMarcas')
                        ->with(['mensaje'=>'Marca: '.$mkNombre.' agregada correctamente.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //obtenemos datos de una marca por su id
        $Marca = Marca::find($id);
        //retornamos vista del formulario con datos de la marca
        return view('modificarMarca',
                    [ 'Marca'=>$Marca ]
                );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        # Capturar
        $mkNombre = $request->mkNombre;
        //validamos
        $this->validar($request);
        //obtenemos datos de una marca
        $Marca = Marca::find($request->idMarca);
        //modificamos atributos
        $Marca->mkNombre = $mkNombre;
        //guardamos
        $Marca->save();
        //retornar peticion + mensaje ok
        return redirect('/adminMarcas')
            ->with(['mensaje'=>'Marca: '.$mkNombre.' modificada correctamente']);
    }




    public function confirmar($id) 
    {
        // Consultar si hay productos con esa marca
        $productos = Producto::where('idMarca', $id)->get()->count();
        # obtner los datos de una marca
        $Marca = Marca::find($id);

        # retornar la vista
        return view('eliminarMarca',
                [ 
                    'Marca'=>$Marca,
                    'productos'=>$productos
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Marca::destroy($request->idMarca);

        return redirect('/adminMarcas')
            ->with(['mensaje'=>'Marca: '.$request->mkNombre.' eliminado correctamente']);
    }
}
