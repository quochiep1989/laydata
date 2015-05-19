<?php

//fopen('php://output', 'w');
//header("Expires: 0");
//header('Content-Type: text/csv; charset=utf-8');
//header('Content-Disposition: attachment; filename=dataESL.csv');
//$output = fopen('php://output', 'w');
//header("Expires: 0");
include "simple_html_dom.php";
//$a = 'http://esl.bowvalleycollege.ca/listen/mp3/rent.html';
//var_dump(getQuiz($a));
//var_dump(getAns($a));
//var_dump(positionAns(getQuiz($a),getAns($a)));
//var_dump(getUrl("http://esl.bowvalleycollege.ca/listen/mp3/"));
//var_dump(getUrl("http://esl.bowvalleycollege.ca/listen/mp3/"));
//foreach (getUrl("http://esl.bowvalleycollege.ca/listen/mp3/") as $url){
//    var_dump(positionAns(getQuiz($url),getAns($url)));
//}
//var_dump(getTitle("http://esl.bowvalleycollege.ca/listen/mp3/"));
$url = "http://esl.bowvalleycollege.ca/listen/mp3/";
$tmp = array();
$data = array();
$data_esl = array();
foreach(getUrl($url) as $key=>$i){
    array_push($data,$key);
    array_push($data,json_encode(getQuiz($i)));
    array_push($data_esl,$data);
    $data = array();

}
var_dump($data_esl);
//writeCsv($data_esl, $output);
//var_dump($data_esl);
function getAudio($url) {
    $html = file_get_html($url);
    $string = "";
    foreach ($html->find('script[type="text/javascript"]') as $e) {
        if (strpos($e->innertext, "file"))
            $string = $e->innertext;
    }
    $arg = explode('.', $string);
    return "http://www.esl-lab.com" . $arg[6];
}

function getQuiz($url) {
    $html = file_get_html($url);
    $string = "";
    $data = array();
    foreach ($html->find('form[action="someaction"]') as $e) {
        $string = $e->innertext;
    }
    $string = explode("</li>",$string);
    foreach ($string as $key=>$line){
        if($key == count($string)-1) break;
        $line = explode("<br><br>",$line);
        $question = $line[0];
        $question_detail = $line[1];
        if($key==0){
            $question = str_replace("<ol>","",$question);
            $question = str_replace("<li>","",$question);
        }else{
            $question = str_replace("<br>","",$question);
            $question = str_replace("<li>","",$question);
        }
        $data["data".$key]['quiz'] = ($key+1)." ".trim($question);
        $question_detail = explode("<br>",$question_detail);
        foreach ($question_detail as $key1 => $value) {
            $data["data".$key]['ans'][$key1+1] = trim(strip_tags($value, '<p>'));
        }
        unset( $data["data".$key]['ans'][count($question_detail)]);
    }
    return $data;
}
function getUrl($url){
    $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('a') as $element) {
       array_push($string, $element->href);
    }
    foreach($string as $key=>$line){
        if($key>=12 && $key<(count($string)-1)){
            //$line = str_replace("html","mp3",$line);
            array_push($string1,"http://esl.bowvalleycollege.ca/listen/mp3/".$line);
        }
        
    }
    unset($string1[count($string1)-1]);
    return $string1;
}
function getTitle($url){
     $html = file_get_html($url);
    $string = array();
    $string1 = array();
    foreach($html->find('a') as $element) {
       array_push($string, $element->innertext);
    }
    foreach($string as $key=>$line){
        if($key>=12 && $key<(count($string)-1)){
            array_push($string1,$line);
        }
        
    }
    unset($string1[count($string1)-1]);
    return $string1;
}
function writeCsv($data, $file) {
    foreach ($data as $i) {
       fputcsv($file,$i);
    }
    fclose($file);
}

function getResult($url) {

    $html = file_get_html($url);
    $TABLE = $html->find("table", 4);
    $tmp_dam_thoai = explode("</table>", $TABLE);
    $text_dam_thoai = $tmp_dam_thoai[1];
    $text_dam_thoai = str_replace("<b>", "#", $text_dam_thoai);
    $text_dam_thoai = str_replace("</b>", "^", $text_dam_thoai);
    $text_dam_thoai = str_replace("<p>", "~", $text_dam_thoai);
    $text_dam_thoai = strip_tags($text_dam_thoai);
    $dam_thoai = $text_dam_thoai;
    return $dam_thoai;
    //return $string;
}

function getAns($url) {
    $file = file_get_html($url);
    $tmp_tra_loi = $file->find("script");

    $String = $tmp_tra_loi[0];

    $mang_tmp_tra_loi = explode(";", $String);

    $tra_loi_1 = "";
    $tra_loi_2 = "";
    for ($i = 0; $i < sizeof($mang_tmp_tra_loi); $i++) {
        if (strpos($mang_tmp_tra_loi[$i], "] = ")) {
            $tra_loi_1 = $tra_loi_1 . $mang_tmp_tra_loi[$i] . "<br>";
            $tra_loi_2 = $tra_loi_2 . $mang_tmp_tra_loi[$i] . ";";
        }
        
    }

    $result = str_replace('"',"", $tra_loi_2);
    if(strpos($result,"answers[0] =")){
        $result = str_replace("answers[0] =","",$result);
    }
    if(strpos($result,"answers[1] =")){
        $result = str_replace("answers[1] =","",$result);
    }
    if(strpos($result,"answers[2] =")){
        $result = str_replace("answers[2] =","",$result);
    }
    if(strpos($result,"answers[3] =")){
        $result = str_replace("answers[3] =","",$result);
    }
    if(strpos($result,"answers[4] =")){
        $result = str_replace("answers[4] =","",$result);
    }
    if(strpos($result,"answers[5] =")){
        $result = str_replace("answers[5] =","",$result);
    }
     if(strpos($result,"answers[6] =")){
        $result = str_replace("answers[6] =","",$result);
    }
    if(strpos($result,"answers[7] =")){
        $result = str_replace("answers[7] =","",$result);
    }
     if(strpos($result,"answers[8] =")){
        $result = str_replace("answers[8] =","",$result);
    }
    if(strpos($result,"answers[9] =")){
        $result = str_replace("answers[9] =","",$result);
    }
     if(strpos($result,"answers[10] =")){
        $result = str_replace("answers[10] =","",$result);
    }
    if(strpos($result,"answers[11] =")){
        $result = str_replace("answers[11] =","",$result);
    }
    $result = explode(";", $result);
    $result[0] = substr($result[0],36,  strlen($result[0])-1);
    unset($result[count($result)-1]);         
    return $result;

}
function positionAns($quiz,$ans){
    $result = array(); 
    for($i=0;$i<count($quiz);$i++){ 
        $ans_ques = $ans[$i];
        $ans_ques = str_replace("`","'",$ans_ques);
        foreach ($quiz['data'.$i]['ans'] as $j=>$line){
          
            if(trim($ans_ques) == $line){

                $result['ans'.$i] = $j;
            }
        }
    }
    return $result;
}
?>
