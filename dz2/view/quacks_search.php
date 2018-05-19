<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=quack/searchResults">
    Search criteria:
    <input type="text" name="criteria" />
    <button type="submit" name="action" value="search">Search</button>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
