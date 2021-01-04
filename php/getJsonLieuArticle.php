<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
$fullArticle = $_GET['fullArticle'];
$prefix=Utils::getPrefix($fullArticle);
$article= Utils::getArticle($fullArticle);

$data = array();
$q="SELECT distinct(stockscan_lieu) FROM stockScan WHERE stockscan_prefix='" . $prefix . "' and stockscan_article='" . $article . "'";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["stockscan_lieu"];
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>
