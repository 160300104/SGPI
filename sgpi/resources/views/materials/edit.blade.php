@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
EDITAR MATERIAL
@endsection

@section('content')
<form class="form" action="/materials/{{$materials->id}}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="container">
        <div class="card-body">
        
            <div class="form-group">
                <label>Nombre del Material:</label>
                <input id="name" name="name" type="text" class="form-control form-control-solid" placeholder="Ingresa el Nombre de Proveedor" value="{{old('name',$materials->name)}}"/>
                @error('name')
                        <small>*{{$message}}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Imagen:</label>
                <td>
                    <img src="/img/materials/{{$materials->image}}" width="10%">
                </td>         
                <input id="image" name="image" type="file" class="form-control form-control-solid" value="{{$materials->image}}"/>
                @error('image')
                        <small>*{{$message}}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Cantidad</label>
                <input id="quantity" name="quantity" type="number" min="1" class="form-control form-control-solid" value="{{old('quantity',$materials->quantity)}}"/>
                @error('quantity')
                    <small>*{{$message}}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Fecha de ingreso:</label>
                <input type="date" id="register_date" name="register_date" value="{{old('register_date',$materials->register_date)}}" min="2022-01-01" max="2022-12-31">
            </div>


            <div class="form-group">
                <label>Laboratorio:</label>
                <select class="form-select" name="id_lab"  id="id_lab" aria-label="Default select example">
                    <option selected>{{$materials->lab->id}}</option>
                        @foreach ($labs as $lab)
                            <option value="{{old('id_lab',$lab->id)}}">{{$lab->name}}</option>
                        @endforeach
                </select>
                @error('id_lab')
                    <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Categoria de material:</label>
                <select class="form-select" name="id_category"  id="id_category" aria-label="Default select example">
                    <option selected>{{$materials->category->id}}</option>
                        @foreach ($categories as $category)
                                <option value="{{old('id_category',$category->id)}}">{{$category->name}}</option>
                        @endforeach
                </select>
                @error('id_category')
                    <small>*{{$message}}</small>
                @enderror
            </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            <a href="{{route('materials.index')}}" type="reset" class="btn btn-secondary" >Cancelar</a>

        </div>
    </div>
   </form>
@endsection