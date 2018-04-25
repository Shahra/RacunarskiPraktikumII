<?php 
class PogodiBroj
{
	protected $zamisljeniBroj, $imeIgraca, $brojPokusaja, $gameOver;
	protected $errorMsg;

	const ZAMISLJENI_JE_VECI = -1, ZAMISLJENI_JE_MANJI = 1, ZAMISLJENI_JE_ISTI = 0;

	function __construct()
	{
		$this->imeIgraca = false;
		$this->zamisljeniBroj = rand( 1, 100 );
		$this->brojPokusaja = 0;
		$this->gameOver = false;
		$this->errorMsg = false;
	}

	function ispisiFormuZaIme()
	{
		?>

		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<title>Poga�anje brojeva - Dobro do�li!</title>
		</head>
		<body>
			<form method="post" action="<?php echo htmlentities( $_SERVER['PHP_SELF']); ?>">
				Unesite svoje ime: <input type="text" name="imeIgraca" />
				<button type="submit">Po�alji!</button>
			</form>

			<?php if( $this->errorMsg !== false ) echo '<p>Gre�ka: ' . htmlentities( $this->errorMsg ) . '</p>'; ?>
		</body>
		</html>

		<?php
	}


	function ispisiFormuZaPogadjanjeBroja( $prethodniPokusaj )
	{
		++$this->brojPokusaja;

		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<title>Poga�anje brojeva - Probaj pogoditi!</title>
		</head>
		<body>
			<p>
				Dobro do�ao, <?php echo htmlentities( $this->imeIgraca ); ?>!
				<br />
				<?php if( $prethodniPokusaj === PogodiBroj::ZAMISLJENI_JE_VECI  ) echo 'Moj broj je ve�i!<br />' ?>
				<?php if( $prethodniPokusaj === PogodiBroj::ZAMISLJENI_JE_MANJI ) echo 'Moj broj je manji!<br />' ?>
			</p>

			<form method="post" action="<?php echo htmlentities( $_SERVER['PHP_SELF']); ?>">
				Koji broj izme�u 1 i 100 sam zamislio? 
				<br />
				Poku�aj #<?php echo $this->brojPokusaja; ?>:
				<input type="text" name="pokusaj" />
				<button type="submit">Pogodi!</button>
			</form>

			<?php if( $this->errorMsg !== false ) echo '<p>Gre�ka: ' . htmlentities( $this->errorMsg ) . '</p>'; ?>
		</body>
		</html>

		<?php
	}


	function ispisiCestitku()
	{
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<title>Poga�anje brojeva - Bravo!</title>
		</head>
		<body>
			<p>
				Bravo, <?php echo htmlentities( $this->imeIgraca ); ?>!
				<br />
				Pogodio si moj zami�ljeni broj <?php echo $this->zamisljeniBroj; ?> 
				u samo <?php echo $this->brojPokusaja; ?> poku�aja!
			</p>
		</body>
		</html>

		<?php
	}
    
	function get_imeIgraca()
	{
		// Je li ve� definirano ime igra�a?
		if( $this->imeIgraca !== false )
			return $this->imeIgraca;

		// Mo�da nam se upravo sad �alje ime igra�a?
		if( isset( $_POST['imeIgraca'] ) )
		{
			// �alje nam se ime igra�a. Provjeri da li se sastoji samo od slova.
			if( !preg_match( '/^[a-zA-Z]{1,20}$/', $_POST['imeIgraca'] ) )
			{
				// Nije dobro ime. Dakle nemamo ime igra�a.
				$this->errorMsg = 'Ime igra�a treba imati izme�u 1 i 20 slova.';
				return false;
			}
			else
			{
				// Dobro je ime. Spremi ga u objekt.
				$this->imeIgraca = $_POST['imeIgraca'];
				return $this->imeIgraca;
			}
		}

		// Ne �alje nam se sad ime. Dakle nemamo ga uop�e.
		return false;
	}

	function obradiPokusaj()
	{
		// Vra�a false ako nije bio poku�aj poga�anja, ili je bio neispravan poku�aj poga�anja.
		// Ina�e, vra�a 0 ako su brojevi isti, 1 ako je poku�aj > zami�ljeni broj, -1 ako je poku�aj < zami�ljeni broj.

		// Da li je igra� uop�e pokusao poga�ati broj?
		if( isset( $_POST['pokusaj'] ) )
		{
			// Je. Da li je poku�aj broj izme�u 1 i 100?
			$options = array( 'options' => array( 'min_range' => 1, 'max_range' => 100 ) );

			if( filter_var( $_POST['pokusaj'], FILTER_VALIDATE_INT, $options ) === false )
			{
				// Nije unesen broj izme�u 1 i 100.
				$this->errorMsg = 'Trebate unijeti broj izme�u 1 i 100.';
				return false;
			}
			else
				$pokusaj = (int) $_POST['pokusaj'];

			// Ispravan je poku�aj. Je li ve�i/manji/isti kao zami�ljeni broj?
			if( $pokusaj === $this->zamisljeniBroj )
				return PogodiBroj::ZAMISLJENI_JE_ISTI;
			else if( $pokusaj < $this->zamisljeniBroj )
				return PogodiBroj::ZAMISLJENI_JE_VECI;
			else
				return PogodiBroj::ZAMISLJENI_JE_MANJI;
		}

		// Igra� nije poku�ao pogoditi broj.
		return false;
	}


	function isGameOver() { return $this->gameOver; }


	function run()
	{
		// Funkcija obavlja "jedan potez" u igri.
		// Prvo, resetiraj poruke o gre�ki.
		$this->errorMsg = false;

		// Prvo provjeri jel imamo uop�e ime igraca
		if( $this->get_imeIgraca() === false )
		{
			// Ako nemamo ime igra�a, ispi�i formu za unos imena i to je kraj.
			$this->ispisiFormuZaIme();
			return;
		}

		// Dakle imamo ime igra�a.
		// Ako je igra� poku�ao pogoditi broj, provjerimo �to se dogodilo s tim poku�ajem.
		$rez = $this->obradiPokusaj();

		if( $rez === PogodiBroj::ZAMISLJENI_JE_ISTI )
		{
			// Ako je igra� pogodio, ispi�i mu �estitku.
			$this->ispisiCestitku();
			$this->gameOver = true;
		}
		else
			$this->ispisiFormuZaPogadjanjeBroja( $rez );
	}
};


// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// Sad ide "glavni program" -- skroz generi�ki, isti za svaku mogu�u igru.

// U $_SESSION �emo �uvati cijeli objekt tipa PogodiBroj.
// U tom slu�aju definicija klase treba biti PRIJE session_start();
session_start();

if( !isset( $_SESSION['igra'] ) )
{
	// Ako igra jo� nije zapo�ela, stvori novi objekt tipa PogodiBroj i spremi ga u $_SESSION
	$igra = new PogodiBroj();
	$_SESSION['igra'] = $igra;
}
else
{
	// Ako je igra ve� ranije zapo�ela, dohvati ju iz $_SESSION-a	
	$igra = $_SESSION['igra'];
}

// Izvedi jedan korak u igri, u kojoj god fazi ona bila.
$igra->run();

if( $igra->isGameOver() )
{
	// Kraj igre -> prekini session.
	session_unset();
	session_destroy();
}
else
{
	// Igra jo� nije gotova -> spremi trenutno stanje u SESSION
	$_SESSION['igra'] = $igra;	
}
