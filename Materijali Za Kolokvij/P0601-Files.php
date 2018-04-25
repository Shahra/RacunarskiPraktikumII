<?php
/*$f = fopen('proba.txt', 'w');
$dbl = 3.14; 
$str = 'Pero'; 
fprintf($f, 'Broj: %5.2f, string: %s\n', $dbl, $str);*/

$f = fopen( 'proba.txt', 'r' );
/*while($userinfo = fscanf($f, "%s")){
    print_r($userinfo);
}*/
/*while($line = fgets($f)){
    print_r($line);
}*/
//Ucitavanje cijele datoteke u string
$cijelaDatoteka = file_get_contents('proba.txt');
//Sa readfile($filename) se ispisuje sadraj cijele datoteke.
//Ovo je efikasnije nego uèitati u string pa ispisati sa echo.
echo __DIR__.'/../../proba.php';
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8" />
	<title>Zadatak 1</title>
</head>
<body>
</body>
</html>