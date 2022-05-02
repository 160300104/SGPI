@extends('dash.index');

@section('styles')
  <link href="{{asset('css/categories/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
AGREGAR UNA NUEVA CATEGORIA DE MATERIAL
@endsection

@section('content')
<form class="form" action="{{ route('categories.store')}}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="card-body">
            <div class="form-group">
                <label>Nombre de la catergoria:</label>
                <input id="name" name="name" type="text" class="form-control form-control-solid" placeholder="Ingresa el Nombre de la nueva categoria" value=""/>
                @error('name')
                        <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            <a href="{{route('categories.index')}}" type="reset" class="btn btn-secondary" >Cancelar</a>

        </div>
    </div>
   </form>
@endsection