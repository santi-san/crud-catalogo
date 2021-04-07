@extends('layouts.plantilla')

    @section('contenido')

        <h1>Modificacion de una Categoria</h1>

        <div class="alert bg-light border border-white shadow round col-8 mx-auto p-4">

            <form action="/modificarCategoria" method="post">
                @method('put')
                @csrf
                <div class="form-group">
                    <label for="catNombre">Nombre de la categoria</label>
                    <input type="text" name="catNombre"
                        {{-- Para mostrar el nombre del input a modificar | old('name input', var pasada->asociativo)  --}}
                        value="{{ old('catNombre', $Categoria->catNombre) }}"
                        class="form-control" id="catNombre">
                </div>
                <input type="hidden" name="idCategoria"
                       value="{{ $Categoria->idCategoria }}">
                <button class="btn btn-dark mr-3">Modificar categoria</button>
                <a href="/adminCategorias" class="btn btn-outline-secondary">
                    Volver a panel
                </a>
            </form>
        </div>
        @if ( $errors->any() )
            <div class="alert alert-danger col-8 mx-auto">
                <ul>
                    @foreach ( $errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

{{--    @error('name input')
            <span class="text-danger">{{ $message }}</span>
        @enderror
 --}}

    @endsection

