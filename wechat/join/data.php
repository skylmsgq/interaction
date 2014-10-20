<?php
date_default_timezone_set( PRC );

$method = $_POST['method'];
$openid = $_POST['openid'];

if ( $method=='add' ) {
    $post_string = '%7B%22records%22%3A%20%5B%7B%22OpenID%22%3A%20%22'.$openid.'%22%2C%20%22datetime%22%3A%20%22'.date( 'Y-m-d H:i:s', time() ).'%22%7D%5D%2C%20%22force%22%3A%20true%2C%20%22method%22%3A%20%22insert%22%2C%20%22resource_id%22%3A%20%2203cf1c90-dc2e-44ad-9a6a-e5862fdfd57a%22%7D';
    $remote_server = 'http://202.121.178.242/api/3/action/datastore_upsert';
    $context = array(
        'http'=>array(
            'method'=>'POST',
            'header'=>'Authorization: 954c00c0-b01a-4863-a75b-1ed238d38f35',
            'content'=>$post_string )
    );
    $stream_context = stream_context_create( $context );
    $data = file_get_contents( $remote_server, FALSE, $stream_context );
}
else {
    $post_string = '%7B%22force%22%3A%20true%2C%20%22filters%22%3A%20%7B%22OpenID%22%3A%20%22'.$openid.'%22%7D%2C%20%22resource_id%22%3A%20%2203cf1c90-dc2e-44ad-9a6a-e5862fdfd57a%22%7D';
    $remote_server = 'http://202.121.178.242/api/3/action/datastore_delete';
    $context = array(
        'http'=>array(
            'method'=>'POST',
            'header'=>'Authorization: 954c00c0-b01a-4863-a75b-1ed238d38f35',
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
