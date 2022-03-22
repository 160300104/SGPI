@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
USUARIOS
@endsection

@section('content')

<table class="table table-hover table-striped table-bordered rounded">
    <thead class="tabla">
      <tr>
        <th style="width: 5%" scope="col">ID</th>
        <th style="width: 30%" scope="col">Nombre</th>
        <th style="width: 30%" scope="col">Email</th>
        <th style="width: 5%" scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
          <tr>
              <td>{{$user->id}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>
                    <a href="{{route('user.edit',$user->id)}}" class="btn btn-info block">Editar</a>
              </td>
          </tr>
      @endforeach
    </tbody>
  </table>
@endsection
