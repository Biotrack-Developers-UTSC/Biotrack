#include "WiFi.h"
#include "esp_camera.h"
#include "Arduino.h"
#include <WiFiClientSecure.h>
#include "wifi_config.h"
#include "camera_config.h"
#include "utils.h"

#define PIR_PIN 13  // sensor PIR conectado al pin GPIO13

void setup() {
  Serial.begin(115200);
  pinMode(PIR_PIN, INPUT);

  connectToWiFi();
  initCamera();
}

void loop() {
  if (digitalRead(PIR_PIN) == HIGH) {
    Serial.println("🔵 Movimiento detectado");

    camera_fb_t *fb = esp_camera_fb_get();
    if (!fb) {
      Serial.println("⚠️ Error al tomar foto");
      return;
    }

    sendImage(fb);     // función definida en utils.h
    esp_camera_fb_return(fb);

    delay(10000); // Espera 10s antes de volver a detectar
  }
}
