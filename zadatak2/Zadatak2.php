<?php

  echo '<pre>';
  print_r($_POST);
  echo '</pre>';

  if(isset($_POST['textBoxColor']) && $_POST['textBoxColor'] !== ''){
    $bojaPozadine = $_POST['textBoxColor'];
  }
  elseif (isset($_POST['selectColor'])) {
    $bojaPozadine = $_POST['selectColor'];
  }
  if(isset($_POST['btnResetiraj'])){
    $bojaPozadine = 'white';
  }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Zadatak 1</title>
  <style type="text/css">
    body {
      background-color: <?php echo $bojaPozadine; ?>
    }
  </style>
</head>
<body>
	<form method="post" action="Zadatak2.php">
		Unesi HTML kod boje pozadine (pocinje sa #):
    <input type="text" name ="textBoxColor" />
    <br/>

		Odaberi neku boju iz padajuceg izbornika:
		<select name="selectColor">
      <option value="blue">Plava</option>
			<option value="red">Crvena</option>
      <option value="green">Zelena</option>
			<option value="yellow">Zuta</option>
		</select>
		<br/>
		<button type="submit" name="btnPromijeni">Promijeni boju!</button>
    <button type="submit" name="btnResetiraj">Resetiraj na bijelu!</button>
	</form>
</body>
</html>
