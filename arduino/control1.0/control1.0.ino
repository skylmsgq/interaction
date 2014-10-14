char pin_value[2] = {LOW,HIGH};
char buffer = 0;
byte flag = 1;
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
  digitalWrite(9, LOW);
  digitalWrite(10, LOW);
  digitalWrite(11, LOW);
  digitalWrite(12, LOW);
  digitalWrite(13, LOW);
//  for(int i = 0; i < 20;i ++)
//  {
//      digitalWrite(8, HIGH);
//      delay(50);
//      digitalWrite(8, LOW);
//      delay(50);
//  }
    digitalWrite(8, pin_value[flag]);//alarm();
    flag = ~flag;
}

void alarm_stop(void)
{
    digitalWrite(8, LOW);
}

void shark(void)
{
  for(int k = 0;k < 10; k ++)
  {
     for(int i = 9; i < 14; i ++){
                     digitalWrite(i, HIGH);
                     delay(100);
                     digitalWrite(i,LOW);
                     delay(100);
                 }
  }
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
                  digitalWrite(9, HIGH);
                  digitalWrite(10, LOW);
                  digitalWrite(11, LOW);
                  digitalWrite(12, LOW);
                  digitalWrite(13, LOW);
                  break;
        case 'B': alarm_stop();
                  digitalWrite(10, HIGH);
                  digitalWrite(11, LOW);
                  digitalWrite(12, LOW);
                  digitalWrite(13, LOW);
                  break;
        case 'C': alarm_stop();
                  digitalWrite(11,HIGH);
                  digitalWrite(12, LOW);
                  digitalWrite(13, LOW);
                  break;
        case 'D': alarm_stop();
                  digitalWrite(12, HIGH);
                  digitalWrite(13, LOW);
                  break;
        case 'E': alarm_stop();
                  digitalWrite(13, HIGH);
                  break;
        case 'F':shark();
                 break;
        default: for(int j = 9; j < 14; j++)
                     digitalWrite(j, LOW);
    }
    delay(200); 
    Serial.println("I am waiting! ");
}
