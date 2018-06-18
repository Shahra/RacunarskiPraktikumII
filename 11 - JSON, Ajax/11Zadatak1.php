<?php
	function sendJSONandExit( $message ) {
		// Kao izlaz skripte pošalji $message u JSON formatu i
		// prekini izvođenje.
		header('Content-type:application/json;charset=utf-8');
		echo json_encode( $message );
		flush();
		exit(0);
	}

	$a = $_GET[ "a" ];
	$b = $_GET[ "b" ];
	$operation = $_GET[ "operation" ];

	$message = [];
	if($operation === '+') {
		$message['rezultat'] = $a + $b;
	}
	else if($operation === '-') {
		$message['rezultat'] = $a - $b;
	}
	else if($operation === '*') {
		$message['rezultat'] = $a * $b;
	}
	else if($operation === '/') {
		$message['rezultat'] = $a / $b;
	}
	sendJSONandExit($message);
?>
