@extends('adminlte::page')
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

@section('title', 'Dashboard')

@section('head')
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
@endsection

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <p>Uriel Pérez Sánchez.</p>
    <p>Fernando Hernandez Sánchez.</p>
    <p>Mayra Edith Maya Sánchez.</p>
    <p>Alan Naiyel Rodriguez Sánchez.</p>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
