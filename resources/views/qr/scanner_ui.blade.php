@extends('layouts.app')
@section('title', 'Escaner QR')

{{-- Asegúrate de incluir la librería en tu layout.app o aquí --}}
@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    #qr-reader {
      width: 100%;
      max-width: 500px;
      margin: 20px auto;
      border: 2px dashed #0891b2;
      padding: 5px;
      border-radius: 10px;
    }
  </style>
@endsection

@section('content')
  <div class="max-w-xl mx-auto py-8">
    <div class="bg-white p-6 rounded-xl shadow-2xl border-t-4 border-cyan-500 text-center">
      <h1 class="text-3xl font-extrabold text-gray-800 mb-4">Escanear Código BioTrack</h1>
      <p class="text-gray-500 mb-6">Apunte la cámara a un código QR de Especie o Usuario.</p>

      {{-- Contenedor donde la librería JS mostrará la cámara --}}
      <div id="qr-reader"></div>

      <div id="qr-reader-results" class="mt-4 text-sm font-medium text-left px-4"></div>

      <a href="{{ route('welcome') }}"
        class="mt-6 inline-block px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">
        ← Volver al Centro de Control
      </a>
    </div>
  </div>

@endsection

@section('scripts')
  {{-- Librería de Escaneo QR --}}
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script>
    function onScanSuccess(decodedText, decodedResult) {
      document.getElementById('qr-reader-results').innerHTML = `
                  <div class="text-green-600 font-bold">✅ Código detectado:</div>
                  <div class="text-sm text-gray-700">${decodedText}</div>
              `;

      // 🌟 REDIRECCIÓN CRÍTICA 🌟
      // Envía el código leído (ej: ANIMAL-45) al ScanController para su procesamiento
      window.location.href = "{{ url('/scan') }}/" + decodedText;
    }

    function onScanFailure(error) {
      // console.warn(`QR error = ${error}`);
    }

    document.addEventListener('DOMContentLoaded', function () {
      // 1. Verificar si el elemento existe antes de iniciar el escáner
      const qrReaderElement = document.getElementById("qr-reader");
      if (!qrReaderElement) return;

      let html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader",
        { fps: 10, qrbox: { width: 250, height: 250 } },
                  /* verbose= */ false);

      // 2. Iniciar el escáner
      html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });
  </script>
@endsection