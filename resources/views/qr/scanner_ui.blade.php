@extends('layouts.app')
@section('title', 'Escáner QR')

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
      display: none;
      /* Oculto hasta que se active la cámara */
    }
  </style>
@endsection

@section('content')
  <div class="max-w-xl mx-auto py-8">
    <div class="bg-white p-6 rounded-xl shadow-2xl border-t-4 border-cyan-500 text-center">
      <h1 class="text-3xl font-extrabold text-gray-800 mb-4">Escanear Código BioTrack</h1>
      <p class="text-gray-500 mb-6">Presiona el botón para activar la cámara o usa un lector físico de QR.</p>

      {{-- Botón para activar cámara --}}
      <button id="start-scan"
        class="px-6 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-bold rounded-lg shadow-md transition">
        <i class="fas fa-camera mr-2"></i> Activar cámara y escanear
      </button>

      {{-- Área del lector QR --}}
      <div id="qr-reader"></div>

      {{-- Resultado del escaneo --}}
      <div id="qr-reader-results" class="mt-6 hidden">
        <div class="text-green-600 font-bold mb-2">✅ Código detectado:</div>
        <div id="qr-text" class="text-sm text-gray-700 mb-4"></div>
        <div class="flex justify-center gap-4">
          <button id="view-info"
            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg">
            Ver información
          </button>
          <button id="cancel-scan" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg">
            Cancelar
          </button>
        </div>
      </div>

      {{-- Entrada manual / lector físico --}}
      <div class="mt-6">
        <input id="manual-scan" type="text" placeholder="O escanea/escribe el código aquí (ej: ANIMAL-5)"
          class="border border-gray-300 p-2 w-full rounded-lg focus:ring-2 focus:ring-cyan-500 text-center">
      </div>

      <a href="{{ route('welcome') }}"
        class="mt-6 inline-block px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">
        ← Volver al Centro de Control
      </a>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script>
    let html5QrCode = null;
    let scanning = false;
    let lastCode = null;

    function playBeep() {
      const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
      const oscillator = audioCtx.createOscillator();
      const gainNode = audioCtx.createGain();
      oscillator.connect(gainNode);
      gainNode.connect(audioCtx.destination);
      oscillator.type = "sine";
      oscillator.frequency.value = 880;
      gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
      oscillator.start();
      oscillator.stop(audioCtx.currentTime + 0.2);
    }

    function showResult(decodedText) {
      document.getElementById('qr-reader-results').classList.remove('hidden');
      document.getElementById('qr-text').textContent = decodedText;
    }

    function hideResult() {
      document.getElementById('qr-reader-results').classList.add('hidden');
      document.getElementById('qr-text').textContent = '';
      lastCode = null;
    }

    function stopScanning() {
      if (html5QrCode) {
        html5QrCode.stop().then(() => {
          scanning = false;
          document.getElementById('qr-reader').style.display = 'none';
        }).catch(err => console.error("Error al detener escáner:", err));
      }
    }

    function startScanning() {
      const qrReaderElement = document.getElementById("qr-reader");
      qrReaderElement.style.display = "block";
      html5QrCode = new Html5Qrcode("qr-reader");
      scanning = true;

      html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        (decodedText, decodedResult) => {
          if (decodedText !== lastCode) {
            lastCode = decodedText;
            playBeep();
            showResult(decodedText);
            stopScanning();
          }
        },
        (errorMessage) => { /* ignorar errores leves */ }
      ).catch(err => {
        console.error("Error al iniciar cámara:", err);
        alert("No se pudo acceder a la cámara. Verifica permisos.");
        scanning = false;
      });
    }

    document.addEventListener('DOMContentLoaded', function () {
      const startBtn = document.getElementById("start-scan");
      const cancelBtn = document.getElementById("cancel-scan");
      const viewBtn = document.getElementById("view-info");
      const input = document.getElementById("manual-scan");

      startBtn.addEventListener("click", function () {
        if (scanning) {
          alert("El escáner ya está activo.");
          return;
        }
        hideResult();
        startScanning();
      });

      cancelBtn.addEventListener("click", function () {
        hideResult();
        startScanning();
      });

      viewBtn.addEventListener("click", function () {
        if (lastCode) {
          window.location.href = "{{ url('scan') }}/" + lastCode;
        }
      });

      // Soporte para escáner físico o ingreso manual
      input.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
          const code = input.value.trim();
          if (code !== '') {
            playBeep();
            showResult(code);
            lastCode = code;
          }
        }
      });
    });
  </script>
@endsection