<?php

class Quack
{
	protected $quack, $date, $username;

	function __construct($quack, $date, $username)
	{
		$this->quack = $quack;
		$this->date = $date;
		$this->username = $username;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>

