<?php
header("Content-type: text/html; charset=utf-8");

define("ACCESS_TOKEN", 'PMykLvLljp8y52AZKyaW0CncYBffvwn5f08ZQgntcNpvp_K-YSjw57UDxqD9-0fy8XGb6LOX1W-3C3fMEaoQHj88RsEW1SKcinEC4Wm2-_o');

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
          "name":"我要加入",
          "key":"join_us"
      },
      {  
          "type":"click",
          "name":"校园随手拍",
          "key":"anyshoot"
      }]
 }';

echo createMenu($data);//创建菜单
?>