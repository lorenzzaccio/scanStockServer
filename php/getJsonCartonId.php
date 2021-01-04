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
$q="SELECT distinct(stockscan_id) FROM stockScan WHERE stockscan_prefix='" . $prefix . "' and stockscan_article='" . $article . "' and stockscan_numCom='".$numCom."' and stockscan_numCarton='".$numCarton."'";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["stockscan_id"];
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>