#include <DHT.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
#include <BH1750.h> 

LiquidCrystal_I2C lcd(0x27,16,2);

const int DHTPIN = 2;
const int DHTTYPE = DHT11;
DHT dht(DHTPIN, DHTTYPE);

byte degree[8] = {
  0B01110,
  0B01010,
  0B01110,
  0B00000,
  0B00000,
  0B00000,
  0B00000,
  0B00000
};

void setup() {
  lcd.init();  
  lcd.backlight();
  lcd.setCursor(0,0);
  lcd.print("ND:");
  lcd.setCursor(9,0);
  lcd.print("DA:");
  lcd.setCursor(0,1);
  lcd.print("AS:");
  lcd.createChar(1, degree);
  dht.begin();
  pinMode(13,OUTPUT);// chan 13 noi voi quat
  pinMode(12,OUTPUT) ;// chan 12 noi voi may phun suong
}

void loop() {
  float h = dht.readHumidity();
  float t = dht.readTemperature();

  if (isnan(t) || isnan(h)) { } 
  else {
    lcd.setCursor(3,0);
    lcd.print(round(t));
    lcd.write(1);
    lcd.print("C");
    lcd.setCursor(12,0);
    lcd.print(round(h));
    lcd.print("%"); 
    lcd.setCursor(4,1); 
    lcd.print(round(t));
    lcd.print(" lux");
      
  }
  if(t>=30 or h>=50)
  {
    digitalWrite(13,HIGH);
    }
    else{
      digitalWrite(13,LOW);
    }
    if(h<=40)
  {
    digitalWrite(12,HIGH);
    }
    else{
      digitalWrite(12,LOW);
    }
}
