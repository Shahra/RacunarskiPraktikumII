<!DOCTYPE html>
<html lang="hr">
<head></head>

<?php
    //Overloadanje funkcija nije podrzano.
    function foo($x = 3){
        echo 'FOOOOOO<br>';
        $x += 1;
        return $x;
    }
    function bar(&$x){
        $x += 1;
        return $x;
    }
    function globalTest(){
        global $z;
        $z = 'VarijablaZ';
    }
?>

<body>
    <?php
        $x = 0;
        echo fOO($x).'<br>';
        echo $x.'<br>';
        echo bar($x).'<br>';
        echo $x.'<br>';
        globalTest();
        echo $z.'<br>';
    ?>  
</body>
</html>

