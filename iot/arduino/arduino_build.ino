// ==========================================================
// Arduino UNO - CSV por línea para ESP32-CAM
// Formato de salida (por línea):
// PIR,DistanciaCM,Buzzer
//
// Ejemplo: 1,238,0
// ==========================================================

// ------------ PINES ------------
#define PIR_PIN 7
#define TRIG_PIN 8
#define ECHO_PIN 9
#define BUZZER_PIN 6

// ------------ VARIABLES ------------
long duracion;
long distancia;
unsigned long lastBuzzToggle = 0;
bool buzzerState = false;

void setup() {
  Serial.begin(9600);

  pinMode(PIR_PIN, INPUT);
  pinMode(TRIG_PIN, OUTPUT);
  pinMode(ECHO_PIN, INPUT);
  pinMode(BUZZER_PIN, OUTPUT);

  digitalWrite(BUZZER_PIN, LOW);
}

long medirDistanciaCM() {
  digitalWrite(TRIG_PIN, LOW);
  delayMicroseconds(3);
  digitalWrite(TRIG_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIG_PIN, LOW);

  duracion = pulseIn(ECHO_PIN, HIGH, 30000); // timeout 30 ms (máx 5m)
  distancia = duracion * 0.034 / 2;

  return distancia;
}

void loop() {

  // --------- LEER PIR ---------
  int pir = digitalRead(PIR_PIN);

  // --------- LEER DISTANCIA CM ---------
  long distancia = medirDistanciaCM();

  // --------- MANEJAR BUZZER INTERMITENTE ---------
  int buzzer = 0;

  if (pir == 1 && distancia <= 450) {
    buzzer = 1;

    // alternar cada 200 ms sin bloquear el loop
    if (millis() - lastBuzzToggle >= 200) {
      buzzerState = !buzzerState;
      digitalWrite(BUZZER_PIN, buzzerState);
      lastBuzzToggle = millis();
    }

  } else {
    buzzer = 0;
    digitalWrite(BUZZER_PIN, LOW);
    buzzerState = false;
  }

  // --------- ENVIAR DATOS AL ESP32-CAM ---------
  // Formato: PIR,DistanciaCM,Buzzer
  Serial.print(pir);
  Serial.print(",");
  Serial.print(distancia);
  Serial.print(",");
  Serial.println(buzzer);

  delay(500);
}
