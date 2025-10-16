@extends('layouts.app_shell')
@section('title','Dashboard')
@section('content')
  <h1 class="text-xl font-bold mb-4">Dashboard</h1>
  <div class="grid md:grid-cols-3 gap-4">
    <div class="p-4 bg-white/5 rounded">Animales: {{ $animals_count }}</div>
    <div class="p-4 bg-white/5 rounded">Alertas: {{ $alerts_count }}</div>
    <div class="p-4 bg-white/5 rounded"><a href="{{ route('iot.guide') }}">Guía IoT</a></div>
  </div>
  <h2 class="mt-6 mb-2 font-semibold">Últimas alertas</h2>
  <table class="w-full text-sm">
    <thead><tr><th>Fecha</th><th>Edificio</th><th>Zona</th><th>Riesgo</th><th>Imagen</th></tr></thead>
    <tbody>
    @foreach($latest_alerts as $a)
      <tr class="border-t border-white/10">
        <td>{{ $a->created_at }}</td>
        <td>{{ $a->building }}</td>
        <td>{{ $a->zone }}</td>
        <td>{{ strtoupper($a->risk_level) }}</td>
        <td>@if($a->image_path)<img src="{{ asset('storage/'.$a->image_path) }}" class="h-10">@endif</td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endsection
