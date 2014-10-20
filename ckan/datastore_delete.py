#-*- coding:utf-8 -*-

import urllib
import urllib2
import json
import pprint

resource_dict = {
        # 点赞记录
        "resource_id": "03cf1c90-dc2e-44ad-9a6a-e5862fdfd57a",
        # 关注者互动记录
        # "resource_id": "61aab5bb-e5e2-455c-a4eb-77f504df1ce3",
        "force": True,
        # "filters": {"pm2.5": "201"}
    }

data_dict = urllib.quote(json.dumps(resource_dict))

request = urllib2.Request("http://202.121.178.242/api/3/action/datastore_delete")
request.add_header("Authorization", "954c00c0-b01a-4863-a75b-1ed238d38f35")

response = urllib2.urlopen(request, data_dict, timeout = 10)
assert response.code == 200

response_dict = json.loads(response.read())
assert response_dict["success"] is True
