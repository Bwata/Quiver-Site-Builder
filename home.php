<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<a href="/"><h1>Site Title</h1></a>
<nav>
    <?php
        foreach ($metaTree['notebooks'] as $notebook) {
            ?>
            <a href="/<?= to_url_friendly($notebook['name']); ?>"><?= $notebook['name']; ?></a>
            <?php
        }
     ?>
</nav>
<?php

foreach ($metaTree['notebooks'] as $notebook) {
    ?>
    <h3><?= $notebook['name'] ?></h3>
    <h5><?= $notebook['note_count'] ?> notes</h5>
    <?php
}
?>
</body>
</html>