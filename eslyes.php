<?php
include "simple_html_dom.php";
//http://www.eslyes.com/
//http://www.eslyes.com/easydialogs/
$url = "http://www.eslyes.com/extra/contents.htm";
$url_page = "http://www.eslyes.com/extra/extra/extras008.htm";

//var_dump(getUrl($url));
//var_dump(getUrlAudio($url_page));
//var_dump(getAllPage($url_page));
function getUrl($url){
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('a') as $element) {
       array_push($string, array($element->href,$element->innertext));
    }
    unset($string[0]);
    unset($string[1]);
    unset($string[2]);
    unset($string[4]);
    unset($string[5]);
    return $string;
}
function getUrlAudio($url_page){
    $html = file_get_html($url_page);
    $string = array();
    foreach($html->find('a') as $element) {
       array_push($string, array($element->href));
    }
    return $string[1][0];
}
function getContent($url_page){
    $html = file_get_html($url_page);
    $string = array();
    foreach($html->find('font') as $element) {
       array_push($string, array($element->innertext));
    }
    return $string[2][0];
}
function getAllPage($url_page){
    $html = file_get_html($url_page);
    $string = array();
    foreach($html->find('a') as $element) {
       array_push($string, array($element->href));
    }
    $url_audio = $string[1][0];
    $string = array();
    foreach($html->find('font') as $element) {
       array_push($string, array($element->innertext));
    }
    $content =  $string[2][0];
    return array($url_audio,$content);
}
