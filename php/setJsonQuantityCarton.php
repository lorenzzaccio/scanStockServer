<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$fullArticle = $_GET['fullArticle'];
$numCarton = $_GET['numCarton'];
$numCom = $_GET['numCom'];
$qCarton = $_GET['newQuantity'];
$prefix = Utils::getPrefix($fullArticle);
$article = Utils::getArticle($fullArticle);
$data = array();
$q="UPDATE  stockScan SET stockscan_quantite='".$qCarton."' WHERE stockscan_prefix='" . $prefix . "' and stockscan_article='" . $article . "' and stockscan_numCom='" . $numCom . "' and stockscan_numCarton='" . $numCarton . "'";
//echo $q;
//echo "</BR>";
if($result=$mysqli->query($q)){
    //$data[]="OK";
    echo "ok";
}else{
    echo "ko";
}
//echo "ok";//json_encode(array('groups'=>$data));
?>