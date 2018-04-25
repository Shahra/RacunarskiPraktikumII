<?php
$fileName = 'users.txt';

if( !file_exists($fileName) || ($fileContent = file_get_contents( $fileName )) === false ){
	$popis = array();
}
else{
	$popis = explode(',', $fileContent); 
}

if(isset($_POST['ime']) && preg_match('/^[a-zA-Z]{1,20}$/', $_POST['ime'])){
	$len = count( $popis );
	$popis[$len] = $_POST['ime'];
    
	if( $len >= 5 ){
		unset( $popis[0] );
    }
    $str = implode( ',', $popis );

	if( file_put_contents( $fileName, $str ) === false ){
		exit( 'Ne mogu pisati u datoteku users.txt' );
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8" />
	<title>Zadatak 1</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post" accept-charset="UTF-8">
		<h2>Unesi ime forma!</h2>
        <br/>
        Unesi ime: <input type="text" id="ime" name="ime">
		<br/>
        <button type="submit">Posalji!</button>
	</form>
    <p>
        Popis zadnjih max. 5 korisnika:
        <?php
            foreach($popis as $ime){
                echo '<li>'.$ime.'</li>';
            }
        ?>
    </p>
</body>
</html>