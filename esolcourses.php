<?php
//http://www.englishspeak.com/english-lessons.cfm
include "simple_html_dom.php";
$page = "http://www.englishspeak.com/english-lessons.cfm";

$a = getUrl($page);
$data = array();
$tmp = array();
foreach ($a as $i){
    array_push($tmp,array($i[1],getContent($i[0])));
    array_push($data,$tmp);
    $tmp = array();
}
writeCsv($data);
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
        $string3 = "";
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
            $string3 = $string2;
            $string3= str_replace("individual","individualSlow", $string3);
        }
        if(!empty($string1)){
            array_push($tmp,array(strip_tags($string1,'span'),$string3,$string2)); 
            array_push($data, $tmp);
            $tmp = array();
        }
    }
    return json_encode($data);
   
}
function writeCsv($data){
    fopen('php://output', 'w');
    header("Expires: 0");header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=dataESL.csv');
    $output = fopen('php://output', 'w');
    header("Expires: 0");
    foreach ($data as $i){
        fputcsv($output,$i[0]);
    }
    fclose($output);
}