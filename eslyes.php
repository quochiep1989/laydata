<?php
include "simple_html_dom.php";
//http://www.eslyes.com/
//http://www.eslyes.com/easydialogs/
//http://www.eslyes.com/inter/contents.htm
//-----------------------------------------------for extra
//$url = "http://www.eslyes.com/extra/contents.htm";
//$url_page = "http://www.eslyes.com/extra/extra/extras008.htm";
//-----------------------------------------------for inner
$url = "http://www.eslyes.com/inter/contents.htm";
//var_dump(getUrl($url));
//var_dump(getUrlAudio($url_page));
//var_dump(getAllPage($url_page));
$data = array();
$tmp = array();
foreach (getUrl($url) as $i){
    $page = getAllPage($i[0]);
    //--for extra
    //$audio = str_replace("../","http://www.eslyes.com/extra/",$page[0]);
    //--for inner
    $audio = str_replace("../","http://www.eslyes.com/inner/",$page[0]);
    $content  = strip_tags(trim($page[1]),'<p>');
    array_push($tmp,array(substr($i[1],2,strlen($i[1])),$audio,$content));
    array_push($data,$tmp);
    $tmp = array();
}

writeCsv($data);
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
