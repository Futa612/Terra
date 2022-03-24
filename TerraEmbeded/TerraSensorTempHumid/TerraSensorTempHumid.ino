#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Arduino_JSON.h>
#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include <ESP8266WiFiMulti.h>
#include <DHT.h>

#define DHTPIN 5 //select pin 
#define DHTTYPE DHT11 //dht11

DHT dht(DHTPIN, DHTTYPE);

ESP8266WiFiMulti WiFiMulti;

#include <WiFiManager.h>         // https://github.com/tzapu/WiFiManager

const char* host = "xemsao.com";

// Update interval time set to 1 seconds
const long interval = 5000;
unsigned long previousMillis = 0;

String outputsState;
float temp, humid;

void gui_request(float temp, float humid);
float getTemp();
float getHumid();

void setup() {
  Serial.begin(115200);
  WiFiManager wifiManager;
  wifiManager.autoConnect("Terra");
  Serial.println("Connected.");
}

void loop() {
  unsigned long currentMillis = millis();

  temp = getTemp();
  humid = getHumid();
  gui_request(temp, humid);
}

float getTemp() {
  float temp = /*random(20, 35);*/ dht.readTemperature();
  Serial.println(temp);
  return temp;
}
float getHumid() {
  float humid = /*random(70, 90);*/ dht.readHumidity();
  if (humid > 100.0) humid = 100.0;
  Serial.println(humid);
  return humid;
}


void gui_request(float temp, float humid) {
  //  Serial.println("//////////////////////BEGIN//////////////////////");
  //1. Make TCP connection with WiFiClient
  WiFiClient client;
  HTTPClient http;
  const int httpPort = 80; //80 with http
  //kiem tra ket noi
  Serial.print("Connecting to: ");
  Serial.println(host);
  if (!client.connect(host, httpPort)) {
    Serial.println("Connection fail!");
    return;
  }

  //    Serial.println("Connection success!");
  //Send data to the sever
  client.print(String("GET https://xemsao.com/sensorTempHumid.php?")
               + ("&temp=") + temp
               + ("&humid=") + humid
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
