<?php
	# includes
	require_once __DIR__ . '/env.php';

	# vars
	$uri = __DIR__ . $_SERVER['REQUEST_URI'] . '/' . $_SERVER['REQUEST_METHOD'] . '.php';

	# CORS
	header('Access-Control-Allow-Origin: ' . getenv('CORS'));

	if (file_exists($uri))
		require_once $uri;
	else
		http_response_code(404);
?>