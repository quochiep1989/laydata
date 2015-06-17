<?php
//http://www.learnersdictionary.com/3000-words
include "simple_html_dom.php";
$url_page = "http://www.learnersdictionary.com/3000-words/topic/the-environment/1";
$url_1 = "http://www.learnersdictionary.com/definition/aquifer#ld_entry_v2_jumplink_aquifer_";
//var_dump(getUrl($url_page));
//var_dump(getContent($url_1));
var_dump(getUrl($url_1));
function getUrl($url){
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('a') as $key=>$element) {
       if ($key>=20 && $key<=49){
        array_push($string, array("http://www.learnersdictionary.com".$element->href,trim(str_replace("<!--<sup></sup>-->  										","",$element->innertext))));
       }
    }
    return $string;
}
function getDetail($url){
    
}
function getContent($url_page){
    $html = file_get_html($url_page);
    $string = array();
    foreach($html->find('div[id=ld_entries_v2_all]')  as $element) {
       array_push($string, array($element->innertext));
    }
    return $string;
}

