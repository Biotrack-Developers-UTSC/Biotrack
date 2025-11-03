import re, time, threading, smtplib, requests, serial, serial.tools.list_ports
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

try:
    from plyer import notification as PLYER_NOTIFICATION
except ImportError:
    PLYER_NOTIFICATION = None

try:
    import pyttsx3
    TTS_ENGINE = pyttsx3.init()
except ImportError:
    TTS_ENGINE = None

CONFIG_URL = "http://tu-dominio.test/api/arduino/config"
BAUDRATE = 9600
DIST_THRESHOLD_CM = 50
SERIAL_PORT = None
SMTP_CONFIG = {}

def fetch_config():
    global DIST_THRESHOLD_CM, SMTP_CONFIG
    try:
        resp = requests.get(CONFIG_URL, timeout=5)
        resp.raise_for_status()
        data = resp.json()
        DIST_THRESHOLD_CM = int(data.get('distance_threshold', DIST_THRESHOLD_CM))
        SMTP_CONFIG.update(data.get('smtp', {}))
        print("[CONFIG] Cargada desde Laravel.")
    except requests.exceptions.RequestException as e:
        print(f"[CONFIG] Error cargando config: {e}")

def choose_serial_port():
    ports = list(serial.tools.list_ports.comports())
    if not ports:
        raise RuntimeError("No se encontraron puertos serial.")
    for i, p in enumerate(ports):
        print(f"[{i}] {p.device} - {p.description}")
    idx = int(input("Selecciona índice del puerto (enter 0): ") or 0)
    return ports[idx].device

def show_notification(title, message):
    if PLYER_NOTIFICATION:
        try: PLYER_NOTIFICATION.notify(title=title, message=message, app_name="ArduinoAlert", timeout=5)
        except Exception as e: print(f"[NOTIF] {e}")
    else: print(f"[NOTIF] {title}: {message}")

def speak(text):
    if TTS_ENGINE:
        threading.Thread(target=lambda: TTS_ENGINE.say(text) or TTS_ENGINE.runAndWait(), daemon=True).start()
    else: print(f"[TTS] {text}")

def send_email(subject, body):
    try:
        msg = MIMEMultipart()
        msg['From'] = SMTP_CONFIG.get('user')
        msg['To'] = SMTP_CONFIG.get('test_email')
        msg['Subject'] = subject
        msg.attach(MIMEText(body, 'plain'))
        with smtplib.SMTP_SSL(SMTP_CONFIG['host'], SMTP_CONFIG['port']) as server:
            server.login(SMTP_CONFIG['user'], SMTP_CONFIG['pass'])
            server.send_message(msg)
        print(f"[SMTP] Correo enviado a {SMTP_CONFIG.get('test_email')}")
    except Exception as e:
        print(f"[SMTP] Error: {e}")

def alerta(distancia):
    if distancia <= DIST_THRESHOLD_CM:
        msg = f"Alerta: Objeto a {distancia} cm (umbral {DIST_THRESHOLD_CM} cm)"
        show_notification("Alerta Arduino", msg)
        speak(msg)
        send_email("Alerta Arduino", msg)

def listen_and_alert(port):
    print(f"Abriendo puerto {port} a {BAUDRATE} baudios...")
    with serial.Serial(port, BAUDRATE, timeout=1) as ser:
        time.sleep(2)
        while True:
            try:
                line = ser.readline().decode(errors='ignore').strip()
                if not line: continue
                print(">>", line)
                if "Movimiento detectado" in line:
                    alerta(0)
                    continue
                match = re.search(r"Distancia\s*HC-?SR04\s*:\s*(\d+)", line)
                if match: alerta(int(match.group(1)))
            except KeyboardInterrupt:
                print("Cerrando...")
                break
            except Exception as e:
                print("Error serial:", e)
                time.sleep(0.5)

if __name__ == "__main__":
    fetch_config()
    port = SERIAL_PORT or choose_serial_port()
    listen_and_alert(port)
