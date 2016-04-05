<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->get("/", function() {
    $docroot = $_SERVER['DOCUMENT_ROOT'];
    $mainMeta = json_decode(file_get_contents($docroot . "/quiver/main.qvnotebook/meta.json"));
    print_r($mainMeta->name);
});

$app->run();