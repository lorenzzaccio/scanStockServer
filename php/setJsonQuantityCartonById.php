<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$stockId = $_GET['stockId'];
$qCarton = $_GET['qCarton'];
$q="UPDATE stockScan SET stockscan_quantite='".$qCarton."' WHERE stockscan_id='" . $stockId . "'";
//echo $q;
if($result=$mysqli->query($q)){
    //$data[]="OK";
    echo "ok";
}else{
    echo "ko";
}
?>