@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
EDITAR UN LABORATORIO
@endsection

@section('content')
<form class="form" action="/labs/{{$lab->id}}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="container">
        <div class="card-body">
        
            <div class="form-group">
                <label>Nombre del Laborario:</label>
                <input id="name" name="name" type="text" class="form-control form-control-solid" placeholder="Ingresa el Nombre de Proveedor" value="{{old('name',$lab->name)}}"/>
                @error('name')
                        <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Encargados:</label>
                <select class="form-select" name="id_user"  id="id_user" aria-label="Default select example">
                    <option selected hidden>{{$lab->user->name}}</option>
                        @foreach ($users as $user)
                            <option value="{{old('id_user',$user->id)}}">{{$user->name}}</option>
                        @endforeach
                </select>
                @error('id_user')
                    <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            <a href="{{route('labs.index')}}" type="reset" class="btn btn-secondary" >Cancelar</a>

        </div>
    </div>
   </form>
@endsection