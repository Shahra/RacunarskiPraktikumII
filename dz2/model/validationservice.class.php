<?php

class ValidationService
{

	public static function loggedIn()
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if(!isset( $_SESSION['username'] ) ){
			return false;
		}
		else{
			return true;
		}
	}

};

?>

