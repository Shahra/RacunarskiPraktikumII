<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table>
	<tr><th>Followers</th></tr>
	<?php
		foreach ($followers as $follower) {
			echo '<tr>' .
				'<td>' . $follower . '</td>' .
				'</tr>';
		}
	?>
</table>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
