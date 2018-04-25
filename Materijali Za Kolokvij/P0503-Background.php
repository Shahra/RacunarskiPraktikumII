<?php
/*echo '<pre>';
print_r($_POST);
echo '<pre>';*/

function isValidColourHex($colour){
    return preg_match('/^\#([0-9a-zA-Z]{3}|[0-9a-zA-Z]{6})$/', $colour);	
}

$backgroundColour = 'white';

if(isset($_COOKIE['backgroundColour'])){
    $backgroundColour = $_COOKIE['backgroundColour'];
}
if(isset($_POST['backgroundColourTextbox']) && isValidColourHex($_POST['backgroundColourTextbox'])){
    $backgroundColour = $_POST['backgroundColourTextbox'];
}
else if(isset($_POST['backgroundColourCombobox']) && $_POST['backgroundColourCombobox'] !== ''){
    $backgroundColour = $_POST['backgroundColourCombobox'];
}
setcookie('backgroundColour' , $backgroundColour, time() + 123456);
//Vidi se samo kod inspecta.
//echo htmlentities($_POST['backgroundColourTextbox'], ENT_QUOTES);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8" />
	<title>Zadatak 1</title>
    <style>body { background-color: <?php echo $backgroundColour;?>; }</style>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post" accept-charset="UTF-8">
		<h2>Forma za mijenjanje boje pozadine</h2>
        <br>
        Boja pozadine(kod, mora poceti sa #): <input type="text" id="backgroundColourTextbox" name="backgroundColourTextbox">
		<br>
        Boja pozadine(ako se ne unese nista gore):
        <select name="backgroundColourCombobox" id="backgroundColourCombobox">
			<option selected="selected" value="green">Zelena</option>
			<option value="yellow">Zuta</option>
			<option value="blue">Plava</option>
			<option value="red">Crvena</option>
		</select>
		<br>
        <button name="changeBackgroundButton" type="submit">Promijeni boju pozadine!</button>
	</form>
</body>
</html>