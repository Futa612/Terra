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
  dht.begin();
  Serial.begin(9600);
  pinMode(13,OUTPUT);// chan 13 noi voi quat
  pinMode(12,OUTPUT) ;// chan 12 noi voi may phun suong
  pinMode(11,OUTPUT); // chan 11 noi voi den
  
}

void loop()
{
hienthi() ;
gui();

if(Serial.available())
  {
    String tinhieu= "";
    while(Serial.available())
    {
      tinhieu= Serial.readString();
    }

if (tinhieu=="tdon") 
{    
 tudong();
} 
else if(tinhieu=="tdoff")
{
  nhan();
}
}
}

void hienthi(void)
{
    float h = dht.readHumidity();
    float t = dht.readTemperature();
   float l = lightMeter.readLightLevel();
  if (isnan(t) || isnan(h) ) { } 
  else {
    lcd.setCursor(3,0);
    lcd.print(round(t));

    lcd.print(" C");
    lcd.setCursor(12,0);
    lcd.print(round(h));
    lcd.print("%"); 
    lcd.setCursor(4,1); 
    lcd.print(round(t));
    lcd.print(" lux");
}
}
void tudong(void)
 {
 float h = dht.readHumidity();
 float t = dht.readTemperature();
 float l = lightMeter.readLightLevel();
 if (t>=30 && h>=70)
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
    Serial.print(h);
    Serial.print("lux");

}
void nhan(void)
{
  if(Serial.available())
  {
    String dulieu= "";
    while(Serial.available())
    {
      dulieu= Serial.readString();
    }

if (dulieu=="batquat") 
{    
  digitalWrite(13,HIGH); 
} 
else 
if (dulieu=="batden")
 {    
   digitalWrite(11,HIGH);
} 
else 
if (dulieu=="batps") 
{    
   digitalWrite(12,HIGH);
} 
else 
if (dulieu=="tatquat") 
{    
   digitalWrite(13,LOW);
} 
else 
if (dulieu=="tatden") 
{    
   digitalWrite(11,LOW);
}
 else 
if (dulieu=="tatps") 
{    
   digitalWrite(12,LOW);
} 
    
  }
 }
