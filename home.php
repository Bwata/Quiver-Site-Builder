<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<h1>Site Title</h1>
<nav>
    <?php
        foreach ($metaTree['notebooks'] as $notebook) {
            ?>
            <a href="/<?= strtolower($notebook['name']); ?>"><?= $notebook['name']; ?></a>
            <?php
        }
     ?>
</nav>
<?php

foreach ($metaTree['notebooks'] as $notebook) {
    $noteCount = count($notebook['notes']);
    ?>
    <h3><?= $notebook['name'] ?></h3>
    <h5><?= $noteCount ?> notes</h5>
    <?php
}
?>
</body>
</html>