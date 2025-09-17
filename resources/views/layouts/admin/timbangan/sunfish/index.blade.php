@extends('layouts.app')

@section('title', 'Edit No. Sunfish')

@section('content')
    @livewire('admin.sunfish-livewire', [
        'plant' => request()->route()->parameter('plant'),
        'noSunfsih' => request()->route()->parameter('noSunfish')
        ])
@endsection