# coding=utf-8

import urllib2
import urllib
import json
import time
import pprint

alarm = False

count = 1

resource_dict = {
    	"resource_id": "d97626a1-6b41-45f5-8f3f-7420f9d60d3c",
    	"limit": 1,
        "fields": "pm2.5",
        # "sort": "上传时间 desc",
    	#"filters": {"OpenID": "o9ZxcuIUTEacTCK6YQLURv-Jg5RM"}
	}

data_dict = urllib.quote(json.dumps(resource_dict))

request = urllib2.Request('http://202.121.178.242/api/3/action/datastore_search')
request.add_header('Authorization', '954c00c0-b01a-4863-a75b-1ed238d38f35')

while True:
    response = urllib2.urlopen(request, data_dict, timeout =10)
    assert response.code == 200

    response_dict = json.loads(response.read())
    assert response_dict['success'] is True
    pm25 = response_dict['result']['records'][0]

    for key in pm25:
        aqi = pm25[key]

    print count,aqi

    # aqi threshold
    #if aiq >= 90:
    # make a POST to OMNILab_wechat

    count += 1

    time.sleep(0.5)

