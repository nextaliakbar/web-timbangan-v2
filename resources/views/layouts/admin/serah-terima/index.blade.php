@extends('layouts.app')

@section('title', 'Serah Terima')

@section('content')
    @livewire('admin.serah-terima-livewire', ['plant' => request()->route()->parameter('plant')])
@endsection