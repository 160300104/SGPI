@extends('dash.index');

@section('styles')
  <link href="{{asset('css/materials/style.css')}}" rel="stylesheet" type="text/css"/>
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

            <div class="form-group">
                <label style="">Latitud:</label>
                <input id="latitude" name="latitude"  type="text" class="form-control form-control-solid" placeholder="Latitud" value="{{old('latitude', $provider->latitude)}}"/>
                @error('latitude')
                    <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label style="">Longitud:</label>
                <input id="length" name="length"  type="text" class="form-control form-control-solid" placeholder="Longitud" value="{{old('length', $provider->length)}}"/>
                @error('length')
                    <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="mapa" style="width: 50%; height: 500px;"></div>
                </div>
            </div>
            <br>

            <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            <a href="{{route('provider.index')}}" type="reset" class="btn btn-secondary" >Cancelar</a>

        </div>
    </div>
   </form>
@endsection

@section('script')
<script>
    function iniciarMapa(){
        var latitud = 21.169039292053693;
        var longitud = -86.84992262268078;

        coordenadas = {
            lng: longitud,
            lat: latitud
        }
 
        generarMapa(coordenadas);
    }

    function generarMapa(coordenadas){
        var mapa = new google.maps.Map(document.getElementById('mapa'),
        {
            zoom: 12,
            center: new google.maps.LatLng(coordenadas.lat, coordenadas.lng)
        });

        marcador= new google.maps.Marker({
            map:mapa,
            draggable: true,
            position: new google.maps.LatLng(coordenadas.lat, coordenadas.lng)
        });

        marcador.addListener('dragend', function(event){
            document.getElementById('latitude').value = this.getPosition().lat();
            document.getElementById('length').value = this.getPosition().lng();
        })
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeBjVUoOZFBL8HiLSJVIEZAghk5-Tn3g&callback=iniciarMapa"></script>
@endsection