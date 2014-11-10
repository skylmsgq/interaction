<?php
header( "Content-type: text/html; charset=utf-8" );

include 'join.html';
$post_string = '%7B%22limit%22%3A%2010000%2C%20%22resource_id%22%3A%20%22ed4d2868-d1ca-4aee-9b55-f90252ff2381%22%7D';
$remote_server = 'http://202.121.178.242/api/3/action/datastore_search';
$context = array(
    'http'=>array(
        'method'=>'POST',
        'header'=>'Authorization: a6c2ce2d-9e11-4be0-9ffb-ffe4966ed9e2',
        'content'=>$post_string )
);
$stream_context = stream_context_create( $context );

$openid = $_GET['openid'];

$data = json_decode( file_get_contents( $remote_server, FALSE, $stream_context ), true );
$result = $data['result']['records'];
$zan = count( $result );
echo '<div id="info">
            <img src="img/zan.png" alt=""><span id="zan">'.$zan.'</span>
          </div>
          <p id="openid">'.$openid.'</p>
          </body>
          </html>'
?>
