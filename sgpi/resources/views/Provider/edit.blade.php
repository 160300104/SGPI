@extends('dash.index');

@section('title')
EDITAR UN PROVEEDOR
@endsection

@section('content')
<form class="form" action="/provider/{{$provider->id}}" method="POST">
    @csrf
    @method('PUT')
    <div class="card-body">
        
        <div class="form-group">
            <label>Nombre de Proveedor:</label>
            <input id="name" name="name" type="text" class="form-control form-control-solid" placeholder="Ingresa el Nombre de Proveedor" value="{{$provider->name}}"/>
        </div>
        
        <div class="form-group">
            <label>Logo:</label>
            <input id="image" name="image" type="file" class="form-control form-control-solid" value="{{$provider->image}}"/>
        </div>
        
        <div class="form-group">
        <label>Email:</label>
        <input id="email" name="email" type="email" class="form-control form-control-solid" placeholder="Ingresa el email" value="{{$provider->email}}"/>
        </div>

        <div class="form-group">
            <label>Numero Telefonico:</label>
            <input id="phone_number" name="phone_number" type="text" class="form-control form-control-solid" placeholder="Ingresa el numero telefonico" value="{{$provider->phone_number}}"/>
        </div>

        <div class="form-group">
            <label>Ubicacion:</label>
            <input id="location" name="location" type="text" class="form-control form-control-solid" placeholder="Ingresa la ubicacion" value="{{$provider->location}}"/>
        </div>

        <div class="card-footer">
        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
        <a href="{{route('provider.index')}}" type="reset" class="btn btn-secondary" >Cancelar</a>

    </div>
   </form>
@endsection


