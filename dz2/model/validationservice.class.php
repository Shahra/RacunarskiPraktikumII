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
	public static function isUsernameValid($username){
		return preg_match( '/^[a-zA-Z]{3,10}$/', $username);
	}

	public static function isPasswordValid($password){
		return preg_match( '/^.{3,10}$/', $password);
	}


};

?>

