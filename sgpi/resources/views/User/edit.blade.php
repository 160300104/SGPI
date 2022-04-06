@extends('dash.index');

@section('styles')
  <link href="{{asset('css/user/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
ASIGNAR UN ROL
@endsection

@section('content')
    
    @if (session('info'))
        <div class="alert alert success">
            <strong>{{session('info')}}</strong>
        </div>
        
    @endif

<form class="form">
    <div class="card-body">
        <div class="form-group">
            <label>Full Name:</label>
            <a type="email" class="form-control form-control-solid"> {{$user->name}}</a>
        </div>
        <div class="form-group">
            <label>Email address:</label>
            <a type="email" class="form-control form-control-solid"> {{$user->email}}</a>
        </div>
        
        {!! Form::model($user, ['route' => ['user.update', $user], 'method' => 'put']) !!}
            @foreach ($roles as $role)
                <div>
                    <label>
                        {!! Form::checkbox('roles[]',$role->id, null, ['class' => 'mr-1'])!!}
                         {{$role->name}}
                    </label>
                </div>
            @endforeach

            {!! Form::submit('Asignar rol', ['class' => 'btn btn-primary mt-2']) !!}
        {!! Form::close() !!}
    </div>
   
   </form>
@endsection