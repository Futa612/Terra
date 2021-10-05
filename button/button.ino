//⠀⠀⠀⠀⣠⣶⡾⠏⠉⠙⠳⢦⡀⠀⠀⠀⢠⠞⠉⠙⠲⡀⠀
//⠀⠀⠀⣴⠿⠏⠀⠀⠀⠀ ⠀⢳⡀⠀ ⡏⠀⠀⠀⠀⠀ ⢷
//⠀⠀⢠⣟⣋⡀⢀⣀⣀⡀⠀⣀⡀⣧⠀⢸⠀MY⠀   ⡇            Dat Nguyen
//⠀⠀⢸⣯⡭⠁⠸⣛⣟⠆⡴⣻⡲⣿⠀⣸⠀⠀  ⠀ ⡇
//⠀⠀⣟⣿⡭⠀⠀⠀⠀⠀⢱⠀ ⣿⠀⢹⠀ ONLINE⡇            
//⠀⠀⠙⢿⣯⠄⠀⠀⠀⢀⡀⠀⠀⡿⠀⠀⡇⠀⠀⠀⠀ ⡼             https://github.com/Futa612
//⠀⠀⠀⠀⠹⣶⠆⠀⠀⠀⠀⠀⡴⠃⠀⠀⠘⠤⣄⣠⠞⠀
//⠀⠀⠀⠀⠀⢸⣷⡦⢤⡤⢤⣞⣁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀             
//⠀⠀⢀⣤⣴⣿⣏⠁⠀⠀⠸⣏⢯⣷⣖⣦⡀⠀⠀⠀⠀⠀⠀
//⢀⣾⣽⣿⣿⣿⣿⠛⢲⣶⣾⢉⡷⣿⣿⠵⣿⠀⠀⠀⠀⠀⠀           
//⣼⣿⠍⠉⣿⡭⠉⠙⢺⣇⣼⡏⠀⠀⠀⣄⢸⠀⠀⠀⠀⠀⠀
//⣿⣿⣧⣀⣿………⣀⣰⣏⣘⣆⣀⠀⠀⠀⠀
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

#include <ESP8266WebServer.h>
#include <WiFiManager.h>         // https://github.com/tzapu/WiFiManager
int pin1 = D1;
int pin2 = D2;
int pin3 = D3;
int pin4 = D4;

volatile boolean state1=false;
volatile boolean state2=false;
volatile boolean state3=false;
volatile boolean state4=false;

int led1, oldled1;
int led2, oldled2;
int led3, oldled3;
int led4, oldled4;

int button1 = D5;
int button2 = D6;
int button3 = D7;
int button4 = D8;

int dem1 = 2;
int dem2 = 2;
int dem3 = 2;
int dem4 = 2;
sdfdafdf
int sopin, trangthai,sopin_cu, trangthai_cu;
sdfsdfsdf
String old_payload;

// Set web server port number to 80
WiFiServer server(80);

//khai bao wifi, host, api key: kieu char*
const char* ssid = "Hello kitty 1";
const char* password = "19091977";
const char* host = "ezroom.000webhostapp.com"; //host thi bo http
const char* servername = "http://ezroom.000webhostapp.com/data.txt"; // cho them http
const char* api_key_gui_len = "dfgsfsjgh"; //random cai nay, muc dich la de phan biet gui va nhan, luc can luc khong

void dk2(){
  
  if (digitalRead(button4) == 1) { 
    
    if (digitalRead(button4) == 0) {
      dem4 = dem4 + 1;
      if (dem4 % 2 == 0) {
        digitalWrite(pin4,1); // Đèn led sáng 
        }
      if (dem4 % 2 == 1) {
        digitalWrite(pin4,0); // Đèn led sáng 
        }
//      Serial.println(dem);
      }
    }
  }
void setup() {
  pinMode(pin1, OUTPUT);
  pinMode(pin2, OUTPUT);
  pinMode(pin3, OUTPUT);
  pinMode(pin4, OUTPUT);
  
  pinMode(button1, INPUT);
  pinMode(button2, INPUT);
  pinMode(button3, INPUT);
  pinMode(button4, INPUT);
  
 

}
void loop() {
  dk2();
}
