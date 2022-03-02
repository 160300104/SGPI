@extends('dash.index');

@section('title')
AGREGAR UN NUEVO PROVEEDOR
@endsection

@section('content')
<form class="form" action="{{ route('provider.store')}}" method="POST" autocomplete="off">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label>Nombre de Proveedor:</label>
            <input id="name" name="name" type="text" class="form-control form-control-solid" placeholder="Ingresa el Nombre de Proveedor"/>
        </div>
        
        <div class="form-group">
            <label>Logo:</label>
            <input id="image" name="image" type="file" class="form-control form-control-solid"/>
        </div>
        
        <div class="form-group">
        <label>Email:</label>
        <input id="email" name="email" type="email" class="form-control form-control-solid" placeholder="Ingresa el email"/>
        </div>

        <div class="form-group">
            <label>Numero Telefonico:</label>
            <input id="phone_number" name="phone_number" type="text" class="form-control form-control-solid" placeholder="Ingresa el numero telefonico"/>
        </div>

        <div class="form-group">
            <label>Ubicacion:</label>
            <input id="location" name="location" type="text" class="form-control form-control-solid" placeholder="Ingresa la ubicacion"/>
        </div>

        <div class="card-footer">
        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
        <a href="{{route('provider.index')}}" class="btn btn-secondary" >Cancelar</a>

    </div>
   </form>
@endsection