<?php

include "simple_html_dom.php";
//$page = "http://esl-bits.net/idioms/id4.htm";
//var_dump(getContent($page));
$content = array();
for($i=65;$i<=90;$i++){
    $url = "http://esl-bits.net/idioms/idTit".chr($i).".htm";
    array_push($content, getUrl($url,chr($i)));
    
}
var_dump($content);
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
    $k=0;
    foreach ($html->find('table tr') as $element) {
        $html = str_get_html($element->innertext);
        $content1 = $html->find('td');
        foreach ($content1 as $i) {
            if ($k == 0){
                $tmp['idiom'] = strip_tags($i,'td');
            }else if($k == 1){
                $tmp['mean'] = strip_tags($i,'td');
            }else{
                $tmp['exam'] = strip_tags($i,'td');
            }
            $k++;
        }
        $k=0;
        array_push($array, $tmp);
        //$string = "";
        $tmp = array();
    }
    unset($array[0]);
    return json_encode($array);
}
