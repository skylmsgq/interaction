#include <aJSON.h>

char* url1 = "POST /api/3/action/datastore_search HTTP/1.1\r\nHost: 202.121.178.242\r\nContent-Length: ";
char* url2 = "\r\nConnection: close\r\nContent-Type: application/x-www-form-urlencoded\r\nAuthorization: ";

aJsonObject* para_data(char* id)
{
	aJsonObject* resource_dict = aJson.createObject();
        aJsonObject* tag = aJson.createArray();
        aJsonObject* guid = aJson.createItem("pm2.5");
        
        aJson.addItemToArray(tag, guid);
        //aJson.addArraryToObject(resource_dict, tag);

	aJson.addStringToObject(resource_dict, "resource_id", id);
	aJson.addNumberToObject(resource_dict, "limit", 1);
	aJson.addItemToObject(resource_dict, "fields", tag);

	return resource_dict;
}

 char* set_request(aJsonObject* data, char* key)
 {
 	int length;
 	char post_data[1024] = {0};
 	char buff[512] = {0};
 	char count[4] = {0};

    char* data_json = aJson.print(data);
    strcpy(buff, data_json);
    free(data_json);
 	length = strlen(buff);

 	strcpy(post_data, url1);
 	strcat(post_data, itoa(length, count, 10));
 	strcat(post_data,url2);
 	strcat(post_data, key);
    strcat(post_data,"\r\n\r\n");

    strcat(post_data,buff);
    strcat(post_data, "\r\n");

    return post_data;
 }

 void _send_ckan(char* request)
 {
 	Serial.write(request);
 }

void setup()
{
	Serial.begin(115200);
}

void loop()
{
	char* api = "" ;
        char* resource_id = "";
	char* result = set_request(para_data(resource_id),api);
	_send_ckan(result);
	while(Serial.available())
	{
		Serial.write(Serial.read());
		//aJsonObject* jsonObject = aJson.parse(Serial.read());
		delay(100);
	}
}