<?php
//http://www.eslyes.com/nyc/contents.htm
include "simple_html_dom.php";
$url = "http://www.eslyes.com/nyc/contents.htm";
$url_page = "http://www.eslyes.com/nyc/nyc/nycs018.htm";

//var_dump(getUrl($url));
$tmp =array();
$data = array();
foreach (getUrl($url) as $key=>$i){
    $page = getAllPage("http://www.eslyes.com/nyc/".$i[0]);
    array_push($tmp,array($i[1],$page[0],$page[1]));
    array_push($data,$tmp);
    $tmp = array();

}
writeCsv($data);
function getUrl($url){
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('a') as $key=>$element) {
       if(($key>13) && ($key!=15)&&($key!=16)){
            if($key<100){
                $title = substr($element->innertext,3);
            }else{
                $title = substr($element->innertext,4);

            }
        array_push($string, array($element->href,$title));
       } 
       
    }
    unset($string[760]);
    return $string;
}
function getAllPage($url_page){
    $html = file_get_html($url_page);
    $string = array();
    foreach($html->find('a') as $element) {
       array_push($string, array($element->href));
    }
    $url_audio = $string[1][0];//http://www.eslyes.com/nyc/audio/nyc_018s.mp3
    $url_audio = "http://www.eslyes.com/nyc".substr($url_audio,2,strlen($url_audio));
    $string = array();
    foreach($html->find('font') as $element) {
       array_push($string, array($element->innertext));
    }
    $content = $string[2][0];
    $content = str_replace('<p class="MsoNormal" style="text-indent: .35in; line-height: 150%">','',$content);
    $content = str_replace('</p>','',$content);
    return array($url_audio,trim($content));
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