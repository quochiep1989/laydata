<?php

include "simple_html_dom.php";
$page = "http://esl-bits.net/idioms/id4.htm";
var_dump(getContent($page));

//for($i=65;$i<=90;$i++){
//    $url = "http://esl-bits.net/idioms/idTit".chr($i).".htm";
//    var_dump (getUrl($url,chr($i)));
//    
//}

function getUrl($url, $key_name) {
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach ($html->find('table a') as $key => $element) {
        array_push($string, array($key_name, "http://esl-bits.net/idioms/" . $element->href, $element->innertext));
    }
    return $string;
}

function getContent($url) {
    $html = file_get_html($url);
    $string = "";
    $array = array();
    $tmp = array();
    foreach ($html->find('table tr') as $element) {
        $html = str_get_html($element->innertext);
        $content1 = $html->find('td');
        foreach ($content1 as $key=>$i) {
            if($key == 0){
                $tmp["idiom"] = $i;
            }
            else if($key == 1){
                $tmp['mean'] = $i;
            }else{
                $tmp['exam'] = $i;
            }
            //$string = $string . $i;
        }
        array_push($array, $tmp);
        //$string = "";
        $tmp = array();
    }
    unset($array[0]);
    return $array;
}
