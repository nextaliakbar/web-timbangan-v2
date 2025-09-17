@extends('layouts.app')

@section('title', 'Formula')

@section('content')
    @livewire('admin.formula-livewire', ['plant' => request()->route()->parameter('plant')])
@endsection