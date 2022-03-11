#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Arduino_JSON.h>
#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include <ESP8266WiFiMulti.h>

ESP8266WiFiMulti WiFiMulti;

#include <WiFiManager.h>         // https://github.com/tzapu/WiFiManager

const char* host = "xemsao.com"; //ignore https

// Your IP address or domain name with URL path
const char* serverName = "http://xemsao.com/esp-outputs-action.php?action=outputs_state&board=1";

// Update interval time set to 1 seconds
const long interval = 1000;
unsigned long previousMillis = 0;

String outputsState;

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

      if (JSON.stringify(myObject) == "{}") {   //sua loi Exception: 29
        Serial.println("Exception: 29");
        return;
      }
    
      Serial.print("JSON object = ");
      Serial.println(myObject);

      // myObject.keys() can be used to get an array of all the keys in the object
      JSONVar keys = myObject.keys();
      for (int i = 0; i < keys.length(); i++) 
      {
      JSONVar value = myObject[keys[i]];
      Serial.print("GPIO: ");
      Serial.print(keys[i]);
      Serial.print(" - SET to: ");
      Serial.println(value);
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
