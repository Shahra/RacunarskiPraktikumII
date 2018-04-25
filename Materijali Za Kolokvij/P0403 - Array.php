<?php
/**
 * @author 
 * @copyright 2018
 */
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Zadatak 1</title>
    <link rel="stylesheet" type="text/css" href="TableBorder.css">
</head>
<body>		
    <?php
        echo "Hello World!".'<br>';
        $polje = array(5, 6, 2, 8);
        for($i = 0; $i < 4; $i++){
            echo $polje[$i].'<br>';
        }
        
        $polje = array('bla' => 'foo', 2 => 'bar', 19 => 'oo');
        $polje['abc'] = 9;
        unset($polje[19]);
        foreach($polje as $key => $value){
            echo 'Na poziciji '.$key.' se nalazi vrijednost: '.$value.'<br>';
        }
    ?>
</body>
</html>