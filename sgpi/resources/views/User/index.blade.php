@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
USUARIOS
@endsection

@section('content')

@livewire('user.user-index')

@endsection

@livewireScripts
