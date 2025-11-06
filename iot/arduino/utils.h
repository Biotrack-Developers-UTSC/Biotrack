#ifndef UTILS_H
#define UTILS_H

#include <WiFiClientSecure.h>

String boundary = "----ESP32CAM";

void sendImage(camera_fb_t* fb) {
  WiFiClientSecure client;
  client.setInsecure(); // Ignorar SSL (útil con Cloudflare Tunnel)

  if (!client.connect(serverHost, serverPort)) {
    Serial.println("❌ No se pudo conectar al servidor");
    return;
  }

  Serial.println("📤 Enviando imagen y datos...");

  // Datos de formulario
  String bodyStart = "--" + boundary + "\r\n";
  bodyStart += "Content-Disposition: form-data; name=\"titulo\"\r\n\r\nPrueba humana\r\n";
  bodyStart += "--" + boundary + "\r\n";
  bodyStart += "Content-Disposition: form-data; name=\"mensaje\"\r\n\r\nMovimiento detectado por cámara\r\n";
  bodyStart += "--" + boundary + "\r\n";
  bodyStart += "Content-Disposition: form-data; name=\"severidad\"\r\n\r\nMedia\r\n";
  bodyStart += "--" + boundary + "\r\n";
  bodyStart += "Content-Disposition: form-data; name=\"tipo\"\r\n\r\nhostil\r\n";
  bodyStart += "--" + boundary + "\r\n";
  bodyStart += "Content-Disposition: form-data; name=\"sensor_id\"\r\n\r\nESP32CAM_01\r\n";
  bodyStart += "--" + boundary + "\r\n";
  bodyStart += "Content-Disposition: form-data; name=\"ubicacion\"\r\n\r\nZona 1\r\n";
  bodyStart += "--" + boundary + "\r\n";
  bodyStart += "Content-Disposition: form-data; name=\"imagen\"; filename=\"captura.jpg\"\r\n";
  bodyStart += "Content-Type: image/jpeg\r\n\r\n";

  String bodyEnd = "\r\n--" + boundary + "--\r\n";

  String req = String("POST ") + serverPath + " HTTP/1.1\r\n";
  req += "Host: " + String(serverHost) + "\r\n";
  req += "Content-Type: multipart/form-data; boundary=" + boundary + "\r\n";
  req += "Content-Length: " + String(bodyStart.length() + fb->len + bodyEnd.length()) + "\r\n";
  req += "Connection: close\r\n\r\n";

  client.print(req);
  client.print(bodyStart);
  client.write(fb->buf, fb->len);
  client.print(bodyEnd);

  Serial.println("📨 Enviado, esperando respuesta...");

  // Leer respuesta del servidor
  long timeout = millis() + 10000;
  while (client.connected() && millis() < timeout) {
    while (client.available()) {
      String line = client.readStringUntil('\n');
      Serial.println(line);
    }
  }
  client.stop();
  Serial.println("✅ Imagen enviada correctamente");
}

#endif
