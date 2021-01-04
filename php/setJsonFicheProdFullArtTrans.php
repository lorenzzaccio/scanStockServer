<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$numProd = $_GET['numProd'];
$stockId = $_GET['stockId'];
$data = array();
$q = "SELECT ficheprod_pref_trans,ficheprod_art_trans FROM ficheProduction WHERE ficheprod_id='" . $numProd . "'";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = mysqli_fetch_assoc($result)){
    $data[]=$row;
    $prefix_trans=$row['ficheprod_pref_trans'];
    $article_trans=$row['ficheprod_art_trans'];
    $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        $q="update stockScan set stockscan_prefix='{$prefix_trans}',stockscan_article='{$article_trans}' where stockscan_id='{$stockId}'";
        if($result=$mysqli->query($q)){
            echo "1";
        }
    }
}
?>