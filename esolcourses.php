<?php
//http://www.englishspeak.com/english-lessons.cfm
include "simple_html_dom.php";
$page = "http://www.englishspeak.com/english-lessons.cfm";

$a = getUrl($page);
var_dump(getContent($a[0][0]));
function getUrl($url){
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('a') as $key=>$element) {
       if ($key>=23 && $key <=122){
        array_push($string, array("http://www.englishspeak.com/".$element->href,$element->innertext));
       }
    }
    return $string;
}
function getContent($url_page){
    $html = file_get_html($url_page);
    $string = array();
    foreach($html->find('table[class="blacktext"]') as $element) {
       array_push($string, array($element->innertext));
    }
    $string = explode("</tr>",$string[1][0]);
    foreach ($string as $line){
        $line  = str_replace('<tr class = "DataB">',"",$line);
        $line  = str_replace('<tr class = "DataA">',"",$line);
        
    }
}