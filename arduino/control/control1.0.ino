char buffer = 0;
void setup() 
{
    Serial.begin(9600);     // 打开串口，设置数据传输速率9600
    pinMode(8, OUTPUT);
    pinMode(9, OUTPUT);
    pinMode(10, OUTPUT);
    pinMode(11, OUTPUT);
    pinMode(12, OUTPUT);
    pinMode(13, OUTPUT);
}
void alarm(void)
{
  for(int i = 0; i < 100;i ++)
  {
      digitalWrite(13, HIGH);
      delay(1);
      digitalWrite(13, LOW);
      delay(1);
  }
}

void alarm_stop(void)
{
    digitalWrite(13, LOW);
}

void loop() {
    while(Serial.available() > 0) {
    buffer = Serial.read();
    Serial.print("I received: ");
    Serial.println(buffer);
  }
      switch (buffer)
    {
        case 'Y': alarm();
                  break;
        case 'A': alarm_stop();
                  digitalWrite(8, HIGH);
                  break;
        case 'B': alarm_stop();
                  digitalWrite(9, HIGH);
                  break;
        case 'C': alarm_stop();
                  digitalWrite(10,HIGH);
                  break;
        case 'D': alarm_stop();
                  digitalWrite(11, HIGH);
                  break;
        case 'E': alarm_stop();
                  digitalWrite(12, HIGH);
                  break;
        case 'F': for(int i = 8; i < 13; i++){
                     digitalWrite(i, LOW);
                     delay(100);
                     digitalWrite(i,HIGH);
                     delay(100);
                 }
                 break;
        default: for(int j = 8; j < 14; j++)
                     digitalWrite(j, LOW);
    }
    delay(1000); 
    Serial.println("I am waiting! ");
}
