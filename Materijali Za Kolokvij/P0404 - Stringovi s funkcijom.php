<?php
/**
 * @author 
 * @copyright 2018
 */
 $n = 10;
 $k = 5;
 function my_sort(&$array){
    $n = count($array);
    for($i = 0; $i < $n - 1; $i++){
        for($j = $i + 1; $j < $n; $j++){
            if(strcmp($array[$i], $array[$j]) === 1){
                $temp = $array[$i];
                $array[$i] = $array[$j];
                $array[$j] = $temp;
            }
        }
    } 
 }
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Stringovi</title>
</head>
<body>		
    <?php
        $randomStrings = array();
        
        for($i = 0; $i < $n; $i++){
            $s = '';
            for($j = 0; $j < $k; $j++){
                $s .= chr(rand(ord('a'), ord('z'))); 
            }
            array_push($randomStrings, $s);
        }
        
        for($i = 0; $i < $n; $i++){
            echo $randomStrings[$i].'<br>';
        }
        
        echo '<br>';
        echo 'Sortiranje....<br><br>';
        my_sort($randomStrings);
        
        for($i = 0; $i < $n; $i++){
            echo $randomStrings[$i].'<br>';
        }
    ?>
</body>
</html>