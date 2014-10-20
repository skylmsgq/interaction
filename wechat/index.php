<?php
header("Content-type:text/html;charset=utf8");
//define your token
define("TOKEN", "omnilab");
date_default_timezone_set(PRC);

$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();


class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $time = time();
            $msgType = $postObj->MsgType;

            $first = true;

            //$mysql = new SaeMysql();

            $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>0</FuncFlag>
            </xml>";
            $webTplHead = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <ArticleCount>%d</ArticleCount>
            <Articles>";
            $webTplBody = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>";
            $webTplFoot = "</Articles>
            <FuncFlag>0</FuncFlag>
            </xml>";

            switch ($msgType){
                case 'text':
                    $keyword = trim($postObj->Content);
                    /*$sql = "select state, vip from user_state where fromUsername = '$fromUsername'";
                    $result = $mysql->getData($sql);
                    $state = $result[0]['state'];
                    $vip = $result[0]['vip'];*/
                    /*$sql = "update user_state set state = '1' where fromUsername = '$fromUsername'";
                    $mysql->runSql($sql);*/

                    $subfix = '@ckan';
                    if (strrpos($keyword, $subfix) == strlen($keyword) - 5){
                        $keyword = rtrim($keyword, $subfix);
                        if (!($keyword=='') & $first){
                            $first = false;
                            $post_string = '%7B%22records%22%3A%20%5B%7B%22OpenID%22%3A%20%22'.$fromUsername.'%22%2C%20%22发布时间%22%3A%20%22'.date('Y-m-d H:i:s',time()).'%22%2C%20%22评论内容%22%3A%20%22'.$keyword.'%22%7D%5D%2C%20%22force%22%3A%20true%2C%20%22method%22%3A%20%22insert%22%2C%20%22resource_id%22%3A%20%2261aab5bb-e5e2-455c-a4eb-77f504df1ce3%22%7D';
                            $remote_server = 'http://202.121.178.242/api/3/action/datastore_upsert';
                            $context = array(
                                'http'=>array(
                                    'method'=>'POST',
                                    'header'=>'Authorization: 954c00c0-b01a-4863-a75b-1ed238d38f35',
                                    'content'=>$post_string)
                                );
                            $stream_context = stream_context_create($context);
                            $data = file_get_contents($remote_server,FALSE,$stream_context);
                            $contentStr = '我们收到您的消息了: '.$keyword;
                        }
                    }else{
                        $contentStr = $this->simsim($keyword);
                    }
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, "text", $contentStr);
                    echo $resultStr;

                    break;

                case 'event':
                    $keyword = trim($postObj->Event);
                    switch ($keyword) {
                        case 'subscribe':
                            //mysql_set_charset("gbk");
                            //$sql = "insert into user_state values('$fromUsername','','0','0','0','0','0','')";
                            //$mysql->runSql($sql);

                            $post_string = '%7B%22records%22%3A%20%5B%7B%22OpenID%22%3A%20%22'.$fromUsername.'%22%2C%20%22关注时间%22%3A%20%22'.date('Y-m-d H:i:s',time()).'%22%7D%5D%2C%20%22force%22%3A%20true%2C%20%22method%22%3A%20%22insert%22%2C%20%22resource_id%22%3A%20%22d7c6b96c-7065-4e1f-9cae-70e2b9914be3%22%7D';
                            $remote_server = 'http://202.121.178.242/api/3/action/datastore_upsert';
                            $context = array(
                                'http'=>array(
                                    'method'=>'POST',
                                    'header'=>'Authorization: 954c00c0-b01a-4863-a75b-1ed238d38f35',
                                    'content'=>$post_string)
                                );
                            $stream_context = stream_context_create($context);
                            $data = file_get_contents($remote_server,FALSE,$stream_context);

                            $contentStr = "欢迎关注OMNILab\nOMNILab位于上海交通大学网络信息中心，是一个以技术和兴趣为导向的开放科研工作室，全称为开放移动网络与信息服务创新工作室";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, "text", $contentStr);
                            echo $resultStr;

                            break;

                        case 'unsubscribe':
                            //$sql = "delete from user_state where fromUsername='$fromUsername'";
                            //$mysql->runSql($sql);

                            $post_string = '%7B%22force%22%3A%20true%2C%20%22filters%22%3A%20%7B%22OpenID%22%3A%20%22'.$fromUsername.'%22%7D%2C%20%22resource_id%22%3A%20%22d7c6b96c-7065-4e1f-9cae-70e2b9914be3%22%7D';
                            $remote_server = 'http://202.121.178.242/api/3/action/datastore_delete';
                            $context = array(
                                'http'=>array(
                                    'method'=>'POST',
                                    'header'=>'Authorization: 954c00c0-b01a-4863-a75b-1ed238d38f35',
                                    'content'=>$post_string)
                                );
                            $stream_context = stream_context_create($context);
                            $data = file_get_contents($remote_server,FALSE,$stream_context);

                            break;

                        case 'CLICK':
                            $eventKey = trim($postObj->EventKey);
                            if($eventKey == 'join_us'){
                                $resultStr = sprintf($webTplHead, $fromUsername, $toUsername, $time, "news", 1);
                                $resultStr .= sprintf($webTplBody, "集赞总动员","加入我们，为环保点赞", "http://202.120.58.116/interaction/wechat/join/img/top.jpg", "http://202.120.58.116/interaction/wechat/join/join.php?openid=$fromUsername");
                                $resultStr .= $webTplFoot;
                                echo $resultStr;
                            }
                            break;

                        default:
                            break;
                    }
                    break;

                case 'image':
                    $keyword = trim($postObj->PicUrl);
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, "text", $keyword);
                    echo $resultStr;
                    break;

                case 'voice':
                    break;

                case 'video':
                    break;

                case 'location':
                    break;

                case 'link':
                    break;

                default:
                    break;
            }
            //$mysql->closeDb();

        }else {

        }
    }

    public function simsim($keyword){
        $key="09a78f17-c455-4422-90b6-efda56ac8d71";
        $url_simsimi="http://sandbox.api.simsimi.com/request.p?key=".$key."&lc=ch&ft=0.0&text=".$keyword;
        $json=file_get_contents($url_simsimi);
        $result=json_decode($json,true);
        $response=$result['response'];
        if(!empty($response)){
            return $response;
        }else{
            return '我们收到您的消息了: '.$keyword;
        }
    }
}
?>