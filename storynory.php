<?php
include "simple_html_dom.php";
var_dump(getUrl("http://www.storynory.com/"));
function getUrl($url){
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('a') as $element) {
       array_push($string, $element->href);
    }
    return $string;
}
