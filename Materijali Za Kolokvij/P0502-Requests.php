<!DOCTYPE html>
<html lang="hr">
<head></head>
<body>
    <?php
        $vars = array( 'ime' => 'Pero' ,
        'starost' => '20' );
        $query_string = http_build_query( $vars );
        $url = '/skripta.php?' . $query_string;
        echo $url.'<br>';
        if( !isset( $_GET['ime'] ) ) {
            echo 'Trebate unijeti ime.';
            //exit( 'Trebate unijeti ime.' );
        }
        else{
            setcookie('boja' , $_GET['ime'], time() + 10);    
        }
        echo '<br>test';
        //echo $_COOKIE['boja'];
        
        //Uvijek treba provesti sanitizaciju (ukloniti "zabranjene" znakove iz podataka) 
        //i validaciju (provjeriti jesu li podaci u ispravnom obliku).
        if(isset($_COOKIE['boja'])){
            echo 'Tvoja boja je ' . $_COOKIE['boja'].'<br>';
        }
        
        setcookie('boja' , '' , 1);
        if(isset($_COOKIE['boja'])){
            echo 'Tvoja boja je ' . $_COOKIE['boja'];
        }
        else{
            echo 'radi!<br>';
        }
    ?>
</body>
</html>