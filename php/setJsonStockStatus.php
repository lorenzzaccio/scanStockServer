<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$id = $_GET['id'];
$typeStock = $_GET['typeStock'];
$numProd = $_GET['numProd'];
$data = array();
if($numProd!="0"){
    $q = "UPDATE  stockScan SET stockscan_typeStock='" . $typeStock . "',stockscan_numProd='{$numProd}', stockscan_status='1'  WHERE stockscan_id='" . $id . "'";
}else{
    $q = "UPDATE  stockScan SET stockscan_typeStock='" . $typeStock . "', stockscan_status='1' WHERE stockscan_id='" . $id . "'";
}
if ($result = $mysqli->query($q)) {
    echo "ok";
} else {
    echo "ko";
}
?>