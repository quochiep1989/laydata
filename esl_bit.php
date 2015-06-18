<?php

include "simple_html_dom.php";
//$page = "http://esl-bits.net/idioms/id4.htm";
//var_dump(getContent($page));
$content = array();
$data = array();
for($i=65;$i<=90;$i++){
    $url = "http://esl-bits.net/idioms/idTit".chr($i).".htm";
    $tmp = getUrl($url,chr($i));
    foreach ($tmp as $line){
        array_push($content,array($line[0],$line[2],getContent($line[1])));
    } 
}
writeCsv($content);
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
function writeCsv($data){
    fopen('php://output', 'w');
    header("Expires: 0");header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=dataESL.csv');
    $output = fopen('php://output', 'w');
    header("Expires: 0");
    foreach ($data as $i){
        fputcsv($output,$i);
    }
    fclose($output);
}