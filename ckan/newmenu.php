<?php
header("Content-type: text/html; charset=utf-8");

define("ACCESS_TOKEN", 'WF9Up7t1PxFfN7rA-0rgZ4OtMKtRpHUV4PS1fcSxAWPMy7tDkXnkdIKNJq1dk2ywtPaqawD3wy6j0CupxJXzbQ');

//创建菜单
function createMenu($data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $tmpInfo = curl_exec($ch);
    if (curl_errno($ch)) {
      return curl_error($ch);
    }
    curl_close($ch);
    return $tmpInfo;
}

$data = '{
     "button":[
      {
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "type":"click",
           "name":"歌手简介",
           "key":"V1001_TODAY_SINGER"
      },
      {
           "name":"菜单",
           "sub_button":[
            {
               "type":"click",
               "name":"hello word",
               "key":"V1001_HELLO_WORLD"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';

echo createMenu($data);//创建菜单
?>