#-*- coding:utf-8 -*-

import urllib2
import urllib
import json
import cookielib
import time

resource_dict = {
        # "sql": "select * from d97626a1-6b41-45f5-8f3f-7420f9d60d3c"
    	"resource_id": "519e34eb-920d-4215-a634-a47832e03cf6",
    	"limit": 10000,
        #"fields": ["pm2.5"],
        #"offset": offset,
        "sort": "_id desc",
    	#"filters": {"OpenID": "o9ZxcuIUTEacTCK6YQLURv-Jg5RM"}
	}

data_dict = urllib.quote(json.dumps(resource_dict))

request = urllib2.Request('http://202.121.178.242/api/3/action/datastore_search')
request.add_header('Authorization', '954c00c0-b01a-4863-a75b-1ed238d38f35')

response = urllib2.urlopen(request, data_dict, timeout = 10)
assert response.code == 200

response_dict = json.loads(response.read())
assert response_dict['success'] is True
records_dict = response_dict['result']['records']
print records_dict[0]
