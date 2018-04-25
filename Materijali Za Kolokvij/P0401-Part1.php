<!DOCTYPE html>
<html lang="hr">
<head></head>
<body>
    <?php
        /**
         * @zdjuric 
         * @copyright 2018
        */
        echo "<p>Hello World!</p>";
        $x = 7;
        echo ($x + 1)."<br>";
        echo isset($x)." prints 1 <br>";
        unset($x);
        //echo ($x + 1)."<br>"; 
        echo isset($x)." prints None<br>";
        echo (boolean)""." ". (boolean)"a"."<br>";
        $i1 = 25;
        $i2 = 8;
        echo (integer)($i1 / $i2)."<br>";
        //null je case insensitive
        if(nuLl === NuLL){
            echo 'null === NULL';
        }
        else{
            echo 'null === NULL';
        }
    ?>  
    <?php
    for( $i = 0; $i < 5; ++$i ) { ?>
        <p>Hello, <?php echo $i; ?>!</p>
        <?php
    }
    ?>
    <br>
    <br>
    <?php
        $polje = array(6, 3, 7, 9);
        print_r($polje);
        //Bez & se ne bi promijenila vrijednost nego bi se promjene
        //radile na kopiji niza.
        foreach($polje as &$val){
            $val = 2 * $val;
        }
        echo '<br>';
        print_r($polje);
    ?>
</body>
</html>

