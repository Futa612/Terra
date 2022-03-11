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

//const char* host = "ezroom.000webhostapp.com"; //host thi bo http
const char* host = "xemsao.com"; //host thi bo http

// Update interval time set to 1 seconds
const long interval = 5000;
unsigned long previousMillis = 0;

String outputsState;
float lux;

void gui_request(float lux);
float anhsang();

void setup() {
  Serial.begin(115200);
  WiFiManager wifiManager;
  wifiManager.autoConnect("Terra");
  Serial.println("Connected.");
}

void loop() {
  unsigned long currentMillis = millis();
 
  lux = anhsang();
  gui_request(lux);
}

float anhsang() {
    float lux = random(20, 35); //thay ham do anhs sang vao day
    Serial.println(lux);
    return lux;
  }

void gui_request(float lux) {
  //  Serial.println("//////////////////////BEGIN//////////////////////");
  //1. Tao ket noi TCP su dung thu vien WiFiClient 
  WiFiClient client;
  HTTPClient http;
  const int httpPort = 80; //thuong la 80 voi http
  //kiem tra ket noi
  Serial.print("Connecting to: ");
  Serial.println(host); 
  if (!client.connect(host, httpPort)) {
    Serial.println("Connection fail!");
      return;
    }
  
//    Serial.println("Connection success!");
  //=============1. Gui request len PHP// Gui data len server=============
  client.print(String("GET https://xemsao.com/sensor.php?") 
                  +("&lux=") + lux
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
