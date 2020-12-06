@section('title')
    <title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section('head')

@endsection
@section('styles')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection
@extends('frontend.layouts.app')
@section('content')
