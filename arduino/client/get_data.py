import urllib2
import urllib
import json
import time
import pprint

def set_request(data_id, api_key, key_world):
    resource_dict = {
        "resource_id": data_id,
        "limit": 1000,
        "fields": key_world,
    }
    data_dict = urllib.quote(json.dumps(resource_dict))

    request = urllib2.Request('http://202.121.178.242/api/3/action/datastore_search')
    request.add_header('Authorization', api_key)

    data_infor = []
    data_infor.append(request)
    data_infor.append(data_dict)

    return data_infor

def from_ckan(data_infor, choise):
    response = urllib2.urlopen(data_infor[0], data_infor[1], timeout = 10)
    assert response.code == 200

    response_dict = json.loads(response.read())
    assert response_dict["success"] is True

    length = ''

    length = len(response_dict['result']['records'])

    if choise == 1:
        if length >= 1:
            result = response_dict['result']['records'][length -1]
            for key in result:
                value = float(result[key])
        else:
            value = 0
    else:
        value = length*5
    return value

def send_serial(aqi_value, counts, threshold):
    #set serial flag
    set_flag = 'N'
    flag_tab = ['A', 'B', 'C', 'D', 'E', 'F']

    if (aqi_value > threshold ):
        if  counts!= 0:
            if  counts >= 50 :
                set_flag = 'F'
            else:
                for value in flag_tab:
                    set_flag = flag_tab[ int(counts / 10 ) ]
        else:
            set_flag = 'Y'
    else:
        set_flag = 'N'

    print set_flag
    return set_flag

