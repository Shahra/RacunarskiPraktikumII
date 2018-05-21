<?php 

class LoginController extends BaseController
{
	public function index() 
	{
		if(ValidationService::loggedIn()){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/myQuacks' );
			exit();
		}

		$this->registry->template->message = '';
		$this->registry->template->show( 'login_index' );
	}

	public function processLogin()
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$ls = new LoginService();

		if( !isset( $_POST['username'] ) || !isset( $_POST['password'] ) ){
			$this->registry->template->message = 'Trebate unijeti korisničko ime i lozinku.';
			$this->registry->template->show( 'login_index' );
			exit();
		}
		if(!ValidationService::isUsernameValid($_POST['username']))
		{
			$this->registry->template->message = 'Korisničko ime treba imati između 3 i 10 slova.';
			$this->registry->template->show( 'login_index' );
			exit();
		}
		$user = $ls->getUserFromDatabase($_POST['username']);
		if($user === false){
			$this->registry->template->message = 'Korisnik s tim imenom ne postoji.';
			$this->registry->template->show( 'login_index' );
			exit();
		}
		else if($user->has_registered == 0){
			$this->registry->template->message = 'Korisnik s tim imenom se nije još registrirao. Provjerite e-mail.';
			$this->registry->template->show( 'login_index' );
			exit();
		}
		else if(!password_verify( $_POST['password'], $user->password_hash ) )
		{
			$this->registry->template->message = 'Lozinka nije ispravna.';
			$this->registry->template->show( 'login_index' );
			exit();
		}
		else
		{
			echo 'radi';
			$_SESSION['username'] = $_POST['username'];
			header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/myQuacks' );
			exit();
		}
	}

	public function newUser(){

		if(ValidationService::loggedIn()){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/myQuacks' );
			exit();
		}

		$this->registry->template->message = '';
		$this->registry->template->show( 'login_novi' );

	}

	public function processNewUser(){
		$ls = new LoginService();

		if( !isset( $_POST['username'] ) || !isset( $_POST['password'] ) || !isset( $_POST['email'] ) )
		{
			$this->registry->template->message = 'Trebate unijeti korisničko ime, lozinku i e-mail adresu.';
			$this->registry->template->show( 'login_novi' );
			exit();
		}
		if(!ValidationService::isUsernameValid($_POST['username'])){
			$this->registry->template->message = 'Korisničko ime treba imati između 3 i 10 slova.';
			$this->registry->template->show( 'login_novi' );
			exit();
		}
		else if( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
		{
			$this->registry->template->message = 'E-mail adresa nije ispravna.';
			$this->registry->template->show( 'login_novi' );
			exit();
		}
		else{
			$user = $ls->getUserFromDatabase($_POST['username']);
			if($user !== false){
				$this->registry->template->message = 'Korisnik s tim imenom već postoji u bazi.';
				$this->registry->template->show( 'login_novi' );
				exit();
			}
			$ls->sendRegistrationRequest(LoginService::generateRegistrationSequence());
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
			exit();

		}

		DebugService::showSession();
		DebugService::showPost();
		exit();

	}

	public function confirmRegistration(){
		$ls = new LoginService();
		if(!isset( $_GET['code'] )){
			$this->registry->template->message = 'Nije validan registracijski kod.';
			$this->registry->template->show( 'login_novi' );
			exit();
		}

		$user = $ls->getUserFromDatabaseWithRegSeq($_GET['code']);

		if($user === false){
			$this->registry->template->message = 'Nije validan registracijski kod.';
			$this->registry->template->show( 'login_novi' );
			exit();
		}
		else{
			$ls->registerUser($user->username);
			$this->registry->template->show( 'login_requestSent' );
			exit();
		}
	}

	public function logout(){
		session_start();
		session_destroy();
		header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
	}


	/*
	public function processLogin()
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

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
					header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/myQuacks' );
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
	}*/
}; 

?>
