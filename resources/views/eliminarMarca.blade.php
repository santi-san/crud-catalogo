@extends('layouts.plantilla')

    @section('contenido')

        <h1>Baja de una marca</h1>

        <div class="row alert bg-light border-danger col-8 mx-auto p-2">
            <div class="col text-danger align-self-center">
            @if ($productos > 0)
                    No se puede eliminar la marca: {{ $Marca->mkNombre }}.
                    Ya que tiene productos utilizandola.
                    <a href="/adminMarcas"> Volver a panel</a>
            @else
                <form action="/eliminarMarca" method="post">
                    @csrf
                    @method('delete')
                    <h2>{{ $Marca->mkNombre }}</h2>
                    <input type="hidden" name="idMarca"
                        value="{{ $Marca->idMarca}}">
                    <input type="hidden" name="mkNombre"
                    value="{{ $Marca->mkNombre}}">
                    <button class="btn btn-danger btn-block my-3">Confirmar baja</button>
                    <a href="/adminMarcas" class="btn btn-outline-secondary btn-block">
                        Volver a panel
                    </a>

                </form>
            @endif
            </div>
            
            <script>
               /*
                Swal.fire(
                    'Advertencia',
                    'Si pulsa el boton "Confirmar baja", se eliminara el producto seleccionado',
                    'warning'
                )
               */
            </script>


    @endsection
