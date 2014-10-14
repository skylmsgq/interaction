#-*- coding:utf-8 -*-

import urllib2
import urllib
import json
import cookielib
import time

alarm = True

count = 1

resource_dict = {
        # "sql": "select * from d97626a1-6b41-45f5-8f3f-7420f9d60d3c"
        "resource_id": "d97626a1-6b41-45f5-8f3f-7420f9d60d3c",
        "limit": 1,
        #"fields": ["pm2.5"],
        #"offset": offset,
        "sort": "_id desc",
        #"filters": {"OpenID": "o9ZxcuIUTEacTCK6YQLURv-Jg5RM"}
    }

data_dict = urllib.quote(json.dumps(resource_dict))

request = urllib2.Request('http://202.121.178.242/api/3/action/datastore_search')
request.add_header('Authorization', '954c00c0-b01a-4863-a75b-1ed238d38f35')

while True:
    response = urllib2.urlopen(request, data_dict, timeout = 10)
    assert response.code == 200

    response_dict = json.loads(response.read())
    assert response_dict['success'] is True
    records_dict = response_dict['result']['records']
    pm25 = records_dict[0]

    aqi = pm25['pm2.5']

    print count,aqi

    # aqi threshold
    if ( ( int(aqi) > 100 ) and alarm ):
        alarm = False
        # make a POST to OMNILab_wechat
        cj = cookielib.LWPCookieJar()
        opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
        urllib2.install_opener(opener)
        #登陆
        paras = {'username':'weixin@omnilab.sjtu.edu.cn','pwd':'d59c47ce5f40949fb4f4689f3d37c203','imgcode':'','f':'json'}
        req = urllib2.Request('https://mp.weixin.qq.com/cgi-bin/login?lang=zh_CN',urllib.urlencode(paras))
        req.add_header('Accept','application/json, text/javascript, */*; q=0.01')
        req.add_header('Accept-Encoding','gzip,deflate,sdch')
        req.add_header('Accept-Language','zh-CN,zh;q=0.8')
        req.add_header('Connection','keep-alive')
        req.add_header('Content-Length','79')
        req.add_header('Content-Type','application/x-www-form-urlencoded; charset=UTF-8')
        req.add_header('Host','mp.weixin.qq.com')
        req.add_header('Origin','https://mp.weixin.qq.com')
        req.add_header('Referer','https://mp.weixin.qq.com/cgi-bin/loginpage?t=wxm2-login&lang=zh_CN')
        req.add_header('User-Agent','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.76 Safari/537.36')
        req.add_header('X-Requested-With','XMLHttpRequest')
        ret = urllib2.urlopen(req)
        retread = ret.read()
        print retread
        token = json.loads(retread)
        # print token['ErrMsg'][44:]
        index = token['redirect_url'].find('token')
        print index
        token = token['redirect_url'][44:]
        print token
        paras2 = {'type':'1','content':'颗粒物浓度已经超标，请引起重视！','error':'false','imgcode':'','tofakeid':'51375040','token':token,'ajax':'1'}# content为你推送的信息，tofakeid为用户的唯一标示id，可在html代码里找到
        req2 = urllib2.Request('https://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response&lang=zh_CN',urllib.urlencode(paras2))
        req2.add_header('Accept','*/*')
        req2.add_header('Accept-Encoding','gzip,deflate,sdch')
        req2.add_header('Accept-Language','zh-CN,zh;q=0.8')
        req2.add_header('Connection','keep-alive')
        req2.add_header('Content-Type','application/x-www-form-urlencoded; charset=UTF-8')
        req2.add_header('Host','mp.weixin.qq.com')
        req2.add_header('Origin','https://mp.weixin.qq.com')
        req2.add_header('Referer','https://mp.weixin.qq.com/cgi-bin/singlemsgpage?msgid=&source=&count=20&t=wxm-singlechat&fromfakeid=150890&token=%s&lang=zh_CN'%token)
        req2.add_header('User-Agent','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.76 Safari/537.36')
        req2.add_header('X-Requested-With','XMLHttpRequest')
        #不加cookie也可发送
        #req2.add_header('Cookie',cookie2)
        ret2 = urllib2.urlopen(req2)
        #ret2=opener.open(req2)
        print 'x', ret2.read()

    count += 1

    time.sleep(1)
