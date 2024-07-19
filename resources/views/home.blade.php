@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
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