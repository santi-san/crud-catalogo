@extends('layouts.plantilla')

    @section('contenido')

        <h1>Catalogo de productos</h1>
        <div class="row row-cols-1 row-cols-md-3 row-cols-md-5 g-4">
        @foreach ($productos as $producto)
          <div class="col">
            <div class="card h-100">
              <img src="/productos/{{$producto->prdImagen}}" class="card-img-top img-thumbnail" alt="...">
              <div class="card-body">
                <h5 class="card-title">{{ $producto->prdNombre  }}</h5>
                  <p class="card-text">
                    Marca: {{ $producto->relMarca->mkNombre }} <br>
                    Categoria: {{ $producto->relCategoria->catNombre }} <br>
                    Precio: ${{ $producto->prdPrecio  }} <br>
                    Presentacion: {{ $producto->prdPresentacion  }}</p>
                     
              </div>
            </div>
          </div>
        @endforeach
        </div>
        
    @endsection

    