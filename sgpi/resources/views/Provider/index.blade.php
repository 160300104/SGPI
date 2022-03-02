@extends('dash.index');

@section('title')
PROVEEDORES
@endsection

@section('content')
<div><a href="{{route('provider.create')}}" class="btn btn-primary">Agregar un Proveedor</a></div>

<br>

<table class="table table-hover table-striped table-bordered rounded">
    <thead class="thead-dark">
      <tr>
        <th scope="col" class="col-1">Logo</th>
        <th scope="col">Nombre</th>
        <th scope="col">Email</th>
        <th scope="col">Telefono</th>
        <th scope="col">Ubicacion</th>
        <th scope="col">Acciones</th>
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
                  <a href="{{route('provider.edit',$provider->id)}}" class="btn btn-info">Editar</a>
                  <form action="{{route('provider.destroy', $provider->id)}}" method="POST" class="formEliminar">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                  </form>
              </td>
          </tr>
      @endforeach
    </tbody>
  </table>
@endsection