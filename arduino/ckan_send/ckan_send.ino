#include <aJSON.h>
#include "SensorLib.h"
#include "DHT22.h"
#include  <Wire.h>
#include  <Adafruit_GFX.h>
#define true True


//定义传感器对象
DHT22                 DHT(7); 
CO2MG                co2(0);
Dust                 dust(0,6);



//定义wifi模块所需常量
long previousMillis = 0;
long previousMillis2 = 0;
long previousMillis3 = 0;

int  interval1=10;  //4
int  interval2=700;  //500
int  interval3=10000;  //10000

unsigned long currentMillis;

char sample_data1[512]="POST /api/3/action/datastore_upsert HTTP/1.1\r\nHost: 202.121.178.242\r\nContent-Length: " ;
char* sample_data2 = "\r\nConnection: close\r\nContent-Type: application/x-www-form-urlencoded\r\nAuthorization: ";
char value[4];

double dustDensity =0 ;
double temperature=0;
double humidity=0;
double co2density=0;


//定义ajson数据转换函数
aJsonObject *createMessage()
{
  aJsonObject *msg = aJson.createObject();
  return msg;
}

aJsonObject *add_temperature(aJsonObject* msg,float value)
{
  aJson.addNumberToObject(msg,"temperature",value);
  return msg;
}

aJsonObject *add_humidity(aJsonObject* msg,float value)
{
  aJson.addNumberToObject(msg,"humidity",value);
  return msg;
}

aJsonObject *add_pm25(aJsonObject* msg,float value)
{
  aJson.addNumberToObject(msg,"pm2_5",value);
  return msg;
}	
	
aJsonObject *add_CO2(aJsonObject* msg,float value)
{
  aJson.addNumberToObject(msg,"co2",value);
  return msg;
}

 aJsonObject *add_text(aJsonObject* msg,char* key,char* value)
{
  aJson.addStringToObject(msg,key,value);
  return msg;
}

aJsonObject *send_to_ckan(char* re_id, aJsonObject* data)
{
  aJsonObject* resource_dict = aJson.createObject();
  
  if(resource_dict == NULL){
    Serial.println("error");
    return resource_dict;
  }
  
  aJson.addStringToObject(resource_dict,"resource_id", re_id);
  aJson.addTrueToObject(resource_dict,"force");
  aJson.addItemToObject(resource_dict,"records", data);
  aJson.addStringToObject(resource_dict,"method", "insert");
  
  return resource_dict;
}

char* build_request(aJsonObject* msg,char* key)
{
  char temp[512];
  char data[256];
  char* json=aJson.print(msg);
  strcpy(temp,sample_data1);
  strcpy(data,json);
  free(json);
  int length=strlen(data);
  strcat(temp,itoa(length,value,10));
  strcat(temp,sample_data2);
  strcat(temp, key);
  strcat(temp,"\r\n\r\n");
  strcat(temp,data);
  strcat(temp,"\r\n");
  return temp;
}

void post_request(char* request)
{
  Serial.write(request);
}



void setup()
{
  Serial.begin(115200);
 
}


void loop()
{
  
  currentMillis = millis();
  //pseudo thread one to handle serial comminication
  if(currentMillis - previousMillis > interval1) 
  {
    previousMillis = currentMillis; 
  // display the message received from the web server, use 5 ms to avoid buffer overflow
    while(Serial.available())
    Serial.write(Serial.read());  
  }
   
   
   
  //pseudo thread two to update sensor value
  if(currentMillis - previousMillis2 > interval2) 
  {
    previousMillis2 = currentMillis; 
   
    dustDensity = dust.getDust();
    temperature = DHT.getTem();
 
    humidity  =DHT.getHum();
  
    co2density  =co2.getCO2();

 }



  //pseudo thread three to post request
  if(currentMillis - previousMillis3 > interval3) 
  {
    previousMillis3 = currentMillis; 
    // create a blank aJson object
    aJsonObject *msg = createMessage();
    aJsonObject* root = aJson.createObject();
    aJsonObject* data = aJson.createArray();
    aJsonObject* guid = aJson.createObject();
    //set parameter to the object
    
    aJson.addItemToArray(data,guid);
 
    add_pm25(msg,dustDensity);
    add_temperature(msg, temperature);
    add_humidity(msg, humidity);

    
    add_pm25(guid,dustDensity);
    add_temperature(guid, temperature);
    add_humidity(guid, humidity);      
    //there is limitation of our CO2 sensor, which is 400ppm
    if (co2density ==-1)
      add_text(msg,"CO2","< 400ppm");
    else
      {
        add_CO2(msg,co2density);
        add_CO2(guid,co2density);;
      } 
   char* api = "7b53bb81-195c-477c-8513-b6a7d7bad0d3";
   //char* api = "954c00c0-b01a-4863-a75b-1ed238d38f35";
   char* resource = "1f913a7d-b254-442d-9b0b-b54d1486acd0";
   //char* resource = "d97626a1-6b41-45f5-8f3f-7420f9d60d3c";
   //post the data
   
    root = send_to_ckan(resource,data);
    char* result = build_request(root,api);
    post_request(result);
    Serial.println("*************************");
    Serial.println(Serial.read());
    Serial.println("*************************");
    //clean the memory to avoid overflow
    aJson.deleteItem(root);
  }
  delay(1000);
}


