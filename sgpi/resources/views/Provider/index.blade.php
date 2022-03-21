@extends('dash.index');

@section('title')
PROVEEDORES
@endsection

@section('content')
<div class="seccion_proveedor">
  <a href="{{route('provider.create')}}" class="btn btn-primary proveedor">
    <i class="fa fa-plus"></i>Agregar un Proveedor
  </a>
</div>
<br>

<table class="table table-hover table-striped table-bordered rounded">
    <thead class="tabla">
      <tr>
        <th style="width: 20%" scope="col" class="col-1">Logo</th>
        <th style="width: 20%" scope="col">Nombre</th>
        <th style="width: 20%" scope="col">Email</th>
        <th style="width: 10%" scope="col">Telefono</th>
        <th style="width: 25%" scope="col">Ubicacion</th>
        <th style="width: 5%" scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($providers as $provider)
          <tr>
              <td>
                  <img src="/img/provider/{{$provider->image}}" width="100%">
              </td>
              <td>{{$provider->name}}</td>
              <td>{{$provider->email}}</td>
              <td>{{$provider->phone_number}}</td>
              <td>{{$provider->location}}</td>
              <td>
                  <a href="{{route('provider.edit',$provider->id)}}" class="btn btn-info block">Editar</a>
                  <form action="{{route('provider.destroy', $provider->id)}}" method="POST" class="formEliminar">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger block">Eliminar</button>
                  </form>
              </td>
          </tr>
      @endforeach
    </tbody>
  </table>
@endsection

<style type="text/css">
  .tabla {
    color: #c0c4d1;
    background-color: #242939;
    font-weight: 900;
  }

  .block {
  padding: 1rem 0rem !important;
  display: block;
  width: 100%;
  border: none;
  background-color: #04AA6D;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  text-align: center;
  margin-bottom: 1rem;
  }

  .block:last-child{
    margin-bottom: 0rem;
  }

  .proveedor{
    border-radius: 15px !important;
    padding: 2rem !important;
  }

  .seccion_proveedor{
    display: flex;
    justify-content: flex-end;
  }

  .seccion_proveedor i{
    margin-right: 1rem;
  }
  </style>