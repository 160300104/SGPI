@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
ELIJA EL O LOS MATERIALES A PRESTAR
@endsection

@section('content')
<form class="form" action="{{ route('loans.saveticket')}}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="container">
        
        <button type="button" class="btn btn-primary mr-2" id="nuevo_material">Agregar un material</button>
        <div class="card-body" id="material">
            <div class="material">
                <div class="form-group" id="mat">
                    <label>Material:</label>
                    <select class="form-select" name="id_material"  id="id_material" aria-label="Default select example">
                        <option selected hidden></option>
                            @foreach ($materials as $material)
                                <option value="{{$material->id}}">{{$material->name}}</option>
                            @endforeach
                    </select>
                    <br>
                    <label>Cantidad</label>
                    <input id="quantity" name="quantity" type="number" class="form-control form-control-solid" value="{{old('quantity')}}"/>
                    <br>
                    <p align="right">
                        <button type="button" class="btn btn btn-danger mr-2" id="" onclick="eliminarMaterial(this)" >Borrar Material</button>
                    </p>
                </div>
            </div>           
            <input hidden id="id_loan" name="id_loan" type="number" class="form-control form-control-solid" value="{{$loancurrent->id}}"/>
            
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2">Realizar Prestamo</button>
            {{-- <a href="{{route('loans.index')}}" class="btn btn-secondary" >Cancelar</a> --}}

        </div>
   </form>
@endsection

@section('script')
<script>
var nextinput = 0;
    $("#nuevo_material").click(function(e) {
        nextinput++;
        var material = '<div class="form-group" id="mat'+nextinput+'"><label>Material '+nextinput+':</label><select class="form-select" name="id_material'+nextinput+'"  id="id_material'+nextinput+'" aria-label="Default select example"><option selected hidden></option>@foreach ($materials as $material)<option value="{{$material->id}}">{{$material->name}}</option>@endforeach</select><br><label>Cantidad</label><input id="quantity'+nextinput+'" name="quantity'+nextinput+'" type="number" class="form-control form-control-solid" value="{{old('quantity')}}"/><br><p align="right"><button type="button" class="btn btn btn-danger mr-2" id="'+nextinput+'" onclick="eliminarMaterial(this)">Borrar Material</button></p></div>'
        $("#material").append(material);
    });

    function eliminarMaterial(mat) {
        var id = mat.id;
        var d = document.getElementById('mat'+id+'');
        d.remove();
    }
</script>
@endsection