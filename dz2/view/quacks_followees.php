<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=quack/updateFollowees">
    Username osobe:
    <input type="text" name="username" />

    <button type="submit" name="action" value="follow">Follow</button>
    <button type="submit" name="action" value="unfollow">Unfollow</button>
</form>

</br>

<table>
	<tr><th>Date</th><th>Username</th><th>Quack</th></tr>
	<?php
		foreach ($quackList as $quack) {
			echo '<tr>' .
				'<td>' . $quack->date . '</td>' .
				'<td>' . $quack->username . '</td>' .
				'<td>' . $quack->quack . '</td>' .
				'</tr>';
		}
	?>
</table>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
