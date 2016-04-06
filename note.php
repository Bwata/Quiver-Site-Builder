<!DOCTYPE html>
<html>
<head>
    <title><?= $metaTree['current notebook']['current note']['name'] ?></title>
</head>
<body>
<a href="/"><h1>Site Title</h1></a>
<nav>
    <?php
        foreach ($metaTree['notebooks'] as $notebook) { ?>
            <a href="/<?= to_url_friendly($notebook['name']); ?>"><?= $notebook['name']; ?></a>
            <?php
        }
     ?>
</nav>
<h2><?= $metaTree['current notebook']['name']; ?></h2>
<h2><?= $metaTree['current notebook']['current note']['name']; ?></h2>
<aside>
<?php

foreach ($metaTree['current notebook']['notes'] as $note) {
    ?>
        <a href="/<?= to_url_friendly($metaTree['current notebook']['name']); ?>/<?= to_url_friendly($note['title']); ?>"><h3><?= $note['title']; ?></h3></a>
    <?php
}
?>
</aside>
<main>
<?php 
  // print_r($metaTree['current notebook']['current note']['content']);
  // echo "<br><br>";

foreach ($metaTree['current notebook']['current note']['content']['cells'] as $noteSection) {
  $formaterFunction = "format_" . $noteSection['type'];
  echo $formaterFunction($noteSection);
}

 ?>
</main>

</body>
</html>