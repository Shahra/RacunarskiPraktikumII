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
			<title>Pogaðanje brojeva - Dobro došli!</title>
		</head>
		<body>
			<form method="post" action="<?php echo htmlentities( $_SERVER['PHP_SELF']); ?>">
				Unesite svoje ime: <input type="text" name="imeIgraca" />
				<button type="submit">Pošalji!</button>
			</form>

			<?php if( $this->errorMsg !== false ) echo '<p>Greška: ' . htmlentities( $this->errorMsg ) . '</p>'; ?>
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
			<title>Pogaðanje brojeva - Probaj pogoditi!</title>
		</head>
		<body>
			<p>
				Dobro došao, <?php echo htmlentities( $this->imeIgraca ); ?>!
				<br />
				<?php if( $prethodniPokusaj === PogodiBroj::ZAMISLJENI_JE_VECI  ) echo 'Moj broj je veæi!<br />' ?>
				<?php if( $prethodniPokusaj === PogodiBroj::ZAMISLJENI_JE_MANJI ) echo 'Moj broj je manji!<br />' ?>
			</p>

			<form method="post" action="<?php echo htmlentities( $_SERVER['PHP_SELF']); ?>">
				Koji broj izmeðu 1 i 100 sam zamislio? 
				<br />
				Pokušaj #<?php echo $this->brojPokusaja; ?>:
				<input type="text" name="pokusaj" />
				<button type="submit">Pogodi!</button>
			</form>

			<?php if( $this->errorMsg !== false ) echo '<p>Greška: ' . htmlentities( $this->errorMsg ) . '</p>'; ?>
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
			<title>Pogaðanje brojeva - Bravo!</title>
		</head>
		<body>
			<p>
				Bravo, <?php echo htmlentities( $this->imeIgraca ); ?>!
				<br />
				Pogodio si moj zamišljeni broj <?php echo $this->zamisljeniBroj; ?> 
				u samo <?php echo $this->brojPokusaja; ?> pokušaja!
			</p>
		</body>
		</html>

		<?php
	}
    
	function get_imeIgraca()
	{
		// Je li veæ definirano ime igraèa?
		if( $this->imeIgraca !== false )
			return $this->imeIgraca;

		// Možda nam se upravo sad šalje ime igraèa?
		if( isset( $_POST['imeIgraca'] ) )
		{
			// Šalje nam se ime igraèa. Provjeri da li se sastoji samo od slova.
			if( !preg_match( '/^[a-zA-Z]{1,20}$/', $_POST['imeIgraca'] ) )
			{
				// Nije dobro ime. Dakle nemamo ime igraèa.
				$this->errorMsg = 'Ime igraèa treba imati izmeðu 1 i 20 slova.';
				return false;
			}
			else
			{
				// Dobro je ime. Spremi ga u objekt.
				$this->imeIgraca = $_POST['imeIgraca'];
				return $this->imeIgraca;
			}
		}

		// Ne šalje nam se sad ime. Dakle nemamo ga uopæe.
		return false;
	}

	function obradiPokusaj()
	{
		// Vraæa false ako nije bio pokušaj pogaðanja, ili je bio neispravan pokušaj pogaðanja.
		// Inaèe, vraæa 0 ako su brojevi isti, 1 ako je pokušaj > zamišljeni broj, -1 ako je pokušaj < zamišljeni broj.

		// Da li je igraè uopæe pokusao pogaðati broj?
		if( isset( $_POST['pokusaj'] ) )
		{
			// Je. Da li je pokušaj broj izmeðu 1 i 100?
			$options = array( 'options' => array( 'min_range' => 1, 'max_range' => 100 ) );

			if( filter_var( $_POST['pokusaj'], FILTER_VALIDATE_INT, $options ) === false )
			{
				// Nije unesen broj izmeðu 1 i 100.
				$this->errorMsg = 'Trebate unijeti broj izmeðu 1 i 100.';
				return false;
			}
			else
				$pokusaj = (int) $_POST['pokusaj'];

			// Ispravan je pokušaj. Je li veæi/manji/isti kao zamišljeni broj?
			if( $pokusaj === $this->zamisljeniBroj )
				return PogodiBroj::ZAMISLJENI_JE_ISTI;
			else if( $pokusaj < $this->zamisljeniBroj )
				return PogodiBroj::ZAMISLJENI_JE_VECI;
			else
				return PogodiBroj::ZAMISLJENI_JE_MANJI;
		}

		// Igraè nije pokušao pogoditi broj.
		return false;
	}


	function isGameOver() { return $this->gameOver; }


	function run()
	{
		// Funkcija obavlja "jedan potez" u igri.
		// Prvo, resetiraj poruke o greški.
		$this->errorMsg = false;

		// Prvo provjeri jel imamo uopæe ime igraca
		if( $this->get_imeIgraca() === false )
		{
			// Ako nemamo ime igraèa, ispiši formu za unos imena i to je kraj.
			$this->ispisiFormuZaIme();
			return;
		}

		// Dakle imamo ime igraèa.
		// Ako je igraè pokušao pogoditi broj, provjerimo što se dogodilo s tim pokušajem.
		$rez = $this->obradiPokusaj();

		if( $rez === PogodiBroj::ZAMISLJENI_JE_ISTI )
		{
			// Ako je igraè pogodio, ispiši mu èestitku.
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
// Sad ide "glavni program" -- skroz generièki, isti za svaku moguæu igru.

// U $_SESSION æemo èuvati cijeli objekt tipa PogodiBroj.
// U tom sluèaju definicija klase treba biti PRIJE session_start();
session_start();

if( !isset( $_SESSION['igra'] ) )
{
	// Ako igra još nije zapoèela, stvori novi objekt tipa PogodiBroj i spremi ga u $_SESSION
	$igra = new PogodiBroj();
	$_SESSION['igra'] = $igra;
}
else
{
	// Ako je igra veæ ranije zapoèela, dohvati ju iz $_SESSION-a	
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
	// Igra još nije gotova -> spremi trenutno stanje u SESSION
	$_SESSION['igra'] = $igra;	
}
