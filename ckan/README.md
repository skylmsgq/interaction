Interaction with Ckan
说明：
1. common.py中为三个基本函数，datastore_create，datastore_upsert，url_update，如果需要创建datastore，请修改datastore_create里面的fields；
2. datastore_delete用于清除数据，仅用于demo前无用数据的清除，注意根据需要决定是否加filters；
    3. datastore_search和datastore_update用于测试，demo时无用；
4. detect用于监测颗粒物浓度，重要！！！记得正式demo之前修改以下部分，“颗粒物浓度阈值”、“发送警报消息给三个fakeid”；
    5. msg用于测试微信消息发送，不管；
    6. newmenu用于新建微信公众号自定义菜单，不管；
7. setup_resource用于初始化resource，主要完成：新建datastore、更新url，使用时记得修改resource_id；
    8. upload_data用于上传数据，供测试使用，使用时记得修改resource_id。

