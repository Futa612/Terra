#include <PID_v1.h>
#include <Wire.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Arduino_JSON.h>
#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include <ESP8266WiFiMulti.h>
#include <WiFiManager.h>
ESP8266WiFiMulti WiFiMulti;
const char* host = "xemsao.com";
float adc;
float soil;
double Setpoint, Input, Output;
double Kp = 5, Ki = 1.5, Kd = 0.35;
PID myPID(&Input, &Output, &Setpoint, Kp, Ki, Kd, DIRECT);
void setup()
{
  pinMode(A0, INPUT );
  pinMode(D1, OUTPUT );
  Serial.begin(115200);
  adc = analogRead(A0);
  Input = map(adc, 0, 1023, 100, 0);
  Setpoint = 75;
  myPID.SetMode(AUTOMATIC);

  //Setup wifi
  Wire.begin();
  WiFiManager wifiManager;
  wifiManager.autoConnect("Terra");
  Serial.println("Connected.");
}

float getSoil() {
  adc = analogRead(A0);
  float soil = map(adc, 0, 1023, 100, 0);
  Serial.print("Soil: ");
  Serial.println(soil);
  return soil;
}
void myPid(void)
{
  adc = analogRead(A0);
  Input = map(adc, 0, 1023, 100, 0);
  myPID.Compute();
  analogWrite(D1, Output);
}
void sendRequestSoil(float soil) {
  //1. TCP connection
  WiFiClient client;
  HTTPClient http;
  const int httpPort = 80;

  //Check connection
  Serial.print("Connecting to: ");
  Serial.println(host);
  if (!client.connect(host, httpPort)) {
    Serial.println("Connection fail!");
    return;
  }

  //Send request to the sever
  client.print(String("GET https://xemsao.com/sensorSoil.php?")
               + ("&soil=") + soil
               + " HTTP/1.1\r\n"
               + "Host: " + host + "\r\n"
               + "Connection: close\r\n\r\n");
  Serial.println("Send: ");
  Serial.println(soil);
  unsigned long current_time = millis();

  while (client.available() == 0) {
    if (millis() - current_time > 6000) {
      Serial.print(">>> Client stop");
      client.stop();
      return;
    }
  }
}
void loop()
{
  myPid();
  unsigned long currentMillis = millis();
  soil = getSoil();
  sendRequestSoil(soil);
}
