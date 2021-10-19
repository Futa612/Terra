//Tham khao tu Rui

#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Arduino_JSON.h>
#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include <ESP8266WiFiMulti.h>
ESP8266WiFiMulti WiFiMulti;

#include <WiFiManager.h>         // https://github.com/tzapu/WiFiManager

//const char* host = "ezroom.000webhostapp.com"; //host thi bo http
const char* host = "terraiot.000webhostapp.com"; //host thi bo http

// Your IP address or domain name with URL path
const char* serverName = "http://terraiot.000webhostapp.com/esp-outputs-action.php?action=outputs_state&board=2";

// Update interval time set to 1.5 seconds
const long interval = 1500;
unsigned long previousMillis = 0;

String outputsState;
int temp, humid, lux;

void gui_request(int temp, int humid, int lux);
int nhietdo();
int doam();
int anhsang();

void setup() {
  Serial.begin(115200);
  WiFiManager wifiManager;
  wifiManager.autoConnect("Terra");
  Serial.println("Connected.");
}

void loop() {
  unsigned long currentMillis = millis();
  
  if(currentMillis - previousMillis >= interval) {
     // Check WiFi connection status
    if ((WiFiMulti.run() == WL_CONNECTED)) {
      outputsState = httpGETRequest(serverName);
//      Serial.println(outputsState);
      JSONVar myObject = JSON.parse(outputsState);
  
      // JSON.typeof(jsonVar) can be used to get the type of the var
      if (JSON.typeof(myObject) == "undefined") {
        Serial.println("Parsing input failed!");
        return;
      }
    
//      Serial.print("JSON object = ");
//      Serial.println(myObject);
    
      // myObject.keys() can be used to get an array of all the keys in the object
      JSONVar keys = myObject.keys();
    
      for (int i = 0; i < keys.length(); i++) {
        JSONVar value = myObject[keys[i]];
//        Serial.print("GPIO: ");
//        Serial.print(keys[i]);
//        Serial.print(" - SET to: ");
//        Serial.println(value);
        pinMode(atoi(keys[i]), OUTPUT);
        digitalWrite(atoi(keys[i]), atoi(value));
      }
      // save the last HTTP GET Request
      previousMillis = currentMillis;
    }
    else {
      Serial.println("WiFi Disconnected");
    }
  }

  temp = nhietdo();
  humid = doam();
  lux = anhsang();
  gui_request(temp, humid, lux);
//  Serial.println(temp);
//  Serial.println(humid);
//  Serial.println(lux);
}

String httpGETRequest(const char* serverName) {
  WiFiClient client;
  HTTPClient http;
    
  // Your IP address with path or Domain name with URL path 
  http.begin(client, serverName);
  
  // Send HTTP POST request
  int httpResponseCode = http.GET();
  
  String payload = "{}"; 
  
  if (httpResponseCode>0) {
//    Serial.print("HTTP Response code: ");
//    Serial.println(httpResponseCode);
    payload = http.getString();
  }
  else {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }
  // Free resources
  http.end();

  return payload;
}

int nhietdo() {
    int temp = random(20, 35);
    return temp;
  }
int doam() {
    int humid = random(70, 90); 
    return humid;
  }
int anhsang() {
    int lux = random(1, 100);
    return lux;
  }



void gui_request(int temp, int humid, int lux) {
  //  Serial.println("//////////////////////BEGIN//////////////////////");
  //1. Tao ket noi TCP su dung thu vien WiFiClient 
  WiFiClient client;
  HTTPClient http;
  const int httpPort = 80; //thuong la 80 voi http
  //kiem tra ket noi
//  Serial.print("Connecting to: ");
//  Serial.println(host); 
  if (!client.connect(host, httpPort)) {
    Serial.println("Connection fail!");
      return;
    }
  
//    Serial.println("Connection success!");
  //=============1. Gui request len PHP// Gui data len server=============
  client.print(String("GET https://terraiot.000webhostapp.com/sensor.php?") 
                  +("&temp=") + temp
                  +("&humid=") + humid
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
