<?php
$post_string = '%7B%22limit%22%3A%201%2C%20'.'%22sort%22%3A%20%22_id%20desc%22%2C%20'.'%22resource_id%22%3A%20%22d97626a1-6b41-45f5-8f3f-7420f9d60d3c%22%7D';
$remote_server = 'http://202.121.178.242/api/3/action/datastore_search';
$context = array(
	'http'=>array(
		'method'=>'POST',
		'header'=>'Authorization: 954c00c0-b01a-4863-a75b-1ed238d38f35',
		'content'=>$post_string )
);
$stream_context = stream_context_create( $context );
$data = json_decode( file_get_contents( $remote_server, FALSE, $stream_context ), true );
$result = $data['result']['records'];
$pm = $result[0]['pm2.5'];

$post_string = '%7B%22limit%22%3A%201%2C%20'.'%22sort%22%3A%20%22_id%20desc%22%2C%20'.'%22resource_id%22%3A%20%22519e34eb-920d-4215-a634-a47832e03cf6%22%7D';
$context = array(
	'http'=>array(
		'method'=>'POST',
		'header'=>'Authorization: 954c00c0-b01a-4863-a75b-1ed238d38f35',
		'content'=>$post_string )
);
$stream_context = stream_context_create( $context );
$data = json_decode( file_get_contents( $remote_server, FALSE, $stream_context ), true );
$result = $data['result']['records'];
$humidity = $result[0]['value'];
echo json_encode( array(
		'pm' => $pm,
		'humidity' => $humidity )
);
?>
