#include "esp_camera.h"
#include <WiFi.h>
#include <HTTPClient.h>
#include <base64.h>
#include "time.h"

// ---------------- BACKEND ----------------
String endpoint = "http://192.168.1.224:8000/arduino";

// ---------------- WIFI ----------------
const char* ssid = "TP-Link_788E";
const char* password = "19631975199519992001";

unsigned long lastWifiCheck = 0;
const unsigned long wifiRetryInterval = 5000;

// ---------------- UART (Arduino UNO → ESP32) ----------------
HardwareSerial SerialSensor(0);   // UART0 (RX usable en GPIO3)

// ---------------- LED FLASH ----------------
#define LED_FLASH 4

// ---------------- VARIABLES ----------------
int lastPir = 0;
long lastDist = 9999;
int lastBuzzer = 0;

// ---------------- NTP ----------------
const char* ntpServer = "pool.ntp.org";
const long gmtOffset_sec = -21600;
const int daylightOffset_sec = 0;

String getTimestamp() {
  struct tm timeinfo;
  if (!getLocalTime(&timeinfo)) return "1970-01-01T00:00:00";
  char buf[25];
  strftime(buf, sizeof(buf), "%Y-%m-%dT%H:%M:%S", &timeinfo);
  return String(buf);
}

// ---------------- CONFIG CAMERA ----------------
bool configCamera() {
  camera_config_t config;

  config.ledc_channel = LEDC_CHANNEL_0;
  config.ledc_timer = LEDC_TIMER_0;

  config.pin_d0 = 5;
  config.pin_d1 = 18;
  config.pin_d2 = 19;
  config.pin_d3 = 21;
  config.pin_d4 = 36;
  config.pin_d5 = 39;
  config.pin_d6 = 34;
  config.pin_d7 = 35;

  config.pin_xclk = 0;
  config.pin_pclk = 22;
  config.pin_vsync = 25;
  config.pin_href = 23;
  config.pin_sscb_sda = 26;
  config.pin_sscb_scl = 27;

  config.pin_pwdn = 32;
  config.pin_reset = -1;

  config.xclk_freq_hz = 20000000;
  config.pixel_format = PIXFORMAT_JPEG;

  config.frame_size = FRAMESIZE_SVGA;
  config.jpeg_quality = 12;
  config.fb_count = 1;

  return (esp_camera_init(&config) == ESP_OK);
}

// ---------------- FOTO BASE64 ----------------
String takePhotoBase64() {
  digitalWrite(LED_FLASH, HIGH);
  delay(200);

  camera_fb_t* fb = esp_camera_fb_get();
  digitalWrite(LED_FLASH, LOW);

  if (!fb) return "";

  String imageB64 = base64::encode(fb->buf, fb->len);
  esp_camera_fb_return(fb);
  return imageB64;
}

// ---------------- ENVÍO JSON ----------------
void sendJson(String imgBase64, String timestamp) {
  if (WiFi.status() != WL_CONNECTED) return;

  String severidad = (lastDist <= 400 && lastPir == 1) ? "alta" : "media";

  HTTPClient http;
  http.begin(endpoint);
  http.addHeader("Content-Type", "application/json");

  String json = "{";
  json += "\"titulo\":\"Alerta de intrusión\",";
  json += "\"mensaje\":\"Movimiento detectado a menos de 4.5 metros\",";
  json += "\"timestamp\":\"" + timestamp + "\",";
  json += "\"timezone\":\"America/Monterrey\",";
  json += "\"severidad\":\"" + severidad + "\",";
  json += "\"tipo\":\"hostil\",";
  json += "\"distancia\":" + String(lastDist) + ",";
  json += "\"foto\":\"" + imgBase64 + "\"";
  json += "}";

  int code = http.POST(json);
  Serial.printf("[POST] Código HTTP: %d\n", code);
  http.end();
}

// ---------------- WiFi Helper ----------------
void ensureWiFi() {
  if (WiFi.status() == WL_CONNECTED) return;

  WiFi.disconnect(true);
  WiFi.begin(ssid, password);

  unsigned long start = millis();
  while (WiFi.status() != WL_CONNECTED && millis() - start < 5000) {
    delay(300);
  }
}

// ---------------- SETUP ----------------
void setup() {
  Serial.begin(115200);
  pinMode(LED_FLASH, OUTPUT);
  digitalWrite(LED_FLASH, LOW);

  // --- PULSO DOBLE PARA INDICAR CONFIGURACIÓN CARGADA ---
  for (int i = 0; i < 2; i++) {
    digitalWrite(LED_FLASH, HIGH);
    delay(150);
    digitalWrite(LED_FLASH, LOW);
    delay(150);
  }

  // UART: RX = GPIO3 , TX = GPIO1
  SerialSensor.begin(9600, SERIAL_8N1, 3, 1);

  if (!configCamera()) {
    Serial.println("Error: cámara no inicializada.");
  }

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) delay(300);

  configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
}

// ---------------- LOOP ----------------
void loop() {
  unsigned long now = millis();

  if (now - lastWifiCheck > wifiRetryInterval) {
    ensureWiFi();
    lastWifiCheck = now;
  }

  if (SerialSensor.available()) {
    String line = SerialSensor.readStringUntil('\n');
    line.trim();

    int p1 = line.indexOf(',');
    int p2 = line.indexOf(',', p1 + 1);

    if (p1 > 0 && p2 > 1) {
      lastPir = line.substring(0, p1).toInt();
      lastDist = line.substring(p1 + 1, p2).toInt();
      lastBuzzer = line.substring(p2 + 1).toInt();

      Serial.printf("CSV: PIR=%d Dist=%ld BZ=%d\n", lastPir, lastDist, lastBuzzer);

      if (lastPir == 1 && lastDist <= 450) {
        String timeNow = getTimestamp();
        String img = takePhotoBase64();
        if (img.length() > 0) sendJson(img, timeNow);
      }
    }
  }

  delay(10);
}
