<!DOCTYPE html>
<html lang="hr">
<head>Naslov</head>
<body>
	<form action="zadatak2.php" method="get">
		<h2>Naslov forme</h2>
		Ime: <input type="text" id="name" name="name" >
		<br>
		Sifra: <input type="password" id="password" name="password" >
		<br>
		Spol: 
		<input type="radio" name="gender" id="gender_male" value="male">M</input>
		<input type="radio" name="gender" id="gender_female" value="female">F</input>
		<br>
		Kontinent:
		<select name="cont" id="cont">
			<option selected="selected" disabled="disabled">Odaberite...</option>
			<option value="1">Afrika</option>
			<option value="2">Amerika</option>
			<option value="3">Antarktika</option>
			<option value="4">Azija</option>
			<option value="5">Europa</option>
			<option value="6">Australia</option>
		</select>
		<br>
		Jelo:
		<input type="checkbox" id="meal0" name="meals" value="dorucak">Dorucak</input>
		<input type="checkbox" id="meal1" name="meals" value="rucak">rucak</input>
		<input type="checkbox" id="meal2" name="meals" value="vecera">Vecera</input>
		<br>
		Napomena: <textarea id="napomena" name="napomena" rows="10" cols="50">Unesite tekst...</textarea>
		<br>
		<button name="buttonSubmit" type="submit">Pošalji</button>
		<button name="buttonCancel" type="reset">Odustani</button>
	</form>
</body>
</html>