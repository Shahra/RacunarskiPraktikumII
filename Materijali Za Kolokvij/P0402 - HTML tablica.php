<?php
/**
 * @author 
 * @copyright 2018
 */
 $n = 50;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Zadatak 1</title>
    <link rel="stylesheet" type="text/css" href="TableBorder.css">
</head>
<body>		
    <table class="fixed">
        <tr>
        <?php
            echo '<th>*</th>';
            for($i = 1; $i <= $n; $i++){
                echo '<th>'.$i.'</th>';
            }
        ?>
        </tr>
        <?php
            for($i = 1; $i <= $n; $i++){
                echo '<tr>';
                echo '<th>'.$i.'</th>';
                for($j = 1; $j <= $n; $j++){
                    echo '<td>'.$i * $j.'</td>';
                }
                echo '</tr>';
            }
        ?>
    </table>
</body>
</html>