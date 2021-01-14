<?php
	# includes
	require_once __DIR__ . '/../vendor/autoload.php';
	require_once __DIR__ . '/../Validate.php';

	# TODO
	if (isset($_POST['name']) && isset($_POST['text'])) {
		# connection
	    $connection = new Connection\Connection();

		$name = new ValidateString($_POST['name']);
		$text = new ValidateString(str_replace("\r\n", "\n", $_POST['text']));

		if ($text->min(1)) {
			try {
				$connection->insert('comments', ['name', 'text'], [$name->value, $text->value]);

				http_response_code(201);
			}
			catch (\Exception) {
				http_response_code(409);
			}
		}
		else {
			http_response_code(400);
		}

		# close connection
		$connection->close();
	}
	else {
		# response
		http_response_code(400);
	}
?>