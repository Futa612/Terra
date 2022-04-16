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
float gAdc;
float gSoil;
double* gSetpoint;
double* gInput;
double* gOutput;
double gKp = 5, gKi = 1.5, gKd = 0.35;

//Constructor
PID myPID(gInput, gOutput, gSetpoint, gKp, gKi, gKd, DIRECT);

void sendRequestSoil(float soil);
void myPid(float soil);
float getSoil();

void setup()
{
  //Setup PID, ANALOG
  pinMode(A0, INPUT );
  pinMode(D1, OUTPUT );
  Serial.begin(115200);
  gAdc = analogRead(A0);
  *gInput = map(gAdc, 0, 1023, 100, 0);
  *gSetpoint = 75;
  myPID.SetMode(AUTOMATIC);

  //Setup WifiCliet
  Wire.begin();
  Serial.begin(115200);
  WiFiManager wifiManager;
  wifiManager.autoConnect("Terra");
  Serial.println("Connected.");
}

void loop()
{
  unsigned long currentMillis = millis();
  gSoil = getSoil();
  myPid(gSoil);
  sendRequestSoil(gSoil);
}

float getSoil() {
  gAdc = analogRead(A0);
  gSoil = map(gAdc, 0, 1023, 100, 0);
  Serial.print("Soil: ");
  Serial.println(gSoil);
  return gSoil;
}

void myPid(float soil)
{
  *gInput = soil;
  myPID.Compute();
  analogWrite(D1, *gOutput);
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
  client.print(String("GET https://xemsao.com/sensorLux.php?")
               + ("&lux=") + soil
               + " HTTP/1.1\r\n"
               + "Host: " + host + "\r\n"
               + "Connection: close\r\n\r\n");

  unsigned long current_time = millis();

  while (client.available() == 0) {
    if (millis() - current_time > 6000) {
      Serial.print(">>> Client stop");
      client.stop();
      return;
    }
  }
}
