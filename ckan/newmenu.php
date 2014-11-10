<?php
header("Content-type: text/html; charset=utf-8");

define("ACCESS_TOKEN", 'g4nJnz7iCI_Nq_J3vTcTTM2Z43bJly7gGApeqPYw28FZ9bIADdGKLxt-WU2mhZvFqrfFqQKHzFxj2u1BwiQ3G-LxV8spWjYdTf46Gru6tcg');

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
        "name":"加入我们",
        "key":"join_us"
      },
      {  
        "name":"校园随手拍",
        "sub_button":[
          {  
            "type":"click",
            "name":"修改昵称",
            "key":"name"
          },
          {
            "type":"click",
            "name":"上传图片",
            "key":"upload"
          },
          {
            "type":"click",
            "name":"说点什么",
            "key":"words"
          },
          {
            "type":"click",
            "name":"使用帮助",
            "key":"help"
          }]
      }]
 }';

echo createMenu($data);//创建菜单
?>