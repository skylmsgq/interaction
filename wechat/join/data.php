<?php
header( "Content-type: text/html; charset=utf-8" );
date_default_timezone_set( PRC );

$method = $_POST['method'];
$openid = $_POST['openid'];

if ( $method=='add' ) {
    $post_string = '%7B%22records%22%3A%20%5B%7B%22OpenID%22%3A%20%22'.$openid.'%22%2C%20%22点赞时间%22%3A%20%22'.date( 'Y-m-d H:i:s', time() ).'%22%7D%5D%2C%20%22force%22%3A%20true%2C%20%22method%22%3A%20%22insert%22%2C%20%22resource_id%22%3A%20%22ed4d2868-d1ca-4aee-9b55-f90252ff2381%22%7D';
    $remote_server = 'http://202.121.178.242/api/3/action/datastore_upsert';
    $context = array(
        'http'=>array(
            'method'=>'POST',
            'header'=>'Authorization: a6c2ce2d-9e11-4be0-9ffb-ffe4966ed9e2',
            'content'=>$post_string )
    );
    $stream_context = stream_context_create( $context );
    $data = file_get_contents( $remote_server, FALSE, $stream_context );
}
else {
    $post_string = '%7B%22force%22%3A%20true%2C%20%22filters%22%3A%20%7B%22OpenID%22%3A%20%22'.$openid.'%22%7D%2C%20%22resource_id%22%3A%20%22ed4d2868-d1ca-4aee-9b55-f90252ff2381%22%7D';
    $remote_server = 'http://202.121.178.242/api/3/action/datastore_delete';
    $context = array(
        'http'=>array(
            'method'=>'POST',
            'header'=>'Authorization: a6c2ce2d-9e11-4be0-9ffb-ffe4966ed9e2',
            'content'=>$post_string )
    );
    $stream_context = stream_context_create( $context );
    $data = file_get_contents( $remote_server, FALSE, $stream_context );

}

echo json_encode( array(
        'method' => $method,
        'openid' => $openid
    ) );
?>
