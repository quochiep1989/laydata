<?php
//http://www.englishspeak.com/english-lessons.cfm
include "simple_html_dom.php";
$page = "http://www.englishspeak.com/english-lessons.cfm";

$a = getUrl($page);

foreach ($a as $i){
    //var_dump($i);
    var_dump(getContent($i[0]));
}
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
    $data = array();
    $tmp = array();
    foreach($html->find('table[class="blacktext"] tbody table tr') as $element) {
        $string1 = "";
        $string2 = "";
        //array_push($string, array($element->innertext));
        $html = str_get_html($element->innertext);
        $content1 = $html->find('a');
        $content2 = $html->find('img');
        foreach ($content1 as $key=>$i){
            if($key==0){
                $string1 = $i->innertext.":";
            }else{
                $string1 = $string1 ." ". $i->innertext;
            }
        }
        foreach ($content2 as $i){
            $string2 = $i->onclick;
            $string2= str_replace("javascript:playMp3('","", $string2);
            $string2= str_replace("')","", $string2);
        }
        if(!empty($string1)){
            array_push($tmp,array(strip_tags($string1,'span'),$string2)); 
            array_push($data, $tmp);
            $tmp = array();
        }
    }
    return $data;
   
}