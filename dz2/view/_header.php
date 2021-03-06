<?php
    if (!ValidationService::loggedIn()){
        header('Location: ' . __SITE_URL . '/index.php?rt=login/index');
        exit();
    }
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Quack Application</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
	<h1><?php echo $title; ?></h1>

	<nav>
        <ul>
            <li><a href="<?php echo __SITE_URL; ?>/index.php?rt=quack/myQuacks">My quacks</a></li>
            <li><a href="<?php echo __SITE_URL; ?>/index.php?rt=quack/quacksFromFollowees">Following</a></li>
            <li><a href="<?php echo __SITE_URL; ?>/index.php?rt=quack/followers">Followers</a></li>
            <li><a href="<?php echo __SITE_URL; ?>/index.php?rt=quack/quacksWhereMyUsernameAppears">Quacks <?php echo '@' . $_SESSION['username'] ?></a></li>
            <li><a href="<?php echo __SITE_URL; ?>/index.php?rt=quack/search">#search</a></li>
            <li><a href="<?php echo __SITE_URL; ?>/index.php?rt=login/logout">Logout</a></li>
        </ul>
	</nav>
