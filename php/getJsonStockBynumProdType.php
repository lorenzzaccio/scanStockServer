<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$typeStock = $_GET['stockType'];
$numProd = $_GET['numProd'];
$data = array();
$q = "SELECT sum(stockscan_quantite) as quantity FROM stockScan WHERE stockscan_typeStock='{$typeStock}' and stockscan_numProd like'%{$numProd}'";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = mysqli_fetch_assoc($result)){
    $data[]=$row['quantity'];
    $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>