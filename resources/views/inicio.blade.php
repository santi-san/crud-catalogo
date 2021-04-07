@extends('layouts.plantilla')

    @section('contenido')

        <h1>Contenido de la página</h1>
        <div class="row row-cols-1 row-cols-md-3 row-cols-md-5 g-4">
        @foreach ($productos as $producto)
          <div class="col">
            <div class="card h-100">
              <img src="/productos/{{$producto->prdImagen}}" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">{{ $producto->prdNombre  }}</h5>
                      <p class="card-text">{{ $producto->relMarca->mkNombre  }} - {{ $producto->relCategoria->catNombre  }} - ${{ $producto->prdPrecio  }} - {{ $producto->prdPresentacion  }}</p>
              </div>
            </div>
          </div>
        @endforeach
        </div>
        
    @endsection

    