@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
CATEGORIAS DE MATERIALES
@endsection

@section('content')

<div class="seccion_proveedor">
  <a href="{{route('categories.create')}}" class="btn btn-primary proveedor">
    <i class="fa fa-plus"></i>Agregar una nueva Categoria
  </a>
</div>
<br>
    <table class="table table-hover table-striped table-bordered rounded">
        <thead class="tabla">
          <tr>
            <th style="width: 1%" scope="col">ID</th>
            <th style="width: 10%" scope="col">Nombre de Categoria del material</th>
            <th style="width: 1%" scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $category)
              <tr>
                  <td>{{$category->id}}</td>
                  <td>{{$category->name}}</td>
                  <td>
                        <a href="{{route('categories.edit',$category->id)}}" class="btn btn-info block">Editar</a>
                        @can('categories.destroy')
                        <form action="{{route('categories.destroy', $category->id)}}" method="POST" class="formEliminar">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger block">Eliminar</button>
                        </form>
                        @endcan
                  </td>
              </tr>
          @endforeach
        </tbody>
      </table>

@endsection