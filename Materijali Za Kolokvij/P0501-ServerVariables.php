<!DOCTYPE html>
<html lang="hr">
<head></head>
<body>
    <?php
        echo 'P0501.php<br>';
        echo 'PHP_SELF: '.$_SERVER['PHP_SELF'].'<br>';
        echo 'SERVER_ADDR: '.$_SERVER['SERVER_ADDR'].'<br>';
        echo 'SERVER_NAME: '.$_SERVER['SERVER_NAME'].'<br>';
        echo 'REQUEST_METHOD: '.$_SERVER['REQUEST_METHOD'].'<br>';
        echo 'DOCUMENT_ROOT: '.$_SERVER['DOCUMENT_ROOT'].'<br>';
        echo 'REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR'].'<br>';
        echo 'REQUEST_URI: '.$_SERVER['REQUEST_URI'].'<br>';
        echo '<pre>';
            print_r( $_SERVER );
        echo '</pre>';
    ?>
</body>
</html>