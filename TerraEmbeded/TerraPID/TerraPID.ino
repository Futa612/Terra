#include <PID_v1.h>
float adc;
double Setpoint, Input, Output;
double Kp = 5, Ki = 1.5, Kd = 0.35;
PID myPID(&Input, &Output, &Setpoint, Kp, Ki, Kd, DIRECT);
void setup()
{
  pinMode(A0, INPUT );
  pinMode(D1, OUTPUT );
  Serial.begin(115200);
  adc = analogRead(A0);
  Input = map(adc, 0, 1023, 100, 0);
  Setpoint = 75;
  myPID.SetMode(AUTOMATIC);
}
void loop()
{
  doam();
  adc = analogRead(A0);
  Input = map(adc, 0, 1023, 100, 0);
  myPID.Compute();
  analogWrite(D1, Output);
}
void doam (void) {
  Serial.println(Input);
  delay(1000);
}
