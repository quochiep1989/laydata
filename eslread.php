<?php
include "simple_html_dom.php";
//-----------------------------------------------for http://www.eslyes.com/eslread/
$url = "http://www.eslyes.com/eslread/";
$url_page = "http://www.eslyes.com/eslread/ss/s344.htm";
$data = array();
$tmp = array();
foreach (getUrl($url) as $key=>$i){
    if($key>350 && $key<=360){
    $page = getAllPage($i[0]);
    array_push($tmp,array($i[1],$page[0],$page[1]));
    array_push($data,$tmp);
    $tmp = array();
    }
   
    //break;
}
writeCsv($data);




function getUrl($url){
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('a') as $element) {
       array_push($string, array("http://www.eslyes.com/eslread/".$element->href,$element->innertext));
    }
    unset($string[0]);
    unset($string[1]);
    unset($string[3]);
    unset($string[2]);
    unset($string[4]);
    return $string;
}

function getAllPage($url_page){
    $html = file_get_html($url_page);
    $string = array();
    foreach($html->find('a') as $element) {
       array_push($string, array($element->href));
    }
    $url_audio = $string[2][0];
    $url_audio = str_replace("../","http://www.eslyes.com/eslread/",$url_audio);
    $string = array();
    foreach($html->find('font') as $element) {
       array_push($string, array($element->innertext));
    }
    $content =  $string[2][0];
    $content = str_replace('</p>',"",$content);
    //$content =  strip_tags($content,'<script>');
    $content = str_replace('<p class="MsoNormal" style="text-indent: .35in; line-height: 150%">','<br>',$content);
    $content = trim($content);
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