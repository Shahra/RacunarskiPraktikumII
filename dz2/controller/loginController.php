<?php 

class LoginController extends BaseController
{
	public function index() 
	{
		$this->registry->template->message = '';
		$this->registry->template->show( 'login_index' );
	}
	
	public function processLogin()
	{
		session_start();
		if(!preg_match('/^[a-zA-Z]{1,20}$/', $_POST["username"])){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
			exit();
		}
		// Sve je OK, provjeri jel ga ima u bazi.
		$db = DB::getConnection();
		
		try
		{
			$st = $db->prepare( 'SELECT password_hash FROM dz2_users WHERE username=:username' );
			$st->execute( array( 'username' => $_POST["username"] ) );
		}
		catch( PDOException $e ) {
			$this->registry->template->message = $e;
			$this->registry->template->show( 'login_index' );
			exit();
		}

		if($_POST['gumb'] === 'login'){
			$row = $st->fetch();
			if( $row === false )
			{
				// Taj user ne postoji, upit u bazu nije vratio ništa.
				$this->registry->template->message = 'Ne postoji korisnik s tim imenom.';
				$this->registry->template->show( 'login_index' );
				exit();
			}
			else
			{
				// Postoji user. Dohvati hash njegovog passworda.
				$hash = $row[ 'password_hash'];

				// Da li je password dobar?
				if( password_verify( $_POST['password'], $hash ) )
				{
					// Dobar je. Ulogiraj ga.
          $_SESSION['username'] = $_POST['username'];
					header( 'Location: ' . __SITE_URL . '/index.php?rt=users' );
					exit();
				}
				else
				{
					// Nije dobar. Crtaj opet login formu s pripadnom porukom.
					$this->registry->template->message = 'Postoji user, ali password nije dobar.';
					$this->registry->template->show( 'login_index' );
					exit();
				}
			}
		}
		
		if($_POST['gumb'] === 'novi'){
			if( $st->rowCount() > 0 )
			{
				$this->registry->template->message = 'Taj korisnik već postoji.';
				$this->registry->template->show( 'login_index' );
				exit();
			}
			else
			{
				// Stvarno nema tog korisnika. Dodaj ga u bazu.
				try
				{
					// Prvo pripremi insert naredbu.
					$st = $db->prepare( 'INSERT INTO dz2_users (username, password_hash) VALUES (:username, :hash)' );

					// Napravi hash od passworda kojeg je unio user.
					$hash = password_hash( $_POST["password"], PASSWORD_DEFAULT );

					// Izvrši sad tu insert naredbu. Uočite da u bazu stavljamo hash, a ne $_POST["password"]!
					$st->execute( array( 'username' => $_POST["username"], 'hash' => $hash ) );
				}
				catch( PDOException $e ) { crtaj_loginForma( 'Greška:' . $e->getMessage() ); return; }

				// Sad ponovno nacrtaj login formu, tako da se user proba ulogirati.
				$this->registry->template->message = 'Novi korisnik je uspješno dodan!';
				$this->registry->template->show( 'login_index' );
				exit();
			}
		}
	}
}; 

?>
