#-*- coding:utf-8 -*-

import urllib2
import urllib
import json
import pprint

resource_dict = {
    	"resource_id": "03cf1c90-dc2e-44ad-9a6a-e5862fdfd57a",
    	"force": True,
        "record":[{'OpenID':'read','time':'2'}],
        "method":"update",
	}

data_dict = urllib.quote(json.dumps(resource_dict))

request = urllib2.Request('http://202.121.178.242/api/3/action/datastore_upsert')
request.add_header('Authorization', "954c00c0-b01a-4863-a75b-1ed238d38f35")

response = urllib2.urlopen(request, data_dict, timeout = 10)
assert response.code == 200

response_dict = json.loads(response.read())
assert response_dict['success'] is True