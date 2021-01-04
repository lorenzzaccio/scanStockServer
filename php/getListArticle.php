<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
$fullArticle = $_GET['fullArticle'];
$prefix = Utils::getPrefix($fullArticle);
$article = Utils::getArticle($fullArticle);
$rootArticle=Utils::getRootArticle($fullArticle);
$typeLetter = substr($prefix,0, 1);
$data = array();
$q="SELECT art_prefix,art_num FROM articles WHERE art_num like '%" . $rootArticle . "' and (art_prefix like '".$typeLetter."__' ) and art_status='1'";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["art_prefix"]."-".$row["art_num"];
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>