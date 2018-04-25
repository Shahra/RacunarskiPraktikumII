<?php
session_start();

if(isset($_POST['ime'])){
    if(preg_match('/^[a-zA-Z]{3,20}$/', $_POST['ime'])){
        $_SESSION['ime'] = $_POST['ime'];
    }
    else{
        header('Location: P0504-Index.php');
        exit;
    }
}

if(!isset($_SESSION['ime']) || !isset($_SESSION['broj'])){
    header('Location:P0504-Index.php');
    exit;
}

$ime = $_SESSION['ime'];
$zamisljeniBroj = (int) $_SESSION['broj'];
$brojPokusaja = $_SESSION['brojPokusaja'];

$error = false;
$errorMessage = '';
unset($pokusaj);
if(isset($_POST['pokusaj'])){
    $options = array( 'options' => array( 'min_range' => 1, 'max_range' => 100));
    if(filter_var($_POST['pokusaj'], FILTER_VALIDATE_INT, $options) === false){
        $error = true;
        $errorMessage = 'Trebas unijeti broj izmedu 1 i 100.';
    }
    else{
        $pokusaj = (int)$_POST['pokusaj'];
        ++$brojPokusaja;
        $_SESSION['brojPokusaja'] = $brojPokusaja;
    }
}

$pogodio = false;
$pogodioMessage = '';
if(isset($pokusaj)){
    if($pokusaj === $zamisljeniBroj){
        $pogodio = true;
    }
    else if($pokusaj < $zamisljeniBroj){
        $pogodioMessage = 'Zamisljeni broj je veci od '.$pokusaj.'!';
    }
    else{
        $pogodioMessage = 'Zamisljeni broj je manji od '.$pokusaj.'!';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Zadatak 3 - pogodi</title>
</head>
<body>
	<p>
		Dobro dosao, <?php echo htmlentities($ime, ENT_QUOTES); ?>!
	</p>
	<p>
		<?php 	
			if($error){
				echo htmlentities( $errorMessage, ENT_QUOTES );
            }
			else if( $pogodio )
			{
				echo 'Bravo! Pogodio si iz ' . $brojPokusaja . ' pokusaja!';
				// Završavamo sesiju.
				session_unset();
				session_destroy();
			}
			else{
				echo htmlentities( $pogodioMessage, ENT_QUOTES );
            }
		?>
	</p>

	<br />
	<?php 
		if( !$pogodio )
		{ 
			?>
			<form method="post" action="P0504-Pogodi.php">
				<label for="pokusaj">
					Pokusaj pogoditi broj izmedu 1 i 100 kojeg sam zamislio:
				</label>
				<input type="text" id="pokusaj" name="pokusaj" />
				<button type="submit">Pogodi!</button>
			</form>
			<?php 
		}
	?>
</body>
</html> 



