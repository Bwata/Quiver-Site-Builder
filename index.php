<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


function parse_notebooks($directory) {
    $notebookFolders = glob($directory . '/*.qvnotebook' , GLOB_ONLYDIR);
    $metaTree = array('notebooks');
    foreach ($notebookFolders as $notebookFolder) {
        $mainMeta = json_decode(file_get_contents($notebookFolder . "/meta.json"));
        $notebookMeta = array("name" => $mainMeta->name, 'notes' => array());

        $noteFolders = glob($notebookFolder . '/*.qvnote' , GLOB_ONLYDIR);
        foreach ($noteFolders as $noteFolder) {
            $noteMeta = json_decode(file_get_contents($noteFolder . "/meta.json"));
            $notebookMeta['notes'][] = $noteMeta;
        }
        $metaTree['notebooks'][] = $notebookMeta;
    }
    // print_r($metaTree);
    return $metaTree;
}

function parse_notes($directory) {

}


$app->get("/", function() {
    $quiverLibrary = $_SERVER['DOCUMENT_ROOT'] . "/Quiver.qvlibrary";
    $metaTree = parse_notebooks($quiverLibrary);
    include_once "home.php";
});

$app->get("/:notebookPage", function($notebookPage) {
    $quiverLibrary = $_SERVER['DOCUMENT_ROOT'] . "/Quiver.qvlibrary";
    $metaTree = parse_notebooks($quiverLibrary);
    include_once "notebook.php";
});


// PAGES
// /tags/:tag
// /:notebook/:note
// /:notebook

// eventually
// search






$app->run();
