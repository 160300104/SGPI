@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
EDITAR UN PROVEEDOR
@endsection

@section('content')
<form class="form" action="/provider/{{$provider->id}}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="container">
        <div class="card-body">
        
            <div class="form-group">
                <label>Nombre de Proveedor:</label>
                <input id="name" name="name" type="text" class="form-control form-control-solid" placeholder="Ingresa el Nombre de Proveedor" value="{{old('name',$provider->name)}}"/>
                @error('name')
                        <small>*{{$message}}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Logo:</label>
                <td>
                    <img src="/img/provider/{{$provider->image}}" width="10%">
                </td>         
                <input id="image" name="image" type="file" class="form-control form-control-solid" value="{{$provider->image}}"/>
                @error('image')
                        <small>*{{$message}}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input id="email" name="email" type="email" class="form-control form-control-solid" placeholder="Ingresa el email" value="{{old('email',$provider->email)}}"/>
                @error('email')
                        <small>*{{$message}}</small>
                    @enderror
            </div>

            <div class="form-group">
                <label>Numero Telefonico:</label>
                <input id="phone_number" name="phone_number" type="text" class="form-control form-control-solid" placeholder="Ingresa el numero telefonico" value="{{old('phone_number',$provider->phone_number)}}"/>
                @error('phone_number')
                    <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Ubicacion:</label>
                <input id="location" name="location" type="text" class="form-control form-control-solid" placeholder="Ingresa la ubicacion" value="{{old('location',$provider->location)}}"/>
                @error('location')
                    <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            <a href="{{route('provider.index')}}" type="reset" class="btn btn-secondary" >Cancelar</a>

        </div>
    </div>
   </form>
@endsection