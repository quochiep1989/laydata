<?php
include "simple_html_dom.php";

for($i=65;$i<=90;$i++){
    $url = "http://esl-bits.net/idioms/idTit".chr($i).".htm";
    var_dump (getUrl($url,chr($i)));
}

function getUrl($url,$key_name){
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('table a') as $key=>$element) {    
        array_push($string, array($key_name,"http://www.englishspeak.com/".$element->href,$element->innertext));
    }
    return $string;
}