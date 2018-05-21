<?php

class LoginService
{
	function getUserFromDatabase($username){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT username, password_hash, email, registration_sequence, has_registered FROM dz2_users WHERE username=:username' );

			$st->execute( array( 'username' => $username) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();

		if($row === false)
			return false;
		else
			return new User($row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered']);
	}

	function getUserFromDatabaseWithRegSeq($reg_seq){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT username, password_hash, email, registration_sequence, has_registered FROM dz2_users WHERE registration_sequence=:reg_seq' );

			$st->execute( array( 'reg_seq' => $reg_seq) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();

		if($row === false)
			return false;
		else
			return new User($row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered']);
	}

	public static function generateRegistrationSequence(){
		$reg_seq = '';
		for( $i = 0; $i < 20; ++$i )
			$reg_seq .= chr( rand(0, 25) + ord( 'a' ) ); // Zalijepi slučajno odabrano slovo
		return $reg_seq;
	}

	function sendRegistrationRequest($reg_seq){
		try
		{
			/*DebugService::showPost();
			echo $reg_seq.'</br>';
			exit();*/

			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_users(username, password_hash, email, registration_sequence, has_registered) VALUES ' .
													'(:username, :password_hash, :email, :reg_seq, 0)' );

			$st->execute( array( 'username' => $_POST['username'],
				'password_hash' => password_hash( $_POST['password'], PASSWORD_DEFAULT ),
				'email' => $_POST['email'],
				'reg_seq'  => $reg_seq ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$this->sendEmail($reg_seq);
	}

	function sendEmail($reg_seq){
		$to       = $_POST['email'];
		$subject  = 'Registracijski mail';
		$message  = 'Poštovani ' . $_POST['username'] . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
		$message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/index.php?rt=login/confirmRegistration&code=' . $reg_seq . "\n";
		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
			'Reply-To: rp2@studenti.math.hr' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$isOK = mail($to, $subject, $message, $headers);

		if( !$isOK )
			exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );
	}

	function registerUser($username){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE dz2_users SET has_registered = 1 WHERE username = :username;' );

			$st->execute( array( 'username' => $username) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

};

?>

