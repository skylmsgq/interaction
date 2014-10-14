#-*- coding:utf-8 -*-

from common import *
import time


# your resource_id and api_key
resource_id = '03cf1c90-dc2e-44ad-9a6a-e5862fdfd57a'
api_key = '954c00c0-b01a-4863-a75b-1ed238d38f35'

# data to transfer
data = [{"GPS":{
                "GPS_TIME":"2014-09-19 13:57:51",
                "LATITUDE":31.02647,
                 "SPEED":0.147,
                 "LONTITUDE":121.432101767,
                 "HEIGHT":62.9
                 },
            "DATA":{
                "SENSOR_TYPE": 0,
                "SENSOR_ID":"af18d284-3c8c-5442-ef9e-217e8ec77853",
                "SENSOR_VALUE":"[be ef be ef]"
                },
            "BOARD_TIME":"2014-09-05 13:58:00",
            "DEVICE_ID":"71178bf0-54e4-4e10-a2e0-6103f70621e8"}]

result = []
item = {}
item["Submit Time"] = data[0]["GPS"]["GPS_TIME"]
item["BOARD_TIME"] = data[0]["BOARD_TIME"]
item["GPS"] = "("+str(data[0]["GPS"]["LATITUDE"])+","+str(data[0]["GPS"]["LONTITUDE"])+")"
item["SENSOR_ID"] = data[0]["DATA"]["SENSOR_ID"]
item["SENSOR_VALUE"] = data[0]["DATA"]["SENSOR_VALUE"]
item["DEVICE_ID"] = data[0]["DEVICE_ID"]
result.append(item)

# call the datastore_upsert() to insert data

air=[{
    'pm2.5':40,
    'humidity':55,
    'temperature':27
    #"time": time.strftime('%Y-%m-%d %H:%M:%S' ,time.localtime(time.time()))
}];
zan=[{
    "OpenID": "1",
    "datetime": "2014-10-14 21:59:00",
}]

datastore_upsert(resource_id, zan, api_key)
