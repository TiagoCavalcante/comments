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
		try {
			$name = new ValidateString($connection->prevent(str_replace("\r\n", "\n", $_POST['name'])));
			$text = new ValidateString($connection->prevent(str_replace("\r\n", "\n", $_POST['text'])));

			if ($name->max(32) && $text->min(1) && $text->max(1023)) {
				$response = $connection->select(TABLE, 'id', "name = '$name->value' AND text = '$text->value'");
				if ($connection->numRows($response) == 0) {
					$connection->insert(TABLE, 'name,text', "'$name->value','$text->value'");
					if ($connection->affectedRows())
						http_response_code(201);
					else
						http_response_code(400);
				}
				else
					http_response_code(409);
			}
			else
				http_response_code(400);
		}
		catch (Exception $e) {
			http_response_code(400);
		}

		# close connection
		$connection->close();
	}
	else
		# response
		http_response_code(400);
?>