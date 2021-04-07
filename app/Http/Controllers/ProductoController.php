<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtenemos el listado de productos
        // $productos = Marca::all();
        $productos = Producto::with('relMarca', 'relCategoria')
                                ->paginate(8);

        return view('adminProductos', 
                [ 'productos'=>$productos ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //obtenemos listados de categorias y marcas
        $marcas = Marca::all();
        $categorias = Categoria::all();
        
        return view('agregarProducto',
                [
                    'marcas'=>$marcas,
                    'categorias'=>$categorias
                ]
        );
        
    }

    private function validar(Request $request) :void
    {
        $request->validate(
            [
                'prdNombre'=>'required|min:3|max:70',
                'prdPrecio'=>'required|numeric|min:0',
                'prdPresentacion'=>'required|min:3|max:150',
                'prdStock'=>'required|integer|min:1',
                'prdImagen'=>'mimes:jpg,jpeg,png,gif,svg,webp|max:2048'
            ],
            [
                'prdNombre.required'=>'Complete el campo Nombre',
                'prdNombre.min'=>'Complete el campo Nombre con al menos 3 caractéres',
                'prdNombre.max'=>'Complete el campo Nombre con 70 caractéres como máxino',
                'prdPrecio.required'=>'Complete el campo Precio',
                'prdPrecio.numeric'=>'Complete el campo Precio con un número',
                'prdPrecio.min'=>'Complete el campo Precio con un número positivo',
                'prdPresentacion.required'=>'Complete el campo Presentación',
                'prdPresentacion.min'=>'Complete el campo Presentación con al menos 3 caractéres',
                'prdPresentacion.max'=>'Complete el campo Presentación con 150 caractérescomo máxino',
                'prdStock.required'=>'Complete el campo Stock',
                'prdStock.integer'=>'Complete el campo Stock con un número entero',
                'prdStock.min'=>'Complete el campo Stock con un número positivo',
                'prdImagen.mimes'=>'Debe ser una imagen',
                'prdImagen.max'=>'Debe ser una imagen de 2MB como máximo'
            ]
            );
    }

    private function subirImagen(Request $request)
    {
        // si no enviaron archivo | método store()
        $prdImagen = 'noDisponible.jpg';

        // si no enviaron archivo | metodo update()
        if( $request->has('prdImageAnterior') ) {
            $prdImagen = $request->prdImageAnterior;
        }

        // si enviaron imagen
        if( $request->file('prdImagen') ){
            //renombrar archivo
                //time() . extensión-de-archivo
            $ext = $request->file('prdImagen')->extension();
            $prdImagen = time().'.'.$ext;
            //subir
            $request->file('prdImagen')
                    ->move( public_path('productos/'), $prdImagen );
        }

        return $prdImagen;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prdNombre = $request->prdNombre;
        $prdPrecio = $request->prdPrecio;
        $idMarca = $request->idMarca;
        $idCategoria = $request->idCategoria;
        $prdPresentacion = $request->prdPresentacion;
        $prdStock = $request->prdStock;
        $prdImagen = $request->prdImagen;
        # Validacion
        $this->validar($request);
        # Subir imagen
        $prdImagen = $this->subirImagen($request);
        # Instanciar + asignar + guardar
        $Producto = new Producto;
        $Producto->prdNombre = $prdNombre;
        $Producto->prdPrecio = $request->prdPrecio;
        $Producto->idMarca = $request->idMarca;
        $Producto->idCategoria = $request->idCategoria;
        $Producto->prdPresentacion = $request->prdPresentacion;
        $Producto->prdStock = $request->prdStock;
        $Producto->prdImagen = $prdImagen;
        
        $Producto->save();
        #retonar peticion + mensaje de ok
        return redirect('/adminProductos')
                    ->with(['mensaje'=>'Producto: '.$prdNombre.' agregado correctamente.']);
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
         //obtenemos datos de un producto por su id (select id from tabla where id is X)
         $Producto = Producto::with('relMarca', 'relCategoria')->find($id);
         $marcas = Marca::all();
         $categorias = Categoria::all();
         //retornamos vista del formulario con datos de la marca, [var + asociativo]
         return view('modificarProducto',
                    [   'Producto'=>$Producto,
                        'marcas'=>$marcas,
                        'categorias'=>$categorias
                    ]
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
        
        //validamos
        $this->validar($request);
        //subir imagen
        $prdImagen = $this->subirImagen($request);
        $prdNombre = $request->prdNombre;
        //obtener datos, asignar atributos, guardar
        $Producto = Producto::find($request->idProducto);
        $Producto->prdNombre = $prdNombre;
        $Producto->prdPrecio = $request->prdPrecio;
        $Producto->idMarca = $request->idMarca;
        $Producto->idCategoria = $request->idCategoria;
        $Producto->prdPresentacion = $request->prdPresentacion;
        $Producto->prdStock = $request->prdStock;
        $Producto->prdImagen = $prdImagen;
        //guardamos
        $Producto->save();
        //retornar peticion + mensaje ok
        return redirect('/adminProductos')
            ->with(['mensaje'=>'Producto: '.$prdNombre.' modificado correctamente']);

    }

    public function confirmar($id) 
    {
        # obtner los datos de un producto
        $Producto = Producto::with('relMarca', 'relCategoria')->find($id);
        # retornar la vista
        return view('eliminarProducto', [ 'Producto'=>$Producto]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        /*
        $Producto = Producto::find($request->idProducto);
        $Producto->delete();
        */

        Producto::destroy($request->idProducto);

        return redirect('/adminProductos')
            ->with(['mensaje'=>'Producto: '.$request->prdNombre.' eliminado correctamente']);

    }


    public function mostrar()
    {
         //obtenemos el listado de productos
        $productos = Producto::with('relMarca', 'relCategoria')
                                ->paginate(8);

         //retornamos vista del formulario con datos de la marca, [var + asociativo]
         return view('inicio',
                    [   
                        'productos'=>$productos
                    ]
                 );
    }

}
