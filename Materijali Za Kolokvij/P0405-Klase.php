<?php
class Test{
    private $data;
    public $msg = 'hello';
    static $info = 'info';
    
    function __construct($x){
        $this->data = $x;
    }
    function __destruct(){
        echo 'Destruktor!';
    }
    function getData(){
        return $this->data;
    }
}


function foo($x){
    $x->msg = 'o';
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
        $t = new Test(5);
        echo $t->msg;
        echo $t->getData();
        echo Test::$info;
        foo($t);
        echo $t->msg;
    ?>
</body>
</html>