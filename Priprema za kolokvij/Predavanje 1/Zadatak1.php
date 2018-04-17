<!DOCTYPE html>
<html lang="hr">
<head>Naslov</head>
<body>
	<p>
		<?php
			if(isset($_GET['username'])){
				echo "Hello, ".$_GET['username']."!";
			}
			else{
				echo "Hello, guest!";
			}
		?>
	</p>
</body>
</html>