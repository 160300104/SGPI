@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
NUEVO PRESTAMO DE MATERIAL
@endsection

@section('content')
<form class="form" action="{{ route('loans.store')}}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="card-body">

            <div class="form-group">
                <input type="date" id="loan_date" name="loan_date" value="">
            </div>

            <div class="form-group">
                <label>Laboratorio:</label>
                <select class="form-select" name="id_lab"  id="id_lab" aria-label="Default select example">
                    <option selected>{{old('id_lab')}}</option>
                        @foreach ($labs as $lab)
                            <option value="{{$lab->id}}">{{$lab->name}}</option>
                        @endforeach
                </select>
                @error('id_lab')
                    <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <input hidden type="text" id="id_user" name="id_user" value="{{Auth::id();}}" >
            </div>

            <div class="form-group">
                <input hidden type="text" id="id_status" name="id_status" value="{{'1'}}" >
            </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2">Siguiente</button>
            <a href="{{route('loans.index')}}" class="btn btn-secondary" >Cancelar</a>

        </div>
    </div>
   </form>
@endsection