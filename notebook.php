<!DOCTYPE html>
<html>
<head>
    <title><?= $notebookPage ?></title>
</head>
<body>
<h1>Site Title</h1>
<nav>
    <?php 
        foreach ($metaTree['notebooks'] as $notebook) {
            if (strtolower($notebook['name']) == strtolower($notebookPage)) {
                $pageNotebook = $notebook;
            }
            ?>
            <a href="/<?= strtolower($notebook['name']); ?>"><?= $notebook['name']; ?></a>
            <?php
        }
     ?>
</nav>
<h2><?= $notebookPage; ?></h2>
<main>
<?php

// stdClass Object ( [created_at] => 1459878459 [tags] => Array ( ) [title] => First Note [updated_at] => 1459878473 [uuid] => 8273B209-4117-4AD2-BD99-0B4E0FF8F321 ) ) ) ) )

foreach ($pageNotebook['notes'] as $note) {
    ?>
    <section>
        <h3><?= $note->title; ?></h3>
        <dl>
          <dt>Created At</dt>
          <dd><?= $note->created_at; ?></dd>
          <dt>Updated At</dt>
          <dd><?= $note->updated_at; ?></dd>
          <dt>Tags</dt>
          <dd><?= implode(", ", $note->tags); ?></dd>
        </dl>
    </section>
    <?php
}
?>
</main>

</body>
</html>