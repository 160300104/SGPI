@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
MATERIALES
@endsection

@section('content')
<div class="seccion_proveedor">
  <a href="{{route('materials.create')}}" class="btn btn-primary proveedor">
    <i class="fa fa-plus"></i>Agregar un Material
  </a>
</div>
<br>

<table class="table table-hover table-striped table-bordered rounded">
    <thead class="tabla">
      <tr>
        <th style="width: 10%" scope="col" class="col-1">Imagen</th>
        <th style="width: 10%" scope="col">Nombre</th>
        <th style="width: 5%" scope="col">Cantidad</th>
        <th style="width: 10%" scope="col">Fecha de registro</th>
        <th style="width: 10%" scope="col">Laborario</th>
        <th style="width: 10%" scope="col">Categoria</th>
        <th style="width: 5%" scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($materials as $material)
          <tr>
              <td>
                  <img src="/img/materials/{{$material->image}}" width="100%">
              </td>
              <td>{{$material->name}}</td>
              <td>{{$material->quantity}}</td>
              <td>{{$material->register_date}}</td>
              <td>{{$material->lab->name}}</td>
              <td>{{$material->category->name}}</td>
              <td>
                  <a href="{{route('materials.edit',$material->id)}}" class="btn btn-info block">Editar</a>
                  <form action="{{route('materials.destroy', $material->id)}}" method="POST" class="formEliminar">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger block">Eliminar</button>
                  </form>
              </td>
          </tr>
      @endforeach
    </tbody>
  </table>

<!-- Paginación de Bootstrap -->
<div class="d-flex justify-content-end">
    {!! $materials->links() !!}
</div>

@endsection
