<?php
abstract class Lik{
    public $ime = 'Lik';
    function __construct(){
        echo 'Lik::__con<br>';
    }
    abstract protected function opseg();
};

class Kvadrat extends Lik{
    private $x;
    function __construct($x){
        parent::__construct();
        echo 'Kvadrat::__con<br>';
        $this->x = $x;
    }
    function opseg(){
        return 4 * $this->x;
    }
}

interface iIzmjeriv{
    function opseg();
}

class Pravokutnik implements iIzmjeriv{
    private $a, $b;
    function __construct($a, $b){
        echo 'Kvadrat::__con'.'<br>';
        $this->a = $a;
        $this->b = $b;
    }
    function opseg(){
        return 2 * $this->a + 2 * $this->b;
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
        $k = new Kvadrat(5);
        echo $k->opseg().'<br>';
        echo $k->ime.'<br>';
        $p = new Pravokutnik(2, 4);
        echo $p->opseg().'<br>';
    ?>
</body>
</html>