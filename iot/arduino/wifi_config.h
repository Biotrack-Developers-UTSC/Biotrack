#ifndef WIFI_CONFIG_H
#define WIFI_CONFIG_H

const char* ssid = "TU_SSID";
const char* password = "TU_PASSWORD";
const char* serverHost = "tu-tunel.cloudflare-gateway.com"; // sin https://
const int serverPort = 443;
String serverPath = "/api/arduino/alerta";

void connectToWiFi() {
  WiFi.begin(ssid, password);
  Serial.print("Conectando a WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\n✅ WiFi conectado: " + WiFi.localIP().toString());
}

#endif
