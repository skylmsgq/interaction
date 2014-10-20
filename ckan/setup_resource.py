#-*- coding:utf-8 -*-

from common import *

# 点赞记录
resource_id = '03cf1c90-dc2e-44ad-9a6a-e5862fdfd57a'
api_key = '954c00c0-b01a-4863-a75b-1ed238d38f35'

# 关注者互动记录
# resource_id = "61aab5bb-e5e2-455c-a4eb-77f504df1ce3"
# api_key = "954c00c0-b01a-4863-a75b-1ed238d38f35"

datastore_create(resource_id,api_key)

url_update(resource_id,api_key)
