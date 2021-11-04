#include <DHT.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
#include <BH1750.h>
LiquidCrystal_I2C lcd(0x27,16,2);
BH1750 lightMeter;
const int DHTPIN = 2;
const int DHTTYPE = DHT11;
DHT dht(DHTPIN, DHTTYPE);
void setup() {
  lcd.init();  
  lcd.backlight();
  lcd.setCursor(0,0);
  lcd.print("ND:");
  lcd.setCursor(9,0);
  lcd.print("DA:");
  lcd.setCursor(0,1);
  lcd.print("AS:");
  lcd.setCursor(12,1);
  lcd.print("lux");
  dht.begin();
  lightMeter.begin();
  Serial.begin(9600);
  pinMode(13,OUTPUT);// chan 13 noi voi quat
  pinMode(12,OUTPUT) ;// chan 12 noi voi may phun suong
  pinMode(11,OUTPUT); // chan 11 noi voi den
  
}

void loop()
{
hienthi() ;
gui();
tudong();
}

void hienthi(void)
{
    float h = dht.readHumidity();
    float t = dht.readTemperature();
   float l = lightMeter.readLightLevel();
  if (isnan(t) || isnan(h)|| isnan(l) ) { } 
  else {
    lcd.setCursor(3,0);
    lcd.print(round(t));

    lcd.print(" C");
    lcd.setCursor(12,0);
    lcd.print(round(h));
    lcd.print("%"); 
    lcd.setCursor(4,1); 
    lcd.print(l);
}
}
void tudong(void)
 {
 float h = dht.readHumidity();
 float t = dht.readTemperature();
 float l = lightMeter.readLightLevel();
 if (t>=30 || h>=70)
 { digitalWrite(13, HIGH); }
 else 
 {digitalWrite(13,LOW);}
 if ( h<=40)
 { digitalWrite(12, HIGH); }
 else 
 {digitalWrite(12,LOW);}
 if (l<=350)
 { digitalWrite(11, HIGH); }
 else 
 {digitalWrite(11,LOW);}
 }  
void gui(void)
{
   float h = dht.readHumidity();
    float t = dht.readTemperature();
     float l = lightMeter.readLightLevel();
    Serial.print("nhiet do:");
    Serial.print(t);
    Serial.print(" do C");
    Serial.print(" do am:");
    Serial.print(h);
    Serial.print("%");
      Serial.print(" anh sang:");
    Serial.print(l);
    Serial.print("lux");

}
void nhan(void)
{
  if(Serial.available())
  {
    char dulieu;
    while(Serial.available())
    {
      dulieu= Serial.read();
    }

if (dulieu=='1') 
{    
  digitalWrite(13,HIGH); 
} 
else 
if (dulieu=='2')
 {    
   digitalWrite(11,HIGH);
} 
else 
if (dulieu=='3') 
{    
   digitalWrite(12,HIGH);
} 
else 
if (dulieu=='4') 
{    
   digitalWrite(13,LOW);
} 
else 
if (dulieu=='5') 
{    
   digitalWrite(11,LOW);
}
 else 
if (dulieu=='6') 
{    
   digitalWrite(12,LOW);
} 
    
  }
 }
