import base64
import re
import time
import threading
from io import BytesIO
from PIL import Image
import requests
import serial
import serial.tools.list_ports

# 🔧 CONFIG
BAUDRATE = 9600
LARAVEL_URL = "https://tunel-laravel.cloudflare-gateway.com/api/arduino/alerta"
ESP32_CAM_URL = "http://192.168.4.10/capture"  # Cambia a la IP real de tu cámara
UBICACION = "Zona de pruebas"

def choose_serial_port():
    ports = list(serial.tools.list_ports.comports())
    if not ports:
        raise RuntimeError("No hay puertos serial disponibles.")
    print("Puertos:")
    for i, p in enumerate(ports):
        print(f" [{i}] {p.device} - {p.description}")
    idx = 0
    if len(ports) > 1:
        idx = int(input("Puerto (Enter=0): ") or 0)
    return ports[idx].device

def capturar_foto():
    try:
        print("📸 Solicitando imagen a ESP32-CAM...")
        r = requests.get(ESP32_CAM_URL, timeout=6)
        if r.status_code == 200 and r.content.startswith(b'\xff\xd8'):
            img_b64 = base64.b64encode(r.content).decode('utf-8')
            print("✅ Imagen recibida.")
            return img_b64
        else:
            print("⚠️ No se recibió imagen válida.")
    except Exception as e:
        print("❌ Error al capturar imagen:", e)
    return None

def enviar_alerta(titulo, mensaje, severidad="Alta", tipo="hostil", incluir_foto=False):
    data = {
        "titulo": titulo,
        "mensaje": mensaje,
        "severidad": severidad,
        "sensor_id": "ARDUINO-UNO",
        "ubicacion": UBICACION,
        "tipo": tipo
    }

    if incluir_foto:
        imagen_base64 = capturar_foto()
        if imagen_base64:
            data["imagen_base64"] = imagen_base64

    try:
        r = requests.post(LARAVEL_URL, json=data, timeout=10)
        if r.ok:
            print("✅ Alerta enviada y guardada:", r.json().get("alerta", {}))
        else:
            print("⚠️ Error al enviar:", r.status_code, r.text)
    except Exception as e:
        print("❌ No se pudo conectar:", e)

def escuchar_serial(port):
    print(f"Escuchando puerto {port} a {BAUDRATE} baudios...")
    with serial.Serial(port, BAUDRATE, timeout=1) as ser:
        time.sleep(2)
        while True:
            line = ser.readline().decode(errors="ignore").strip()
            if not line:
                continue
            print(">>", line)

            if "ALERTA:ANIMAL" in line:
                print("🚨 Detección animal/hostil")
                enviar_alerta(
                    titulo="Detección animal o presencia hostil",
                    mensaje=f"El sensor detectó movimiento o distancia crítica.",
                    severidad="Alta",
                    tipo="hostil",
                    incluir_foto=True
                )

            elif "PIR: Movimiento detectado" in line:
                print("👤 Movimiento humano detectado")
                enviar_alerta(
                    titulo="Movimiento humano detectado",
                    mensaje="El sensor PIR detectó actividad humana.",
                    severidad="Media",
                    tipo="no hostil",
                    incluir_foto=False
                )

if __name__ == "__main__":
    port = choose_serial_port()
    escuchar_serial(port)