<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

function mb_str_split($string, $split_length = 1){

    mb_internal_encoding('UTF-8');
    mb_regex_encoding('UTF-8');

    $split_length = ($split_length <= 0) ? 1 : $split_length;

    $mb_strlen = mb_strlen($string, 'utf-8');

    $array = array();

    for($i = 0; $i < $mb_strlen; $i = $i + $split_length){
        $array[] = mb_substr($string, $i, $split_length);

    }

    return $array;

}

function to_url_friendly($str) {
    //this is basically the same as make_nice_url in adminFunctions.js.
    $str = trim($str); // trim

    // remove accents, swap ñ for n, etc
    $from = "ÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛàáäâèéëêìíïîòóöôùúüûÑñÇç·/_,:;&";
    $to   = "aaaaeeeeiiiioooouuuuaaaaeeeeiiiioooouuuunncc-------";

    $str = strip_tags($str); // strip html tags from string
    $str = strip_tags($str); // strip html tags from string
    $str = str_replace(mb_str_split($from), str_split($to), $str);
    $str = preg_replace('/[^a-zA-Z0-9 -]/', '', $str); // remove invalid chars
    $str = preg_replace('/\s+/', '-', $str); // collapse whitespace and replace by -
    $str = preg_replace("/-+/u", "-", $str); // remove any double/triple/etc-dashes with a single dash
    $str = rtrim($str, '-'); // remove any trailing - [dashes]
    $str = strtolower($str);
    return $str;
}


/**
 * Parse through the library to gather all the meta data.
 * Also gathers up some other data along the way.
 * @param  string $path         directory path of library
 * @param  string $notebook     url name of notebook
 * @return array                tree of the notebooks, notes and other info.
 */
function parse_library($path, $notebookURL = "") {
    $notebookFolders = glob($path . '/*.qvnotebook' , GLOB_ONLYDIR);
    $metaTree = array('notebooks' => array(), 'tags' => array());
    foreach ($notebookFolders as $notebookFolder) {
        $mainMeta = json_decode(file_get_contents($notebookFolder . "/meta.json"), true);
        if ($mainMeta['name'] == "Inbox" || $mainMeta['name'] == "Trash") {
            $metaTree[$mainMeta['name']] = array("name" => $mainMeta['name'], 'path' => $notebookFolder);
        } else {
            if (to_url_friendly($mainMeta['name']) == $notebookURL) {
                $metaTree['current notebook'] = array("name" => $mainMeta['name'], 'path' => $notebookFolder);
            }
            $noteCount = count(glob($notebookFolder . '/*.qvnote' , GLOB_ONLYDIR));
            $metaTree['notebooks'][] = array("name" => $mainMeta['name'], 'path' => $notebookFolder, 'note_count' => $noteCount);
        }

    }
    error_log(print_r($metaTree, true));
    return $metaTree;
}

function parse_notebook($notebookData, $noteURL = "") {
    $notesMeta = array();

    $noteFolders = glob($notebookData['path'] . '/*.qvnote' , GLOB_ONLYDIR);
    foreach ($noteFolders as $noteFolder) {
        $noteData = json_decode(file_get_contents($noteFolder . "/meta.json"), true);
        if (to_url_friendly($noteData['title']) == $noteURL) {
            $notebookData['current note'] = array("name" => $noteData['title'], 'path' => $noteFolder);
        }
        $notesMeta[] = $noteData;
    }
    $notebookData['notes'] = $notesMeta;
    return $notebookData;
}




function parse_note($noteData) {
    $noteData['meta'] = json_decode(file_get_contents($noteData['path'] . "/meta.json"), true);
    $noteData['content'] = json_decode(file_get_contents($noteData['path'] . "/content.json"), true);
    return $noteData;
}

$app->get("/tree", function() {
    $quiverLibrary = $_SERVER['DOCUMENT_ROOT'] . "/Quiver.qvlibrary";
    $metaTree = parse_library($quiverLibrary);
});

$app->get("/", function() {
    $quiverLibrary = $_SERVER['DOCUMENT_ROOT'] . "/Quiver.qvlibrary";
    $metaTree = parse_library($quiverLibrary);
    include_once "home.php";
});

$app->get("/:notebookURL", function($notebookURL) {
    $quiverLibrary = $_SERVER['DOCUMENT_ROOT'] . "/Quiver.qvlibrary";
    $metaTree = parse_library($quiverLibrary, $notebookURL);
    $metaTree['current notebook'] = parse_notebook($metaTree['current notebook']);
    error_log(print_r($metaTree, true));
    include_once "notebook.php";
});

$app->get("/:notebookURL/:noteURL", function($notebookURL, $noteURL) {
    $quiverLibrary = $_SERVER['DOCUMENT_ROOT'] . "/Quiver.qvlibrary";
    $metaTree = parse_library($quiverLibrary, $notebookURL);
    $metaTree['current notebook'] = parse_notebook($metaTree['current notebook'], $noteURL);
    error_log(print_r($metaTree, true));
    $metaTree['current notebook']['current note'] = parse_note($metaTree['current notebook']['current note']);
    error_log(print_r($metaTree, true));
    include_once "note.php";
});
$app->run();
