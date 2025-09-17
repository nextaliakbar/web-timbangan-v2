@extends('layouts.app')

@section('title', 'Kartu Stok')

@section('content')
    @livewire('admin.kartu-stok-livewire', ['plant' => request()->route()->parameter('plant')])
@endsection