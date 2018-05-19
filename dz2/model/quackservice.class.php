<?php

class QuackService
{

	function getIdOfUser( $username )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id FROM dz2_users WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return $row['id'];
	}

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

	function checkIfIFollow($followed_username){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT * FROM dz2_follows WHERE id_user = :id_user AND id_followed_user = :id_followed_user;');

			$st->execute( array( 'id_user' => $this->getIdOfUser($_SESSION['username']), 'id_followed_user' => $this->getIdOfUser($followed_username) ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return false;
		else
			return true;
	}

	function getQuacksFromFollowees()
	{
		session_start();
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT q.quack, q.date, u.username FROM dz2_users u, dz2_quacks q WHERE q.id_user IN (SELECT f.id_followed_user FROM dz2_users u, dz2_follows f WHERE u.username = :username and u.id = f.id_user) and q.id_user = u.id ORDER BY q.date DESC;');

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

	function unfollowUser($username)
	{
		session_start();
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('DELETE FROM dz2_follows WHERE id_user = :id_user AND id_followed_user = :id_followed_user;');

			$st->execute( array( 'id_user' => $this->getIdOfUser($_SESSION['username']), 'id_followed_user' => $this->getIdOfUser($username)) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function followUser($username)
	{
		session_start();
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('INSERT INTO dz2_follows VALUES (:id_user, :id_followed_user);');

			$st->execute( array( 'id_user' => $this->getIdOfUser($_SESSION['username']), 'id_followed_user' => $this->getIdOfUser($username)) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function getFollowers()
	{
		session_start();
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT username FROM dz2_users WHERE id IN (SELECT DISTINCT(id_user) FROM dz2_follows WHERE id_followed_user = :my_id);');

			$st->execute( array( 'my_id' => $this->getIdOfUser($_SESSION['username'] ) ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = $row['username'];
		}

		return $arr;
	}

};

?>

