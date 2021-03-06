<!DOCTYPE html>
<html>
<head>
    <title><?= $metaTree['current notebook']['name'] ?></title>
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
<main>
<?php

// stdClass Object ( [created_at] => 1459878459 [tags] => Array ( ) [title] => First Note [updated_at] => 1459878473 [uuid] => 8273B209-4117-4AD2-BD99-0B4E0FF8F321 ) ) ) ) )

foreach ($metaTree['current notebook']['notes'] as $note) {
    ?>
    <section>
        <a href="/<?= to_url_friendly($metaTree['current notebook']['name']); ?>/<?= to_url_friendly($note['title']); ?>"><h3><?= $note['title']; ?></h3></a>
        <dl>
          <dt>Created At</dt>
          <dd><?= $note['created_at']; ?></dd>
          <dt>Updated At</dt>
          <dd><?= $note['updated_at']; ?></dd>
          <dt>Tags</dt>
          <dd><?= implode(", ", $note['tags']); ?></dd>
        </dl>
    </section>
    <?php
}
?>
</main>

</body>
</html>