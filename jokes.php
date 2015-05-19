<?php
include "simple_html_dom.php";
//"http://www.manythings.org/jokes/"
$url = "http://www.manythings.org/jokes/";
$url_audio = "http://www.manythings.org/jokes/9965.html";
var_dump(getAudio($url_audio));
function getUrl($url){
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('a') as $element) {
       array_push($string, array("http://www.manythings.org/jokes/".$element->href,$element->innertext));
    }
    unset($string[38]);
    unset($string[39]);
    unset($string[40]);
    return $string;
}
function getAudio($url){
    $array = array();
    $file = file_get_html($url);
    $myDiv = $file->find('div'); // wherever your the div you're ending up with is
    foreach($myDiv as $e){
        array_push($array, $e->innertext);
    }
    unset($array[0]);
    $string1 = explode("<br />", $array[1]);
    return $string1;
            
}

