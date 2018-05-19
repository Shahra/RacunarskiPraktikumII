<?php

class QuackService
{

	function getMyQuacks()
	{
		session_start();
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT q.quack, q.date, u.username FROM dz2_users u, dz2_quacks q WHERE q.id_user = u.id AND u.username = :username ORDER BY q.date DESC');

			$st->execute( array( 'username' => $_SESSION['username'] ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Quack( $row['quack'], $row['date'], $row['username']);
		}

		return $arr;
	}
};

?>

