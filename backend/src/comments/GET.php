<?php
	# includes
	require_once __DIR__ . '/../Connection.php';

	# global vars
	$response = [];

	# connection
	$connection = new Connection();

	# TODO
	$results = $connection->select(TABLE, 'name,text');
	for ($i = 0; $result = $connection->nextResult($results); $i++) {
		$response[$i]['name'] = $result['name'];
		$response[$i]['text'] = $result['text'];
	}

	# close connection
	$connection->close();

	# response
	header('Content-type: application/json');
	echo json_encode($response);
?>