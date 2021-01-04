<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$fullArticle = $_GET['fullArticle'];
$numCarton = $_GET['numCarton'];
$numCom = $_GET['numCom'];
$prefix = Utils::getPrefix($fullArticle);
$article = Utils::getArticle($fullArticle);
$data = array();
$q="SELECT stockscan_palette,stockscan_lieu FROM stockScan WHERE stockscan_prefix='" . $prefix . "' and stockscan_article='" . $article . "' and stockscan_numCarton='".$numCarton."' and stockscan_numCom='".$numCom."'";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = mysqli_fetch_assoc($result)){
    $data[]=$row;
    $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>