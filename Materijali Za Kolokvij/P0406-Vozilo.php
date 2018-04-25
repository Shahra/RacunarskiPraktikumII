<?php
interface iUpravljiv{
    function idiRavno($x);
    function skreniDesno();
    function skreniLijevo();
}

class Vozilo implements iUpravljiv{
    public $ime = 'Lik';
    public $smjer = 'N';
    public $x = 0;
    public $y = 0;
    
    function __construct($ime, $smjer = 'N', $x = 0, $y = 0){
        $this->ime = $ime;
        $this->smjer = $smjer;
        $this->x = $x;
        $this->y = $y;
    }
    
    function gdjeSam(){
        echo $this->x.' '.$this->y.'<br>';
    }
    
    function skreniLijevo(){
        if(strcmp($this->smjer, 'N') === 0){
            $this->smjer = 'W';
        }
        else if(strcmp($this->smjer, 'W') === 0){
            $this->smjer = 'S';
        }
        else if(strcmp($this->smjer, 'S') === 0){
            $this->smjer = 'E';
        }
        else{
            $this->smjer = 'N';
        }
    }
    
    function skreniDesno(){
        if(strcmp($this->smjer, 'N') === 0){
            $this->smjer = 'E';
        }
        else if(strcmp($this->smjer, 'E') === 0){
            $this->smjer = 'S';
        }
        else if(strcmp($this->smjer, 'S') === 0){
            $this->smjer = 'W';
        }
        else{
            $this->smjer = 'N';
        }
    }
    
    function idiRavno($x){
        if(strcmp($this->smjer, 'N') === 0){
            $this->y += $x;
        }
        else if(strcmp($this->smjer, 'W') === 0){
            $this->x -= $x;
        }
        else if(strcmp($this->smjer, 'S') === 0){
            $this->y -= $x;
        }
        else{
            $this->x += $x;
        } 
    }
};

class Auto extends Vozilo{
    public $potrosenBenzin = 0;
    
    function __construct($ime, $smjer = 'N', $x = 0, $y = 0){
        parent::__construct($ime, $smjer, $x, $y);
    }
    
    function idiRavno($x){
        parent::idiRavno($x);
        $this->potrosenBenzin += 10 * $x;
    }
    
    function potrosenBenzin(){
        return $this->potrosenBenzin;
    }
}

class Tramvaj extends Vozilo{
    public $linija;
    
    function __construct($ime, $linija, $smjer = 'N', $x = 0, $y = 0){
        $this->linija = $linija;
        parent::__construct($ime, $smjer, $x, $y);
    }
    
    function linija(){
        return $this->linija;
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
        
        $v = new Vozilo('Vozilo', 'N', 0, 5);
        $v->idiRavno(15);
        echo $v->ime.':'; $v->gdjeSam();
        $a = new Auto('Auto', 'W', 3, 5);
        $a->idiRavno(15);
        echo $a->ime.':'; $a->gdjeSam(); echo ' Potrosen benzin: '.$a->potrosenBenzin().'<br>';
        $t = new Tramvaj('Tramvaj', '17', 'E', 11, -5);
        $t->idiRavno(15);
        echo $t->ime.':'; $t->gdjeSam();
    ?>
</body>
</html>