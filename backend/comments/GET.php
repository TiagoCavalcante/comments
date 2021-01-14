<?php
	# includes
	require_once __DIR__ . '/../vendor/autoload.php';

	# global vars
	$response = [];

	# connection
	$connection = new Connection\Connection();

	# TODO
	foreach ($connection->select('comments', ['name', 'text']) as $result) {
		$response[] = [
			'name' => $result['name'],
			'text' => $result['text']
		];
	}

	# close connection
	$connection->close();

	# response
	header('Content-type: application/json');
	echo json_encode($response);
?>