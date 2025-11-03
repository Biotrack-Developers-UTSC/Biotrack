@extends('layouts.dashboard')

@section('title', 'Panel de Administración')

@section('content')
    <div class="main-content">
        <h1 class="text-3xl font-bold mb-6">Panel de Administración</h1>
        @include('partials.dashboard_stats', ['stats' => $stats ?? []])
    </div>
@endsection