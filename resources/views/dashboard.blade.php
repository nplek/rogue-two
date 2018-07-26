@extends('adminlte::page')

@section('content_header')
    <h1>{{ trans('adminlte::adminlte.dashboard') }}</h1>
@stop

@section('content')
<div class="container" id="app">
    <div class="row justify-content-center">
        <router-view name="dashboardsIndex"></router-view>
        <router-view></router-view>
    </div>
</div>
@endsection

@section('css')

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="dp-date" content="{{ config('app.date_format_moment') }}">
<meta name="dp-time" content="{{ config('app.time_format_moment') }}">
<meta name="dp-datetime" content="{{ config('app.datetime_format_moment') }}">
<meta name="app-locale" content="{{ App::getLocale() }}">

@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop

