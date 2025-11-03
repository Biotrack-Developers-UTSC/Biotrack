const int trigPin = 9;
const int echoPin = 8;
const int pirPin = 7;
const int ledPin = 13;
const int buzzerPin = 12;
const int buttonPin = 2;

const int DIST_THRESHOLD = 50;
const unsigned long measureInterval = 120;
unsigned long lastMeasureTime = 0;

unsigned long lastAlertMillis = 0;
const unsigned long ALERT_COOLDOWN_MS = 30000UL;

unsigned long previousFastBlinkMillis = 0;
const long fastBlinkInterval = 150;
bool fastLedState = false;

unsigned long previousSlowBlinkMillis = 0;
const long slowBlinkInterval = 800;
bool slowLedState = false;

int lastButtonReading = HIGH;
int buttonState = HIGH;
unsigned long lastDebounceTime = 0;
const unsigned long debounceDelay = 50;

bool alarmActive = false;
bool muted = false;
unsigned long muteStart = 0;
const unsigned long MUTE_DURATION_MS = 60000UL;

int patternStep = 0;
bool patternOn = false;
unsigned long lastPatternMillis = 0;
const unsigned long beepOnMs = 150;
const unsigned long beepOffMs = 150;
const unsigned long pauseMs = 800;
const int alarmFreq = 1200;

void setup() {
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  pinMode(pirPin, INPUT);
  pinMode(ledPin, OUTPUT);
  pinMode(buzzerPin, OUTPUT);
  pinMode(buttonPin, INPUT_PULLUP);

  digitalWrite(ledPin, LOW);
  digitalWrite(buzzerPin, LOW);

  Serial.begin(9600);
  Serial.println("Sistema listo. Pulsa el boton (pin 2) para silenciar la alarma por un tiempo.");
}

long readDistanceCM() {
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);

  long duration = pulseIn(echoPin, HIGH, 30000);
  if (duration == 0) return -1;
  return duration / 58;
}

void handleButton() {
  int reading = digitalRead(buttonPin);
  if (reading != lastButtonReading) {
    lastDebounceTime = millis();
  }

  if ((millis() - lastDebounceTime) > debounceDelay) {
    if (reading != buttonState) {
      buttonState = reading;
      if (buttonState == LOW && alarmActive && !muted) {
        muted = true;
        muteStart = millis();
        noTone(buzzerPin);
        digitalWrite(ledPin, LOW);
        patternStep = 0;
        patternOn = false;
        lastPatternMillis = millis();
        Serial.println("Alarma silenciada temporalmente por boton.");
      }
    }
  }
  lastButtonReading = reading;
}

void updateAlarmPattern(bool enable) {
  if (!enable) {
    noTone(buzzerPin);
    patternStep = 0;
    patternOn = false;
    lastPatternMillis = millis();
    return;
  }

  unsigned long now = millis();

  if (patternStep == 0 && !patternOn) {
    patternOn = true;
    lastPatternMillis = now;
    tone(buzzerPin, alarmFreq);
    return;
  }

  if (patternStep >= 0 && patternStep <= 2) {
    if (patternOn) {
      if (now - lastPatternMillis >= beepOnMs) {
        lastPatternMillis = now;
        patternOn = false;
        noTone(buzzerPin);
      }
    } else {
      if (now - lastPatternMillis >= beepOffMs) {
        lastPatternMillis = now;
        patternStep++;
        patternOn = true;
        if (patternStep <= 2) {
          tone(buzzerPin, alarmFreq);
        } else {
          noTone(buzzerPin);
        }
      }
    }
  } else {
    if (now - lastPatternMillis >= pauseMs) {
      lastPatternMillis = now;
      patternStep = 0;
      patternOn = true;
      tone(buzzerPin, alarmFreq);
    }
  }
}

void loop() {
  handleButton();

  unsigned long now = millis();
  long distance = -1;
  if (now - lastMeasureTime >= measureInterval) {
    lastMeasureTime = now;
    distance = readDistanceCM();
    if (distance > 0) {
      Serial.print("Distancia HC-SR04: ");
      Serial.print(distance);
      Serial.println(" cm");
    } else {
      Serial.println("HC-SR04: Sin lectura (fuera de rango)");
    }
  }

  bool pirDetected = digitalRead(pirPin) == HIGH;
  if (pirDetected) Serial.println("PIR: Movimiento detectado");

  if (muted && (millis() - muteStart >= MUTE_DURATION_MS)) {
    muted = false;
    Serial.println("Periodo de silencio terminado. La alarma puede sonar de nuevo.");
    patternStep = 0;
    patternOn = false;
    lastPatternMillis = millis();
  }

  bool detected = (distance > 0 && distance <= DIST_THRESHOLD) || pirDetected;
  alarmActive = detected && !muted;

  if (alarmActive && (millis() - lastAlertMillis >= ALERT_COOLDOWN_MS)) {
    lastAlertMillis = millis();
    Serial.println("ALERTA:ANIMAL");
  }

  if (alarmActive) {
    if (now - previousFastBlinkMillis >= fastBlinkInterval) {
      previousFastBlinkMillis = now;
      fastLedState = !fastLedState;
      digitalWrite(ledPin, fastLedState ? HIGH : LOW);
    }
    updateAlarmPattern(true);
  } else if (muted) {
    if (now - previousSlowBlinkMillis >= slowBlinkInterval) {
      previousSlowBlinkMillis = now;
      slowLedState = !slowLedState;
      digitalWrite(ledPin, slowLedState ? HIGH : LOW);
    }
    updateAlarmPattern(false);
  } else {
    digitalWrite(ledPin, LOW);
    updateAlarmPattern(false);
  }

  delay(150);
}
