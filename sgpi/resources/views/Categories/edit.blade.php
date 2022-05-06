@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
EDITAR UNA CATEGORIA
@endsection

@section('content')
<form class="form" action="/categories/{{$category->id}}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="container">
        <div class="card-body">
        
            <div class="form-group">
                <label>Nombre de la categoria:</label>
                <input id="name" name="name" type="text" class="form-control form-control-solid" placeholder="Ingresa el Nombre de Proveedor" value="{{old('name',$category->name)}}"/>
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