@extends('layouts.app')

@section('title', 'Welcome - ' . config('app.name'))

@push('body-start')
    @if($currentTheme === 'forgecraft')
        <div id="spark-container"></div>
    @else
        <div id="snow-container"></div>
    @endif
@endpush

@section('content')
    <div id="app" data-authenticated="{{ auth()->check() ? 'true' : 'false' }}"></div>
@endsection