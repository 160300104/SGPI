@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
LABORATORIOS
@endsection

@section('content')

<table class="table table-hover table-striped table-bordered rounded">
    <thead class="tabla">
      <tr>
        <th style="width: 5%" scope="col">ID</th>
        <th style="width: 30%" scope="col">Nombre del Laborario</th>
        <th style="width: 30%" scope="col">Encargado</th>
        <th style="width: 5%" scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($labs as $lab)
          <tr>
              <td>{{$lab->id}}</td>
              <td>{{$lab->name}}</td>
              <td>{{$lab->user->name}}</td>
              <td>
                    <a href="{{route('labs.edit',$lab->id)}}" class="btn btn-info block">Editar</a>
              </td>
          </tr>
      @endforeach
    </tbody>
  </table>
@endsection