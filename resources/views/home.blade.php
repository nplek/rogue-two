@extends('adminlte::page')

@section('content_header')
    <h1>{{ trans('adminlte::adminlte.home') }}</h1>
@stop

@section('content')
<div class="container" id="app">
    <div class="row justify-content-center">
        
    </div>
</div>
@endsection

@section('css')

@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop