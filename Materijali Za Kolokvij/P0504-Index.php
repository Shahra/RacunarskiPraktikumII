<?php

session_start();
//session_unset();
//session_destroy();

if(!isset($_SESSION['broj'])){
    $_SESSION['broj'] = rand(1, 100);
    $_SESSION['brojPokusaja'] = 0;
}

if(isset($_SESSION['ime'])){
    header('Location: P0504-Pogodi.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Zadatak 3 - index</title>
</head>
<body>
<form action="P0504-Pogodi.php" method="post">
	<label for="ime">Unesite svoje ime (izmedu 3 i 20 slova):</label>
	<input type="text" id="ime" name="ime" />
	<br />
	<button type="submit">Posalji</button>
</form> 	
</body>
</html> 
