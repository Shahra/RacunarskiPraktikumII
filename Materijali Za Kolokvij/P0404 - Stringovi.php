<?php
/**
 * @author 
 * @copyright 2018
 */
 $n = 10;
 $k = 5;
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
        
        /*
        for($i = 0; $i < $n - 1; $i++){
            for($j = $i + 1; $j < $n; $j++){
                if(strcmp($randomStrings[$i], $randomStrings[$j]) === 1){
                    $temp = $randomStrings[$i];
                    $randomStrings[$i] = $randomStrings[$j];
                    $randomStrings[$j] = $temp;
                }
            }
        }*/
        echo 'Sortiranje....<br><br>';
        sort($randomStrings);
        
        for($i = 0; $i < $n; $i++){
            echo $randomStrings[$i].'<br>';
        }
    ?>
</body>
</html>