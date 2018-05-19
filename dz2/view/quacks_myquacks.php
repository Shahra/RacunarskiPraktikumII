<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=quack/processSubmit">
    Quack:
    </br>
    <textarea id="quack" name="quack" rows="10" cols="50" maxlength="140" placeholder="Type your quack here..."></textarea>
    </br>
    <button type="submit" name="action" value="Submit">Submit</button>
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
