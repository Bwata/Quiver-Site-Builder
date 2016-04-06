<?php



function format_text($data) {

    $output = "<section class='text'>";
    $output .= $data['data'];
    $output .="</section>";

    return $output;
}

function format_code($data) {
    $output = "<section class='text'>";

    $output .="</section>";

    return print_r($data, true) . "<br>";
}

function format_markdown($data) {
    $output = "<section class='text'>";

    $output .="</section>";

    return print_r($data, true) . "<br>";
}

function format_latex($data) {
    $output = "<section class='text'>";

    $output .="</section>";

    return print_r($data, true) . "<br>";
}

function format_diagram($data) {
    $output = "<section class='text'>";

    $output .="</section>";

    return print_r($data, true) . "<br>";
}
