<?php
	# includes
	require_once __DIR__ . '/../Connection.php';
	require_once __DIR__ . '/../Validate.php';

	# global vars
	$response = [];

	# connection
	$connection = new Connection();

	# TODO
	if (isset($_POST['name']) && isset($_POST['text'])) {
		$name = new ValidateString($connection->prevent(str_replace("\r\n", "\n", $_POST['name'])));
		$text = new ValidateString($connection->prevent(str_replace("\r\n", "\n", $_POST['text'])));

		if ($text->min(1)) {
			$connection->insert(TABLE, 'name,text', "'$name->value','$text->value'");
			if ($connection->affectedRows())
				http_response_code(201);
			else
				http_response_code(409);
		}
		else
			http_response_code(409);

		# close connection
		$connection->close();
	}
	else
		# response
		http_response_code(400);
?>