<?php
$user = 'root'; 
$pass = '';

try {
    $db = new PDO('mysql:host=localhost;dbname=mysql;charset=utf8', $user, $pass);
} catch(PDOException $e) {
    echo "Greška: " . $e->getMessage(); exit();
}
//$st = $db->prepare("INSERT INTO studenti(JMBAG, Ime, Prezime, Ocjena) VALUES(:jmbag, :ime, :prezime, :ocjena)");
//$st->execute(array('jmbag' => '144444442','ime' => 'Darija', 'prezime' => 'Srnic', 'ocjena' => '2'));
//$db->query("INSERT INTO studenti(JMBAG, Ime, Prezime, Ocjena) VALUES('12345678911', 'Darija', 'Srnic', 5)");
//echo $st->rowCount().'<br>';

$st = $db->query( 'SELECT JMBAG, Ime, Prezime FROM Studenti' );
foreach($st->fetchAll() as $row){
    echo "JMBAG = ".$row['JMBAG']." Ime = " .$row['Ime']." Prezime = ".$row[ "Prezime" ]."<br/>";
}
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