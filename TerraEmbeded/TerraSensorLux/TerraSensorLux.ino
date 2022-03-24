#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Arduino_JSON.h>
#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include <ESP8266WiFiMulti.h>
#include <DHT.h>

#define DHTPIN 5 //chon pin 
#define DHTTYPE DHT11 //dht11

DHT dht(DHTPIN, DHTTYPE);

ESP8266WiFiMulti WiFiMulti;

#include <WiFiManager.h>         // https://github.com/tzapu/WiFiManager

const char* host = "xemsao.com"; //host thi bo http

// Update interval time set to 5 seconds
const long interval = 5000;
unsigned long previousMillis = 0;

String outputsState;
float lux;

void sendRequestLux(float lux);
float getLux();

void setup() {
  Serial.begin(115200);
  WiFiManager wifiManager;
  wifiManager.autoConnect("Terra");
  Serial.println("Connected.");
}

void loop() {
  unsigned long currentMillis = millis();

  lux = getLux();
  sendRequestLux(lux);
}

float getLux() {
  //Code here...
  float lux = random(20, 35);
  Serial.println(lux);
  return lux;
}

void sendRequestLux(float lux) {
  //1. TCP connection
  WiFiClient client;
  HTTPClient http;
  const int httpPort = 80; //80 is http
  //Check connection
  Serial.print("Connecting to: ");
  Serial.println(host);
  if (!client.connect(host, httpPort)) {
    Serial.println("Connection fail!");
    return;
  }

  //    Serial.println("Connection success!");
  //Send request to the sever
  client.print(String("GET https://xemsao.com/sensorLux.php?")
               + ("&lux=") + lux
               + " HTTP/1.1\r\n"
               + "Host: " + host + "\r\n"
               + "Connection: close\r\n\r\n");
  unsigned long current_time = millis();
  while (client.available() == 0) {
    if (millis() - current_time > 6000) {
      //          Serial.print(">>> Client stop");
      client.stop();
      return;
    }
  }
}