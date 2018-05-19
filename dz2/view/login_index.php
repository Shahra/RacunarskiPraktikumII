<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8" />
	<title>Login</title>
</head>
<body>
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=login/processLogin">
		Korisničko ime: 
		<input type="text" name="username" />
		<br />
		Password:
		<input type="password" name="password" />
		<br />
		<button type="submit" name="gumb" value="login">Ulogiraj se!</button>
		<button type="submit" name="gumb" value="novi">Stvori novog korisnika!</button>
	</form>
	<?php echo $message; ?>
</body>
</html>
