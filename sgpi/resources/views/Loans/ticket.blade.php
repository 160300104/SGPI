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
                <div class="form-group">
                    <label>Material:</label>
                    <select class="form-select" name="id_material1"  id="id_material1" aria-label="Default select example">
                        <option selected hidden></option>
                            @foreach ($materials as $material)
                                <option value="{{$material->id}}">{{$material->name}}</option>
                            @endforeach
                    </select>
                    <br>
                    <label>Cantidad</label>
                    <input id="quantity1" name="quantity1" type="number" class="form-control form-control-solid" value="{{old('quantity')}}"/>
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
var nextinput = 1;
    $("#nuevo_material").click(function(e) {
        nextinput++;
        var campo = '<li id="rut'+nextinput+'">Campo: <input type="text" size="20" id="campo' + nextinput + '" name="campo' + nextinput + '"&nbsp; /></li>';
        var material = '<div class="form-group"><label>Material '+nextinput+':</label><select class="form-select" name="id_material'+nextinput+'"  id="id_material'+nextinput+'" aria-label="Default select example"><option selected hidden></option>@foreach ($materials as $material)<option value="{{$material->id}}">{{$material->name}}</option>@endforeach</select><br><label>Cantidad</label><input id="quantity'+nextinput+'" name="quantity'+nextinput+'" type="number" class="form-control form-control-solid" value="{{old('quantity')}}"/></div>'
        $("#material").append(material);
    });
</script>
@endsection