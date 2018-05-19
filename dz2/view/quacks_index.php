<?php require_once __SITE_PATH . '/view/_header.php'; ?>

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
