<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$fullArticle = $_GET['fullArticle'];

$prefix = Utils::getPrefix($fullArticle);
$article = sprintf("%08d", Utils::getArticle($fullArticle));
$data = array();
$q="SELECT stockscan_id,stockscan_prefix ,stockscan_article,stockscan_lieu,stockscan_typeStock, stockscan_quantite FROM stockScan WHERE stockscan_prefix='" . $prefix . "' and stockscan_article='" . $article . "' group by stockscan_id asc";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=utf8_encode($row["stockscan_id"]).",".utf8_encode($row["stockscan_prefix"])."-".utf8_encode($row["stockscan_article"]).",".utf8_encode($row["stockscan_lieu"]).",".utf8_encode($row["stockscan_typeStock"]).",".utf8_encode($row["stockscan_quantite"]);
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>