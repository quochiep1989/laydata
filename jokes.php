<?php
include "simple_html_dom.php";
//"http://www.manythings.org/jokes/"
$url = "http://www.manythings.org/jokes/";
$url_audio = "http://www.manythings.org/jokes/9962.html";
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
    $file = file_get_html($url);
    $tmp_tra_loi = $file->find("div[class='content_main']");

   
    return $tmp_tra_loi;
}

