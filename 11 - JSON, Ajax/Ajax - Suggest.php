<?php
$imena = [ "Ana", "Ante", "Boris", "Maja", "Marko", "Mirko", "Slavko", "Slavica" ];
$unos = $_GET[ "unos" ];

// Protrči kroz sva imena i vrati HTML kod <option> za samo ona 
// koja sadrže string q kao podstring.
foreach( $imena as $ime ) {
    if( strpos( $ime, $unos ) !== false ) {
        echo "<option value='" . $ime . "' />\n";
		}
}
?>
