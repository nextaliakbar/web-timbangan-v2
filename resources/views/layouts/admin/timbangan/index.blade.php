@extends('layouts.app')

@section('title', 'Timbangan')

@section('content')
    @livewire('admin.timbangan-livewire', ['plant' => request()->route()->parameter('plant')])
@endsection